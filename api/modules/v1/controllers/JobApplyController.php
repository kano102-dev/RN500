<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Json;
use api\modules\v1\components\Controller;
use common\models\LeadMasterSearch;
use common\models\LeadRecruiterJobSeekerMapping;
use common\models\LeadMaster;
use common\CommonFunction;
use common\models\LeadRecruiterJobSeekerMappingSearch;
use yii\db\Expression;
use common\models\LeadRating;

/**
 * Company Controller API
 */
class JobApplyController extends Controller {

    public $modelClass = 'common\models\LeadRecruiterJobSeekerMapping';

    public function actionTest() {
        echo "Job Apply APIs Working";
        exit;
    }

    public function actionGetBranchList() {
        $data = [];
        $code = 201;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        try {
            $paging = (isset($request['page']) && $request['page'] != '' && $request['page'] != 0) ? $request['page'] : 1;
            $search = (isset($request['filter']) && !empty($request['filter'])) ? $request['filter'] : '';
            $reference_no = (isset($request['reference_no']) && !empty($request['reference_no'])) ? trim($request['reference_no']) : '';
            $branchList = [];

            if ($reference_no != '') {
                $searchModel = new LeadMasterSearch();
                $searchModel->loggedInUserId = $this->user_id;
                $dataProvider = $searchModel->searchJobApplicableBranchList(['ref' => $reference_no]);
                $query = $dataProvider->query;

                if ($search != '') {
                    $query->andWhere(['OR', ['LIKE', 'branch.branch_name', $search], ['LIKE', "IF(subscribed_companies.company_name IS NOT NULL ,subscribed_companies.company_name,`company`.`company_name`)", $search]]);
                }

                $total_pages = (ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])) ? ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT']) : 1;
                if ($paging <= $total_pages) {
                    $query->offset(($paging - 1) * Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])->limit(Yii::$app->params['API_PAGINATION_RECORD_LIMIT']);
                    $lists = $query->all();
                    foreach ($lists as $model) {
                        $branchList[] = ['branch_id' => (string) $model->id, 'branch_name' => $model->branch_name, 'company_name' => $model->company_name, 'is_already_applied' => $model->is_already_applied];
                    }
                }
                $code = 200;
                $msg = "Success";
                $data = $branchList;
            } else {
                $data = [];
                $code = 201;
                $msg = "Required Data Missing in Request : reference_no";
            }
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

    public function actionSubmit() {
        $data = [];
        $code = 201;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        try {
            $reference_no = (isset($request['reference_no']) && !empty($request['reference_no'])) ? $request['reference_no'] : '';
            $branch_id = (isset($request['branch_id']) && !empty($request['branch_id'])) ? $request['branch_id'] : '';

            if ($reference_no != '' && $branch_id) {
                $lead = LeadMaster::find()->where(['reference_no' => $reference_no])->one();
                if ($lead != null) {
                    $loggedInUserId = $this->user_id;
                    $model = LeadRecruiterJobSeekerMapping::findOne(['lead_id' => $lead->id, 'branch_id' => $branch_id, 'job_seeker_id' => $loggedInUserId]);
                    if ($model == null) {
                        $model = new LeadRecruiterJobSeekerMapping();
                        $model->lead_id = $lead->id;
                        $model->branch_id = $branch_id;
                        $model->job_seeker_id = $loggedInUserId;
                        $model->updated_at = CommonFunction::currentTimestamp();
                        $model->updated_by = $loggedInUserId;
                        if ($model->save()) {
                            $mailSent = $model->sendMailToBranch();
                            $code = 200;
                            $msg = ($mailSent['status'] == '1') ? 'Job applied successfully.' : 'Job applied successfully, but there was a issue while sending the mail.';
                            $data = [];
                        } else {
                            $code = 205;
                            $msg = 'Something went wrong.';
                            $data = [];
                        }
                    } else {
                        $code = 202;
                        $msg = "You have already applied to this branch.";
                        $data = [];
                    }
                } else {
                    $code = 202;
                    $msg = "Lead with such reference does not exists.";
                    $data = [];
                }
            } else {
                $data = [];
                $code = 201;
                $msg = "Required Data Missing in Request : reference_no, branch_id";
            }
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

    public function actionTrackMyApplications() {
        $data = [];
        $code = 201;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        try {
            $paging = (isset($request['page']) && $request['page'] != '' && $request['page'] != 0) ? $request['page'] : 1;
            $search = (isset($request['filter']) && !empty($request['filter'])) ? $request['filter'] : '';

            $leadList = [];

            $searchModel = new LeadRecruiterJobSeekerMappingSearch();
            $searchModel->loggedInUserId = $this->user_id;
            $dataProvider = $searchModel->searchMyApplication([]);

//            $searchModel = new LeadMasterSearch();
//            $searchModel->loggedInUserId = $this->user_id;
//            $dataProvider = $searchModel->searchJobApplicableBranchList(['ref' => $reference_no]);
            $query = $dataProvider->query;

            if ($search != '') {
                $query->andWhere(['OR',
                        ['like', 'lead.title', $search],
                        ['like', 'lead.reference_no', $search],
                        ['like', new Expression('CONCAT(lead.title, " (", lead.reference_no, ")")'), $search],
                        ['like', 'recruiter_company.company_name', $search],
                        ['like', 'recruiter_branch.branch_name', $search],
                        ['like', new Expression('CONCAT(recruiter_company.company_name, " ( ", recruiter_branch.branch_name, " ) ")'), $search],
                        ['like', 'cities.city', $search]
                ]);
            }

            $total_pages = (ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])) ? ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT']) : 1;
            if ($paging <= $total_pages) {
                $query->offset(($paging - 1) * Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])->limit(Yii::$app->params['API_PAGINATION_RECORD_LIMIT']);
                $lists = $query->all();
                foreach ($lists as $model) {
                    $leadList[] = ['lead_id' => (string) $model->lead_id, 'leadTitleWithRef' => (string) $model->leadTitleWithRef, 'cityName' => $model->cityName, 'recruiterComapnyWithBranch' => $model->recruiterComapnyWithBranch, 'statusText' => $model->statusText, 'rating' => $model->rating];
                }
            }
            $code = 200;
            $msg = "Success";
            $data = $leadList;
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

    public function actionSetRating() {
        $data = [];
        $code = 201;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        try {
            $lead_id = (isset($request['lead_id']) && !empty($request['lead_id'])) ? $request['lead_id'] : '';
            $rating = (isset($request['rating']) && !empty($request['rating'])) ? $request['rating'] : '';

            if ($lead_id != '' && $rating != '') {
                $lead = LeadMaster::find()->where($lead_id)->one();
                if ($lead != null) {
                    $model = new LeadRating();
                    $isSaved = $model->saveRating($this->user_id, $lead_id, $rating);
                    if ($isSaved == true) {
                        $code = 200;
                        $msg = "Rating was given successfully.";
                        $data = [];
                    } else {
                        echo json_encode(['code' => 201, 'errors' => $isSaved]);
                    }
                } else {
                    $code = 205;
                    $msg = "Someting went wrong.";
                    $data = [];
                }
            } else {
                $data = [];
                $code = 201;
                $msg = "Required Data Missing in Request : lead_id , rating";
            }
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

}
