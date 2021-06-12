<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\CommonFunction;
use common\models\LeadRecruiterJobSeekerMapping;
use common\models\LeadRecruiterJobSeekerMappingSearch;
use yii\web\NotFoundHttpException;

/**
 * BrowseJobs controller
 */
class LeadsReceivedController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'approval-form', 'approval-from-recruiter', 'approval-from-employer'],
                'rules' => [
                        [
                        'actions' => ['index', 'approval-form', 'approval-from-recruiter', 'approval-from-employer'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::isRecruiter() || CommonFunction::isEmployer() ? ['@'] : ['*'] : ['*'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    public function actionIndex() {
        $loggedUserBranchId = (Yii::$app->user->identity->branch_id) ? Yii::$app->user->identity->branch_id : '';
        $searchModelPending = new LeadRecruiterJobSeekerMappingSearch();
        $searchModelPending->loggedUserBranchId = $loggedUserBranchId;
        $dataProviderPending = $searchModelPending->searchLeadsReceivedPending(Yii::$app->request->queryParams);
        
        $searchModelInprogress = new LeadRecruiterJobSeekerMappingSearch();
        $searchModelInprogress->loggedUserBranchId = $loggedUserBranchId;
        $dataProviderInprogress = $searchModelInprogress->searchLeadsReceivedInprogress(Yii::$app->request->queryParams);
        
        $searchModelSelected = new LeadRecruiterJobSeekerMappingSearch();
        $searchModelSelected->loggedUserBranchId = $loggedUserBranchId;
        $dataProviderSelected = $searchModelSelected->searchLeadsReceivedSelected(Yii::$app->request->queryParams);
        
        $searchModelRejected = new LeadRecruiterJobSeekerMappingSearch();
        $searchModelRejected->loggedUserBranchId = $loggedUserBranchId;
        $dataProviderRejected = $searchModelRejected->searchLeadsReceivedRejected(Yii::$app->request->queryParams);
        
        
        return $this->render('index', [
                    'searchModelPending' => $searchModelPending,
                    'searchModelInprogress' => $searchModelInprogress,
                    'searchModelSelected' => $searchModelSelected,
                    'searchModelRejected' => $searchModelRejected,
                    'dataProviderPending' => $dataProviderPending,
                    'dataProviderInprogress' => $dataProviderInprogress,
                    'dataProviderSelected' => $dataProviderSelected,
                    'dataProviderRejected' => $dataProviderRejected
        ]);
    }

    public function actionApprovalForm($lrj, $status) {
        $model = LeadRecruiterJobSeekerMapping::findOne($lrj);
        if ($model != null) {
            if (CommonFunction::isRecruiter()) {
                $model->rec_joining_date = ($model->rec_joining_date) ? date('d-M-Y', strtotime($model->rec_joining_date)) : null;
                $model->scenario = ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) ? 'rec_approve' : 'rec_reject';
            } else {
                $model->scenario = ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) ? 'employer_approve' : 'employer_reject';
            }

            return $this->renderAjax('_recruiter_approval_form', ['model' => $model, 'status' => $status]);
        }
        throw new NotFoundHttpException("In valid action.");
    }

    public function actionApprovalFromRecruiter($lrj, $status) {
        $model = LeadRecruiterJobSeekerMapping::findOne($lrj);
        if ($model != null) {
            try {
                $model->load(Yii::$app->request->post());
                $model->rec_comment = ($model->rec_comment != '') ? $model->rec_comment : NULL;
                $model->rec_joining_date = ($model->rec_joining_date != '') ? date("Y-m-d", strtotime($model->rec_joining_date)) : '';
                $model->rec_status = ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) ? LeadRecruiterJobSeekerMapping::STATUS_APPROVED : LeadRecruiterJobSeekerMapping::STATUS_REJECTED;
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = CommonFunction::currentTimestamp();
                if ($model->save(false)) {
                    if ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) {
                        $flashMsgType = "warning";
                        $flashMsg = "Application approved successfully, but there is some issue while sending mail.";
                        $jobSeekerMailSent = $model->sendMailToJobSeekerAboutRecruiterApproval();

                        if (CommonFunction::isLeadAppliedBranchAndPostedBranchSame($model->lead_id, $model->branch_id)) {
                            $model->employer_status = LeadRecruiterJobSeekerMapping::STATUS_APPROVED;
                            $model->save(false);
                            if ($jobSeekerMailSent['status'] == '1') {
                                $flashMsg = "Application approved successfully.";
                                $flashMsgType = "success";
                            }
                        } else {
                            $employerMailSent = $model->sendMailToEmployerAboutRecruiterApproval();
                            if ($jobSeekerMailSent['status'] == '1' && $employerMailSent['status'] == '1') {
                                $flashMsg = "Application approved successfully.";
                                $flashMsgType = "success";
                            }
                        }
                    } else {
                        $flashMsg = "Application rejected successfully, but there is some issue while sending mail.";
                        $jobSeekerMailSent = $model->sendMailToJobSeekerAboutRecruiterRejection();

                        if ($jobSeekerMailSent['status'] == '1' && $jobSeekerMailSent['status'] == '1') {
                            $flashMsg = "Application rejected successfully.";
                            $flashMsgType = "success";
                        }
                    }
                    Yii::$app->session->setFlash($flashMsgType, $flashMsg);
//                return $this->redirect(['index']);
                    echo json_encode(['code' => '200']);
                    exit;
                }
            } catch (\Exception $ex) {
                Yii::$app->session->setFlash("error", "Something went wrong");
                echo json_encode(['code' => '500']);
                exit;
            }
        }
        throw new NotFoundHttpException("In valid action.");
    }

    public function actionApprovalFromEmployer($lrj, $status) {
        $model = LeadRecruiterJobSeekerMapping::findOne($lrj);
        if ($model != null) {

            try {
                $model->load(Yii::$app->request->post());
                $model->employer_comment = ($model->employer_comment != '') ? $model->employer_comment : NULL;
                $model->employer_status = ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) ? LeadRecruiterJobSeekerMapping::STATUS_APPROVED : LeadRecruiterJobSeekerMapping::STATUS_REJECTED;
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = CommonFunction::currentTimestamp();
                if ($model->save(false)) {
                    if ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) {
                        $flashMsgType = "warning";
                        $flashMsg = "Application approved successfully, but there is some issue while sending mail.";
                        
                        $recruiterMailSent = $model->sendMailToRecruiterAboutApproveLeadByEmployer();
                        if ($recruiterMailSent['status'] == '1') {
                            $flashMsg = "Application approved successfully.";
                            $flashMsgType = "success";
                        }
                    } else {
                        $flashMsg = "Application rejected successfully, but there is some issue while sending mail.";
                        $recruiterMailSent = $model->sendMailToRecruiterAboutRejectLeadByEmployer();
                        if ($recruiterMailSent['status'] == '1') {
                            $flashMsg = "Application rejected successfully.";
                            $flashMsgType = "success";
                        }
                    }
                    Yii::$app->session->setFlash($flashMsgType, $flashMsg);
                    echo json_encode(['code' => '200']);
                    exit;
                }
            } catch (\Exception $ex) {
                Yii::$app->session->setFlash("error", "Something went wrong");
                echo json_encode(['code' => '500']);
                exit;
            }
        }
        throw new NotFoundHttpException("In valid action.");
    }

    /*     * ** END BY MOHAN*** */
}
