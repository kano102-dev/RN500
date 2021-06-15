<?php

//

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\ReferralMaster;
use yii\helpers\Url;
use yii\base\DynamicModel;

/**
 * RoleController implements the CRUD actions for RoleMaster model.
 */
class ReportController extends Controller {

    public $title = "Report";
    public $activeBreadcrumb, $breadcrumb;

    /**
     * {@inheritdoc}
     */
//    public function behaviors() {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['lead-referral'],
//                'rules' => [
//                        [
//                        'actions' => ['lead-referral'],
//                        'allow' => true,
//                        'roles' => isset(Yii::$app->user->identity) ? ['@'] : ['*'],
//                    ],
//                ]
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->breadcrumb = [
            'Home' => Url::base(true),
//            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['report/index']),
        ];
    }

    /**
     * Lists all RoleMaster models.
     * @return mixed
     */
    public function actionLeadReferral() {
        $this->activeBreadcrumb = "Report : Lead Referral";

        $models = ReferralMaster::find()->orderBy(['created_at' => SORT_DESC])->all();
//        $filterFormModel = new DynamicModel(['from_date', 'to_date']);
////        $filterFormModel->addRule(['from_date','to_date'], 'required');
        return $this->render('lead-referral', [
                    'models' => $models,
//                    'filterFormModel' => $filterFormModel,
        ]);
    }

}
