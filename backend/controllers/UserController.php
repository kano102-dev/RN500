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
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * RecruiterController implements the CRUD actions for RecruiterMaster model.
 */
class UserController extends Controller {

    public $title = "User Approval";
    public $activeBreadcrumb, $breadcrumb;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'change-status', 'get-pending', 'get-approved', 'get-rejected'],
                'rules' => [
                    [
                        'actions' => ['index', 'change-status', 'get-pending', 'get-approved', 'get-rejected'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('user-approve', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'get-pending', 'get-approved', 'get-rejected'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('user-request-view', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
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

        $searchModel = new UserDetailsSearch();
        $dataProvider = $searchModel->searchPending(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['user', 'branch']);
//        echo $dataProvider->query->createCommand()->rawSql;exit;
        if (isset($search) && $search != "") {
            $dataProvider->query->andWhere(['OR', ['like', 'unique_id', $search],
                ['like', 'first_name', $search],
                ['like', 'last_name', $search],
                ['like', 'user.email', $search],
//                ['like', 'user.comment', $search],
            ]);
        }

        $dataProvider->query->orderBy($orderby);
        $filteredCount = count($dataProvider->query->all());
        $dataProvider->query->limit($length)->offset($start);

        $count = (string) $searchModel->searchPending()->getTotalCount();
        $response = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => (isset($filteredCount) && $filteredCount != '') ? $filteredCount : $count,
            'data' => []
        ];
        $i = $start + 1;
        foreach ($dataProvider->query->all() as $key => $model) {
            $id = $model->id;
            $actionDiv = '';
            if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('user-approve', Yii::$app->user->identity->id)) {
                $actionDiv = '<a class="change-status"  modal-title="Approve User" href="javascript:void(0)" title="Approve" url="' . Url::to([Yii::$app->controller->id . '/change-status/', 'id' => $model->user_id, 'status' => User::STATUS_APPROVED]) . '" data-pjax="0"><span class="fa fa-check-circle"></span></a> &nbsp;';
                $actionDiv .= '<a class="change-status" modal-title="Reject User" href="javascript:void(0)" title="Reject" url="' . Url::to([Yii::$app->controller->id . '/change-status/', 'id' => $model->user_id, 'status' => User::STATUS_REJECTED]) . '" data-pjax="0"><span class="fa fa-times-circle"></span></a>';
            }
            $response['data'][] = [
                $i,
                $model->unique_id,
                $model->first_name . " " . $model->last_name,
                $model->user->email,
                $model->companyNames,
                Yii::$app->params['user.types'][$model->user->type],
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

        $searchModel = new UserDetailsSearch();
        $dataProvider = $searchModel->searchApproved(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['user', 'branch']);
//        echo $dataProvider->query->createCommand()->rawSql;exit;
        if (isset($search) && $search != "") {
            $dataProvider->query->andWhere(['OR', ['like', 'unique_id', $search],
                ['like', 'first_name', $search],
                ['like', 'last_name', $search],
                ['like', 'user.email', $search],
                ['like', 'user.comment', $search],
            ]);
        }

        $dataProvider->query->orderBy($orderby);
        $filteredCount = count($dataProvider->query->all());
        $dataProvider->query->limit($length)->offset($start);

        $count = (string) $searchModel->searchApproved()->getTotalCount();
        $response = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => (isset($filteredCount) && $filteredCount != '') ? $filteredCount : $count,
            'data' => []
        ];
        $i = $start + 1;
        foreach ($dataProvider->query->all() as $key => $model) {
            $id = $model->id;

            $actionDiv = '';

            $response['data'][] = [
                $i,
                $model->unique_id,
                $model->first_name . " " . $model->last_name,
                $model->user->email,
                $model->companyNames,
                Yii::$app->params['user.types'][$model->user->type],
                $model->user->comment,
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

        $searchModel = new UserDetailsSearch();
        $dataProvider = $searchModel->searchRejected(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['user', 'branch']);
//        echo $dataProvider->query->createCommand()->rawSql;exit;
        if (isset($search) && $search != "") {
            $dataProvider->query->andWhere(['OR', ['like', 'unique_id', $search],
                ['like', 'first_name', $search],
                ['like', 'last_name', $search],
                ['like', 'user.email', $search],
                ['like', 'user.comment', $search],
            ]);
        }

        $dataProvider->query->orderBy($orderby);
        $filteredCount = count($dataProvider->query->all());
        $dataProvider->query->limit($length)->offset($start);

        $count = (string) $searchModel->searchRejected()->getTotalCount();
        $response = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => (isset($filteredCount) && $filteredCount != '') ? $filteredCount : $count,
            'data' => []
        ];
        $i = $start + 1;
        foreach ($dataProvider->query->all() as $key => $model) {
            $id = $model->id;

            $actionDiv = '';

            $response['data'][] = [
                $i,
                $model->unique_id,
                $model->first_name . " " . $model->last_name,
                $model->user->email,
                $model->companyNames,
                Yii::$app->params['user.types'][$model->user->type],
                $model->user->comment,
            ];
            $i++;
        }
        echo Json::encode($response);
        exit;
    }

    public function actionChangeStatus($id, $status) {
        $model = User::findOne(['id' => $id]);
        $company = CompanyMaster::findOne(['id' => $model->branch->company_id]);
        $model->scenario = $status == User::STATUS_APPROVED ? 'approve' : 'reject';
        if ($model->load(Yii::$app->request->post())) {
            $company->status = $status;
            $model->status = $status;
            $company->updated_at = CommonFunction::currentTimestamp();
            if ($model->save(false)) {
                if ($model->status == User::STATUS_APPROVED) {
                    CommonFunction::sendWelcomeMail($model);
                }
                Yii::$app->session->setFlash("success", "User verified successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong");
            }
            return $this->redirect('index');
        }
        return $this->renderAjax('change-status', ['model' => $model]);
    }

}

?>
