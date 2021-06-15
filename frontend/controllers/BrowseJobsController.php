<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LeadMaster;
use common\CommonFunction;
use common\models\CompanyBranch;
use common\models\Benefits;
use common\models\Speciality;
use common\models\Discipline;
use yii\helpers\ArrayHelper;
use common\models\LeadDiscipline;
use common\models\LeadBenefit;
use common\models\LeadSpeciality;
use yii\helpers\Json;
use yii\web\Response;
use common\models\Cities;
use common\models\LeadMasterSearch;
use common\models\LeadRecruiterJobSeekerMapping;
use common\models\LeadRecruiterJobSeekerMappingSearch;
use yii\web\NotFoundHttpException;
use common\models\Emergency;
use common\models\LeadRating;
use common\models\LeadEmergency;

/**
 * BrowseJobs controller
 */
class BrowseJobsController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['recruiter-lead', 'recruiter-view', 'apply', 'apply-job', 'view'],
                'rules' => [
                    [
                        'actions' => ['apply', 'apply-job', 'view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? ['@'] : ['*']
                    ],
                    [
                        'actions' => ['recruiter-lead', 'recruiter-view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::isRecruiter() ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['recruiter-view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::isEmployer() ? ['@'] : ['*'] : ['*'],
                    ]
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
        $request = \Yii::$app->getRequest()->get();
        $query = LeadMaster::find()->joinWith(['benefits', 'disciplines', 'specialty', 'branch', 'emergency'])->where(['lead_master.status' => LeadMaster::STATUS_APPROVED]);
        if (isset($request['discipline']) && !empty($request['discipline'])) {
            $query->andFilterWhere(['IN', 'lead_discipline.discipline_id', implode(',', $request['discipline'])]);
        }
        if (isset($request['speciality']) && !empty($request['speciality'])) {
            $query->andFilterWhere(['IN', 'lead_speciality.speciality_id', implode(',', $request['speciality'])]);
        }
        if (isset($request['benefit']) && !empty($request['benefit'])) {
            $query->andFilterWhere(['IN', 'lead_benefit.benefit_id', implode(',', $request['benefit'])]);
        }
        if (isset($request['location']) && !empty($request['location'])) {
            $query->andFilterWhere(['IN', 'lead_master.city', implode(',', $request['location'])]);
        }
        if (isset($request['emergency']) && !empty($request['emergency'])) {
            $query->andFilterWhere(['IN', 'lead_emergency.emergency_id', implode(',', $request['emergency'])]);
        }
        if (isset($request['salary']) && !empty($request['salary'])) {
            foreach ($request['salary'] as $value) {
                if ($value == 1) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 0]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 100]);
                }
                if ($value == 2) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 100]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 199]);
                }
                if ($value == 3) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 199]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 499]);
                }
                if ($value == 4) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 499]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 999]);
                }
                if ($value == 5) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 999]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 4999]);
                }
                if ($value == 6) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 4999]);
                }
            }
        }

        $query->groupBy(['lead_master.id']);
        $query->orderBy(['lead_master.created_at' => SORT_DESC]);
