<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\Json;
use common\models\LeadMasterSearch;
use common\models\LeadMaster;
use common\CommonFunction;

/**
 * RecruiterController implements the CRUD actions for RecruiterMaster model.
 */
class LeadController extends Controller {

    public $title = "Lead Approval";
    public $activeBreadcrumb, $breadcrumb;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'get-pending', 'get-approved', 'approve', 'edit'],
                'rules' => [
                    [
                        'actions' => ['index', 'get-pending', 'get-approved', 'approve', 'edit'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('lead-verify', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
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
            $this->title => Yii::$app->urlManager->createAbsoluteUrl(['lead/index']),
        ];
    }

    public function actionIndex() {
        $searchModel = new LeadMasterSearch();
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

        $searchModel = new LeadMasterSearch();
        $dataProvider = $searchModel->searchPending(Yii::$app->request->queryParams);

        if (isset($search) && $search != "") {
            $dataProvider->query->andWhere(['OR', ['like', 'title', $search],
                ['like', 'reference_no', $search],
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

            $actionDiv = '<a class="change-status"  modal-title="Edit Lead" href="javascript:void(0)" title="Edit lead" url="' . Url::to([Yii::$app->controller->id . '/edit/', 'id' => $model->id]) . '" data-pjax="0"><span class="fa fa-edit"></span></a> &nbsp;';
            $actionDiv .= '<a class="change-status"  modal-title="Approve Lead" href="javascript:void(0)" title="Approve" url="' . Url::to([Yii::$app->controller->id . '/approve/', 'id' => $model->id]) . '" data-pjax="0"><span class="fa fa-check-circle"></span></a> &nbsp;';

            $response['data'][] = [
                $i,
                $model->reference_no,
                $model->title,
                $model->recruiter_commission_type == 1 ? $model->recruiter_commission . "%" : "$" . $model->recruiter_commission,
                "$" . $model->jobseeker_payment . "/" . Yii::$app->params['job.payment_type'][$model->payment_type],
                $model->start_date,
                $model->end_date,
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

        $searchModel = new LeadMasterSearch();
        $dataProvider = $searchModel->searchApproved(Yii::$app->request->queryParams);
        if (isset($search) && $search != "") {
            $dataProvider->query->andWhere(['OR', ['like', 'title', $search],
                ['like', 'reference_no', $search],
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
            $response['data'][] = [
                $i,
                $model->reference_no,
                $model->title,
                $model->recruiter_commission_type == 1 ? $model->recruiter_commission . "%" : "$" . $model->recruiter_commission,
                "$" . $model->jobseeker_payment . "/" . Yii::$app->params['job.payment_type'][$model->payment_type],
            ];
            $i++;
        }
        echo Json::encode($response);
        exit;
    }

    public function actionApprove($id) {
        $model = LeadMaster::findOne(['id' => $id]);
        $model->scenario = 'approve';
        if ($model->load(Yii::$app->request->post())) {
            $model->status = LeadMaster::STATUS_APPROVED;
            $model->updated_at = $model->approved_at = CommonFunction::currentTimestamp();
            $model->updated_by = Yii::$app->user->identity->id;
            if ($model->save(false)) {
                Yii::$app->session->setFlash("success", "Lead approved successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong");
            }
            return $this->redirect(['index']);
        }
        return $this->renderAjax('_approve_form', ['model' => $model]);
    }

    public function actionEdit($id) {
        $model = LeadMaster::findOne(['id' => $id]);
        $model->start_date = date(Yii::$app->params['date.format.display.php'], strtotime($model->start_date));
        $model->end_date = ($model->end_date != '') ? date(Yii::$app->params['date.format.display.php'], strtotime($model->end_date)) : null;
        if ($model->load(Yii::$app->request->post())) {
            $model->start_date = date("Y-m-d", strtotime($model->start_date));
            $model->end_date = ($model->end_date) ? $model->end_date = date("Y-m-d", strtotime($model->end_date)) : null;
            $model->updated_at = CommonFunction::currentTimestamp();
            $model->updated_by = Yii::$app->user->identity->id;
            if ($model->save(false)) {
                Yii::$app->session->setFlash("success", "Lead updated Successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong");
            }
            return $this->redirect(['index']);
        }
        return $this->renderAjax('_edit_form', ['model' => $model]);
    }

}

?>
