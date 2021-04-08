<?php

namespace backend\controllers;

use Yii;
use backend\models\PackageMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\SignupForm;
use common\models\UserDetailsSearch;
use common\models\User;
use common\models\UserDetails;
use common\models\CompanyMaster;
use common\CommonFunction;
use common\models\Cities;
use yii\helpers\ArrayHelper;
use common\models\CompanyBranch;
use common\models\CompanySubscription;
use common\models\PackageMaster;
use yii\helpers\Url;

/**
 * RecruiterController implements the CRUD actions for RecruiterMaster model.
 */
class UserController extends Controller {

    public $title = "Staff Management";
    public $activeBreadcrumb, $breadcrumb;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'get-pending', 'get-approved', 'get-rejected'],
                'rules' => [
                    [
                        'actions' => ['index', 'get-pending', 'get-approved', 'get-rejected'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
        ];
    }

    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->breadcrumb = [
            'Home' => Url::base(true),
            $this->title => Yii::$app->urlManager->createAbsoluteUrl(['user/get-pending']),
        ];
    }

    public function actionIndex() {
        $searchModel = new UserDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionGetPending() {
        $request = Yii::$app->getRequest()->post();
        $start = (isset($request['start']) && $request['start'] != '') ? $request['start'] : 0;
        $draw = (isset($request['draw']) && $request['draw'] != '') ? $request['draw'] : 1;
        $length = (isset($request['length']) && $request['length'] != '') ? $request['length'] : Yii::$app->params['AP_PAGE_LENGTH'];
        $search = isset($request['search']['value']) ? trim($request['search']['value']) : '';
        $column = ( isset($request['order'][0]['column']) && isset($request['columns'][$request['order'][0]['column']]['name'])) ? trim($request['columns'][$request['order'][0]['column']]['name']) : 'created_at';
        $dir = (isset($request['order'][0]['column']) && isset($request['order'][0]['dir'])) ? $request['order'][0]['dir'] : "DESC";
        $orderby = "$column $dir";

        $searchModel = new common\models\UserDetailsSearch();
        $dataProvider = $searchModel->searchPending(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['user', 'branch']);
//        echo $dataProvider->query->createCommand()->rawSql;exit;
        if (isset($search) && $search != "") {
//            $dataProvider->query->andWhere(['OR', ['like', 'asset_master.asset_code', $search],
//                ['like', 'transfer.reference_id', $search],
//                ['like', 'asset_master.name', $search],
//                ['like', 'transfer.reason', $search],
//            ]);
        }

        $dataProvider->query->orderBy($orderby);
        $filteredCount = count($dataProvider->query->all());
        $dataProvider->query->limit($length)->offset($start);

        $count = (string) $searchModel->detailraisedSearch()->getTotalCount();
        $response = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => (isset($filteredCount) && $filteredCount != '') ? $filteredCount : $count,
            'data' => []
        ];
        $i = $start + 1;
        foreach ($dataProvider->query->all() as $key => $model) {
            $id = $model->id;

            $actionDiv = '<div class="dropdown profile-element dropdown-err">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-bars"></i></a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs" style="margin-left: -50px !important;"><a href="#" data-toggle="dropdown" class="dropdown-toggle"></a>
                            <li><a href="#" data-toggle="dropdown" class="dropdown-toggle"></a>
                                <a  href=""  data-pjax="0" >View</a>
                            </li>';
            $actionDiv .= '</ul> </div>';

            $response['data'][] = [
                $i,
                $model->unique_id,
                $model->first_name . " " . $model->last_name,
                $model->user->email,
                $model->companyNames,
                $actionDiv
            ];
            $i++;
        }
        echo Json::encode($response);
        exit;
    }

    public function actionGetApproved() {
        $request = Yii::$app->getRequest()->post();
        $start = (isset($request['start']) && $request['start'] != '') ? $request['start'] : 0;
        $draw = (isset($request['draw']) && $request['draw'] != '') ? $request['draw'] : 1;
        $length = (isset($request['length']) && $request['length'] != '') ? $request['length'] : Yii::$app->params['AP_PAGE_LENGTH'];
        $search = isset($request['search']['value']) ? trim($request['search']['value']) : '';
        $column = ( isset($request['order'][0]['column']) && isset($request['columns'][$request['order'][0]['column']]['name'])) ? trim($request['columns'][$request['order'][0]['column']]['name']) : 'created_at';
        $dir = (isset($request['order'][0]['column']) && isset($request['order'][0]['dir'])) ? $request['order'][0]['dir'] : "DESC";
        $orderby = "$column $dir";

        $searchModel = new common\models\UserDetailsSearch();
        $dataProvider = $searchModel->searchPending(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['user', 'branch']);
//        echo $dataProvider->query->createCommand()->rawSql;exit;
        if (isset($search) && $search != "") {
//            $dataProvider->query->andWhere(['OR', ['like', 'asset_master.asset_code', $search],
//                ['like', 'transfer.reference_id', $search],
//                ['like', 'asset_master.name', $search],
//                ['like', 'transfer.reason', $search],
//            ]);
        }

        $dataProvider->query->orderBy($orderby);
        $filteredCount = count($dataProvider->query->all());
        $dataProvider->query->limit($length)->offset($start);

        $count = (string) $searchModel->detailraisedSearch()->getTotalCount();
        $response = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => (isset($filteredCount) && $filteredCount != '') ? $filteredCount : $count,
            'data' => []
        ];
        $i = $start + 1;
        foreach ($dataProvider->query->all() as $key => $model) {
            $id = $model->id;

            $actionDiv = '<div class="dropdown profile-element dropdown-err">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-bars"></i></a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs" style="margin-left: -50px !important;"><a href="#" data-toggle="dropdown" class="dropdown-toggle"></a>
                            <li><a href="#" data-toggle="dropdown" class="dropdown-toggle"></a>
                                <a  href=""  data-pjax="0" >View</a>
                            </li>';
            $actionDiv .= '</ul> </div>';

            $response['data'][] = [
                $i,
                $model->unique_id,
                $model->first_name . " " . $model->last_name,
                $model->user->email,
                $model->companyNames,
                $actionDiv
            ];
            $i++;
        }
        echo Json::encode($response);
        exit;
    }

    public function actionGetRejected() {
        $request = Yii::$app->getRequest()->post();
        $start = (isset($request['start']) && $request['start'] != '') ? $request['start'] : 0;
        $draw = (isset($request['draw']) && $request['draw'] != '') ? $request['draw'] : 1;
        $length = (isset($request['length']) && $request['length'] != '') ? $request['length'] : Yii::$app->params['AP_PAGE_LENGTH'];
        $search = isset($request['search']['value']) ? trim($request['search']['value']) : '';
        $column = ( isset($request['order'][0]['column']) && isset($request['columns'][$request['order'][0]['column']]['name'])) ? trim($request['columns'][$request['order'][0]['column']]['name']) : 'created_at';
        $dir = (isset($request['order'][0]['column']) && isset($request['order'][0]['dir'])) ? $request['order'][0]['dir'] : "DESC";
        $orderby = "$column $dir";

        $searchModel = new common\models\UserDetailsSearch();
        $dataProvider = $searchModel->searchPending(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['user', 'branch']);
//        echo $dataProvider->query->createCommand()->rawSql;exit;
        if (isset($search) && $search != "") {
//            $dataProvider->query->andWhere(['OR', ['like', 'asset_master.asset_code', $search],
//                ['like', 'transfer.reference_id', $search],
//                ['like', 'asset_master.name', $search],
//                ['like', 'transfer.reason', $search],
//            ]);
        }

        $dataProvider->query->orderBy($orderby);
        $filteredCount = count($dataProvider->query->all());
        $dataProvider->query->limit($length)->offset($start);

        $count = (string) $searchModel->detailraisedSearch()->getTotalCount();
        $response = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => (isset($filteredCount) && $filteredCount != '') ? $filteredCount : $count,
            'data' => []
        ];
        $i = $start + 1;
        foreach ($dataProvider->query->all() as $key => $model) {
            $id = $model->id;

            $actionDiv = '<div class="dropdown profile-element dropdown-err">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-bars"></i></a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs" style="margin-left: -50px !important;"><a href="#" data-toggle="dropdown" class="dropdown-toggle"></a>
                            <li><a href="#" data-toggle="dropdown" class="dropdown-toggle"></a>
                                <a  href=""  data-pjax="0" >View</a>
                            </li>';
            $actionDiv .= '</ul> </div>';

            $response['data'][] = [
                $i,
                $model->unique_id,
                $model->first_name . " " . $model->last_name,
                $model->user->email,
                $model->companyNames,
                $actionDiv
            ];
            $i++;
        }
        echo Json::encode($response);
        exit;
    }

}

?>