//        echo "<pre/>";print_r($query->createCommand()->rawSql);exit;
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        if (isset($request['location']) && !empty($request['location'])) {
            $selectedLocations = ArrayHelper::map(Cities::find()->where(['IN', 'id', $request['location']])->all(), 'id', 'city');
        } else {
            $selectedLocations = [];
        }

        return $this->render('index', ['models' => $models, 'pages' => $pages, 'selectedLocations' => $selectedLocations]);
    }

    public function actionRecruiterLead() {
        $request = \Yii::$app->getRequest()->get();
        $query = LeadMaster::find()->joinWith(['benefits', 'disciplines', 'specialty', 'branch', 'emergency'])->where(['lead_master.status' => LeadMaster::STATUS_APPROVED]);
        if (isset($request['discipline']) && !empty($request['discipline'])) {
            $query->andFilterWhere(['IN', 'lead_discipline.discipline_id', implode(',', $request['discipline'])]);
        }
        if (isset($request['speciality']) && !empty($request['speciality'])) {
            $query->andFilterWhere(['IN', 'lead_speciality.speciality_id', implode(',', $request['discipline'])]);
        }
        if (isset($request['benefit']) && !empty($request['benefit'])) {
            $query->andFilterWhere(['IN', 'lead_benefit.benefit_id', implode(',', $request['benefit'])]);
        }
        if (isset($request['location']) && !empty($request['location'])) {
            $query->andFilterWhere(['IN', 'lead_master.city', implode(',', $request['location'])]);
        }
        if (isset($request['emergency']) && !empty($request['emergency'])) {
            $query->andFilterWhere(['IN', 'lead_emergency.emergency_id', implode(',', $request['emergency'])]);
        }
        if (isset($request['salary']) && !empty($request['salary'])) {
            foreach ($request['salary'] as $value) {
                if ($value == 1) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 0]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 100]);
                }
                if ($value == 2) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 100]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 199]);
                }
                if ($value == 3) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 199]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 499]);
                }
                if ($value == 4) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 499]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 999]);
                }
                if ($value == 5) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 999]);
                    $query->andFilterWhere(['<=', 'jobseeker_payment', 4999]);
                }
                if ($value == 6) {
                    $query->andFilterWhere(['>=', 'jobseeker_payment', 4999]);
                }
            }
        }
        $query->groupBy(['lead_benefit.lead_id', 'lead_discipline.lead_id', 'lead_speciality.lead_id', 'lead_master.id']);

        $query->orderBy(['lead_master.created_at' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        if (isset($request['location']) && !empty($request['location'])) {
            $selectedLocations = ArrayHelper::map(Cities::find()->where(['IN', 'id', $request['location']])->all(), 'id', 'city');
        } else {
            $selectedLocations = [];
        }
        return $this->render('recruiter-lead', ['models' => $models, 'pages' => $pages, 'selectedLocations' => $selectedLocations]);
    }

    public function actionGetDiscipline() {
        $request = Yii::$app->getRequest()->post();
        $page = isset($request['page']) ? $request['page'] : 0;
        $filter = isset($request['filter']) && !empty($request['filter']) ? explode(',', $request['filter']) : [];
        $offset = isset($page) && !empty($page) ? $page : 0;
        $limit = 10;
        $totalRecord = Discipline::find()->count();
        $lists = ArrayHelper::map(Discipline::find()->limit($limit)->offset($offset)->all(), 'id', 'name');
        $options = "";

        if (isset($lists) && !empty($lists)) {
            foreach ($lists as $key => $list) {
                $options .= "<li>";
                if (in_array($key, $filter)) {
                    $options .= "<input type='checkbox' name='discipline[]' value='$key' id='desc-$key' checked />";
                } else {
                    $options .= "<input type='checkbox' name='discipline[]' value='$key' id='desc-$key' />";
                }
                $options .= "<label for='desc-$key'></label>" . $list;
                $options .= "</li>";
            }
        } else {
            $options .= "<li>-</li>";
        }

        $response = ['options' => $options, 'totalPage' => $totalRecord, 'offset' => count($lists)];
        echo Json::encode($response);
        exit;
    }

    public function actionGetSpecialty() {
        $request = Yii::$app->getRequest()->post();
        $page = isset($request['page']) ? $request['page'] : 0;
        $filter = isset($request['filter']) && !empty($request['filter']) ? explode(',', $request['filter']) : [];
        $offset = isset($page) && !empty($page) ? $page : 0;
        $limit = 10;
        $totalRecord = Speciality::find()->count();
        $lists = ArrayHelper::map(Speciality::find()->limit($limit)->offset($offset)->all(), 'id', 'name');
        $options = "";
        if (isset($lists) && !empty($lists)) {
            foreach ($lists as $key => $list) {
                $options .= "<li>";
                if (in_array($key, $filter)) {
                    $options .= "<input type='checkbox' name='speciality[]' value='$key' id='spec-$key' checked />";
                } else {
                    $options .= "<input type='checkbox' name='speciality[]' value='$key' id='spec-$key' />";
                }
                $options .= "<label for='spec-$key'></label>" . $list;
                $options .= "</li>";
            }
        } else {
            $options .= "<li>-</li>";
        }
        $response = ['options' => $options, 'totalPage' => $totalRecord, 'offset' => count($lists)];
        echo Json::encode($response);
        exit;
    }

    public function actionGetBenefits() {
        $request = Yii::$app->getRequest()->post();
        $page = isset($request['page']) ? $request['page'] : 0;
        $filter = isset($request['filter']) && !empty($request['filter']) ? explode(',', $request['filter']) : [];
        $offset = isset($page) && !empty($page) ? $page : 0;
        $limit = 10;
        $totalRecord = Benefits::find()->count();
        $lists = ArrayHelper::map(Benefits::find()->limit($limit)->offset($offset)->all(), 'id', 'name');
        $options = "";
        if (isset($lists) && !empty($lists)) {
            foreach ($lists as $key => $list) {
                $options .= "<li>";
                if (in_array($key, $filter)) {
                    $options .= "<input type='checkbox' name='benefit[]' value='$key' id='benefit-$key' checked />";
                } else {
                    $options .= "<input type='checkbox' name='benefit[]' value='$key' id='benefit-$key' />";
                }
                $options .= "<label for='benefit-$key'></label>" . $list;
                $options .= "</li>";
            }
        } else {
            $options .= "<li>-</li>";
        }
        $response = ['options' => $options, 'totalPage' => $totalRecord, 'offset' => count($lists)];
        echo Json::encode($response);
        exit;
    }

    public function actionGetEmergency() {
        $request = Yii::$app->getRequest()->post();
        $page = isset($request['page']) ? $request['page'] : 0;
        $filter = isset($request['filter']) && !empty($request['filter']) ? explode(',', $request['filter']) : [];
        $offset = isset($page) && !empty($page) ? $page : 0;
        $limit = 10;
        $totalRecord = Emergency::find()->count();
        $lists = ArrayHelper::map(Emergency::find()->limit($limit)->offset($offset)->all(), 'id', 'name');
        $options = "";
        if (isset($lists) && !empty($lists)) {
            foreach ($lists as $key => $list) {
                $options .= "<li>";
                if (in_array($key, $filter)) {
                    $options .= "<input type='checkbox' name='emergency[]' value='$key' id='eme-$key' checked />";
                } else {
                    $options .= "<input type='checkbox' name='emergency[]' value='$key' id='eme-$key' />";
                }
                $options .= "<label for='eme-$key'></label>" . $list;
                $options .= "</li>";
            }
        } else {
            $options .= "<li>-</li>";
        }
        $response = ['options' => $options, 'totalPage' => $totalRecord, 'offset' => count($lists)];
        echo Json::encode($response);
        exit;
    }

    public function actionGetCities($page, $q = null, $id = null) {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'name' => '']];
        if (!is_null($q) && !empty($q)) {
            $query = new \yii\db\Query;
            $query->select(['cities.id', 'CONCAT(city,"-",cities.state_code) as name'])
                    ->from('cities')
                    ->innerJoin('states', 'states.id=cities.state_id')
                    ->where(['like', 'cities.city', $q])
                    ->offset($offset)
                    ->limit($limit);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            $out['pagination'] = ['more' => !empty($data) ? true : false];
        } elseif ($id > 0) {
            $query = new \yii\db\Query;
            $query->select(['cities.id', 'CONCAT(city,"-",cities.state_code) as name'])
                    ->from('cities')
                    ->innerJoin('states', 'states.id=cities.state_id')
                    ->where(['in', 'cities.id', $id])
                    ->offset($offset)
                    ->limit($limit);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            $out['pagination'] = ['more' => !empty($data) ? true : false];
        }
        return $out;
    }

    public function actionView($id) {
        $model = LeadMaster::findOne(['id' => $id]);
        $today = date('Y-m-d');
        $advertisment = \common\models\Advertisement::find()->where(['is_active' => '1'])->andWhere(['location' => $model->city])->andWhere("'$today' BETWEEN active_from AND active_to")->asArray()->all();
        if ($model != null) {
            $benefit = LeadBenefit::findAll(['lead_id' => $id]);
            $specialty = LeadSpeciality::findAll(['lead_id' => $id]);
            $discipline = LeadDiscipline::findAll(['lead_id' => $id]);
            $emergency = LeadEmergency::findAll(['lead_id' => $id]);
            return $this->render('view', ['model' => $model, 'benefit' => $benefit, 'specialty' => $specialty, 'discipline' => $discipline, 'emergency' => $emergency, 'advertisment' => $advertisment]);
        } else {
            throw new \yii\web\NotFoundHttpException("In valid lead");
        }
    }

    public function actionRecruiterView($id) {
        $model = LeadMaster::findOne(['id' => $id]);
        $today = date('Y-m-d');
        $advertisment = \common\models\Advertisement::find()->where(['is_active' => '1'])->andWhere(['location' => $model->city])->andWhere("'$today' BETWEEN active_from AND active_to")->asArray()->all();
        $benefit = LeadBenefit::findAll(['lead_id' => $id]);
        $specialty = LeadSpeciality::findAll(['lead_id' => $id]);
        $discipline = LeadDiscipline::findAll(['lead_id' => $id]);
        $emergency = LeadEmergency::findAll(['lead_id' => $id]);
        return $this->render('recruiter-view', ['model' => $model, 'benefit' => $benefit, 'specialty' => $specialty, 'discipline' => $discipline, 'emergency' => $emergency, 'advertisment' => $advertisment]);
    }

    /*     * ******** ADDED BY MOHAN*** */

    public function actionApply($ref) {
        $model = LeadMaster::findOne(['reference_no' => $ref]);
        if ($model != null) {
            $searchModel = new LeadMasterSearch();
            $searchModel->loggedInUserId = Yii::$app->user->identity->id;
            $dataProvider = $searchModel->searchJobApplicableBranchList(Yii::$app->request->queryParams);
            return $this->render('apply', ['model' => $model, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
        } else {
            throw new NotFoundHttpException("In valid lead");
        }
    }

    public function actionApplyJob($lead_id, $branch_id) {
        $loggedInUserId = Yii::$app->user->identity->id;
        $model = LeadRecruiterJobSeekerMapping::findOne(['lead_id' => $lead_id, 'branch_id' => $branch_id, 'job_seeker_id' => $loggedInUserId]);
        if ($model == null) {
            $model = new LeadRecruiterJobSeekerMapping();
            $model->lead_id = $lead_id;
            $model->branch_id = $branch_id;
            $model->job_seeker_id = $loggedInUserId;
            $model->updated_at = CommonFunction::currentTimestamp();
            $model->updated_by = $loggedInUserId;
            if ($model->save()) {
                $mailSent = $model->sendMailToBranch();
                if ($mailSent['status'] == '1') {
                    Yii::$app->session->setFlash("success", "Job applied successfully.");
                } else {
                    Yii::$app->session->setFlash("warning", "Job applied successfully, but there was a issue while sending the mail.");
                }
            }
            $ref = LeadMaster::findOne($lead_id)->reference_no;
        } else {
            Yii::$app->session->setFlash("warning", "You have already applied to this branch");
        }
        $ref = LeadMaster::findOne($lead_id)->reference_no;
        $this->redirect(['apply', 'ref' => $ref]);
    }

    public function actionTrackMyApplication() {
        $searchModel = new LeadRecruiterJobSeekerMappingSearch();
        $searchModel->loggedInUserId = Yii::$app->user->identity->id;
        $dataProvider = $searchModel->searchMyApplication(Yii::$app->request->queryParams);
        return $this->render('track-my-application', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionSetRating() {
        $postedData = Yii::$app->request->post();
        if (!empty($postedData) && isset($postedData['leadId']) && $postedData['leadId'] != '' && isset($postedData['rating']) && $postedData['rating'] != '') {
            $model = new LeadRating();
            $isSaved = $model->saveRating(Yii::$app->user->identity->id, $postedData['leadId'], $postedData['rating']);
            if ($isSaved == true) {
                echo json_encode(['code' => 200]);
            } else {
                echo json_encode(['code' => 201, 'errors' => $isSaved]);
            }
        }
    }

//    public function actionLeadsReceived() {
//        $searchModel = new LeadRecruiterJobSeekerMappingSearch();
//        $searchModel->loggedUserBranchId = (Yii::$app->user->identity->branch_id) ? Yii::$app->user->identity->branch_id : '';
//
//        $dataProviderPending = $searchModel->searchLeadsReceivedPending(Yii::$app->request->queryParams);
//        $dataProviderInprogress = $searchModel->searchLeadsReceivedInprogress(Yii::$app->request->queryParams);
//        $dataProviderSelected = $searchModel->searchLeadsReceivedSelected(Yii::$app->request->queryParams);
//        $dataProviderRejected = $searchModel->searchLeadsReceivedRejected(Yii::$app->request->queryParams);
//        return $this->render('leads-received', [
//                    'searchModel' => $searchModel,
//                    'dataProviderPending' => $dataProviderPending,
//                    'dataProviderInprogress' => $dataProviderInprogress,
//                    'dataProviderSelected' => $dataProviderSelected,
//                    'dataProviderRejected' => $dataProviderRejected
//        ]);
//    }
//    public function actionRecruiterApprovalForm($lrj, $status) {
//        $model = LeadRecruiterJobSeekerMapping::findOne($lrj);
//        if ($model != null) {
//            $model->rec_joining_date = ($model->rec_joining_date) ? date('d-M-Y', strtotime($model->rec_joining_date)) : null;
//            $model->scenario = ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) ? 'rec_approve' : 'rec_reject';
//            return $this->renderAjax('_recruiter_approval_form', ['model' => $model, 'status' => $status]);
//        }
//        throw new NotFoundHttpException("In valid action.");
//    }
//    public function actionApprovalFromRecruiter($lrj, $status) {
//        $model = LeadRecruiterJobSeekerMapping::findOne($lrj);
//        if ($model != null) {
//            $model->load(Yii::$app->request->post());
//            $model->rec_comment = ($model->rec_comment != '') ? $model->rec_comment : NULL;
//            $model->rec_joining_date = ($model->rec_joining_date != '') ? date("Y-m-d", strtotime($model->rec_joining_date)) : '';
//            $model->rec_status = ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) ? LeadRecruiterJobSeekerMapping::STATUS_APPROVED : LeadRecruiterJobSeekerMapping::STATUS_REJECTED;
//            $model->updated_by = Yii::$app->user->identity->id;
//            $model->updated_at = CommonFunction::currentTimestamp();
//            if ($model->save(false)) {
//                if ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) {
//                    $flashMsgType = "warning";
//                    $flashMsg = "Application approved successfully, but there is some issue while sending mail.";
//                    $jobSeekerMailSent = $model->sendMailToJobSeekerAboutRecruiterApproval();
//
//                    if (CommonFunction::isLeadAppliedBranchAndPostedBranchSame($model->lead_id, $model->branch_id)) {
//                        $model->employer_status = LeadRecruiterJobSeekerMapping::STATUS_APPROVED;
//                        $model->save(false);
//                        if ($jobSeekerMailSent['status'] == '1') {
//                            $flashMsg = "Application approved successfully.";
//                            $flashMsgType = "success";
//                        }
//                    } else {
//                        $employerMailSent = $model->sendMailToEmployerAboutRecruiterApproval();
//                        if ($jobSeekerMailSent['status'] == '1' && $employerMailSent['status'] == '1') {
//                            $flashMsg = "Application approved successfully.";
//                            $flashMsgType = "success";
//                        }
//                    }
//                } else {
//                    $flashMsg = "Application rejected successfully, but there is some issue while sending mail.";
//                    $jobSeekerMailSent = $model->sendMailToJobSeekerAboutRecruiterRejection();
//
//                    if ($jobSeekerMailSent['status'] == '1' && $jobSeekerMailSent['status'] == '1') {
//                        $flashMsg = "Application rejected successfully.";
//                        $flashMsgType = "success";
//                    }
//                }
//                Yii::$app->session->setFlash($flashMsgType, $flashMsg);
//                return $this->redirect(['leads-received']);
//            }
//        }
//        throw new NotFoundHttpException("In valid action.");
//    }

    /*     * ** END BY MOHAN*** */
}
