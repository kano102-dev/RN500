<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Json;
use api\modules\v1\components\Controller;
use common\models\Cities;
use common\models\LeadMasterSearch;

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
        $request = Yii::$app->request->post();
        try {
            $paging = (isset($request['page']) && $request['page'] != '' && $request['page'] != 0) ? $request['page'] : 1;
            $search = (isset($request['filter']) && !empty($request['filter'])) ? $request['filter'] : '';
            $reference_no = (isset($request['reference_no']) && !empty($request['reference_no'])) ? trim($request['reference_no']) : '';

            if ($reference_no != '') {

                $branchList = [];
                $searchModel = new LeadMasterSearch();
                $dataProvider = $searchModel->searchJobApply(['ref' => $reference_no]);
                $query = $dataProvider->query;

                if ($search != '') {
                    $query->andWhere(['OR', ['LIKE', 'branch.branch_name', $search], ['LIKE', "IF(subscribed_companies.company_name IS NOT NULL ,subscribed_companies.company_name,`company`.`company_name`)", $search]]);
                }

                $total_pages = (ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])) ? ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT']) : 1;
                if ($paging <= $total_pages) {
                    $query->offset(($paging - 1) * Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])->limit(Yii::$app->params['API_PAGINATION_RECORD_LIMIT']);
                    $lists = $query->all();
                    foreach ($lists as $value) {
                        $branchList[] = ['branch_id' => $value->id, 'branch_name' => $value->branch_name, 'company_name' => $value->company_name];
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

}
