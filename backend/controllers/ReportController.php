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
use common\CommonFunction;
use yii\db\Expression;
use yii\db\Query;
use common\models\CompanySubscriptionPayment;

/**
 * RoleController implements the CRUD actions for RoleMaster model.
 */
class ReportController extends Controller {

    public $title = "Report";
    public $activeBreadcrumb, $breadcrumb;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['lead-referral', 'lead-referral-load', 'payment', 'payment-load'],
                'rules' => [
                        [
                        'actions' => ['lead-referral', 'lead-referral-load', 'payment', 'payment-load'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? ['@'] : ['*'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'lead-referral-load' => ['POST'],
                    'payment-load' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->breadcrumb = [
            'Home' => Url::base(true),
//            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['report/index']),
        ];
    }

    /**
     * LEAD REFERRAL REPORT ACTION
     */
    public function actionLeadReferral() {
        $this->activeBreadcrumb = "Report : Lead Referral";
        $filterFormModel = new DynamicModel(['from_date', 'to_date']);
        $filterFormModel->addRule(['from_date', 'to_date'], 'required');
        $filterFormModel->to_date = date('d-M-Y');
        $filterFormModel->from_date = date('d-M-Y', strtotime("-7 days"));
        return $this->render('lead-referral', ['filterFormModel' => $filterFormModel]);
    }

    public function actionLeadReferralLoad() {
        $postData = Yii::$app->request->post('DynamicModel');
        $from_date = isset($postData['from_date']) ? date('Y-m-d', strtotime($postData['from_date'])) . ' 00:00:01' : '';
        $to_date = isset($postData['to_date']) ? date('Y-m-d', strtotime($postData['to_date'])) . ' 23:59:59' : '';
        $models = ReferralMaster::find()->andWhere("created_at BETWEEN '$from_date' AND '$to_date' ")->orderBy(['created_at' => SORT_DESC])->all();
        return $this->renderPartial('lead-referral_load_data', [
                    'models' => $models,
        ]);
    }

    /**
     * PAYMENT REPORT ACTION
     */
    public function actionPayment() {
        $this->activeBreadcrumb = "Report : Payment";
        $filterFormModel = new DynamicModel(['from_date', 'to_date']);
        $filterFormModel->addRule(['from_date', 'to_date'], 'required');
        $filterFormModel->to_date = date('d-M-Y');
        $filterFormModel->from_date = date('d-M-Y', strtotime("-7 days"));
        return $this->render('payment', ['filterFormModel' => $filterFormModel]);
    }

    public function actionPaymentLoad() {
        $data = [];
        try {
            $postData = Yii::$app->request->post('DynamicModel');
            $from_date = isset($postData['from_date']) ? strtotime($postData['from_date'] . ' 00:00:01') : '';
            $to_date = isset($postData['to_date']) ? strtotime($postData['to_date'] . ' 23:59:59') : '';
            $loggedInUserCompanyId = CommonFunction::getLoggedInUserCompanyId();

            $query = new Query();
            $query->select([
                        "package.title as package",
                        "cs.start_date as pkg_start_date",
                        "cs.expiry_date as pkg_end_date",
                        "lead.reference_no as lead_reference_no",
                        "CONCAT(lead.title, ' ', lead.reference_no) as lead_title",
                        "payment_status" => new Expression("CASE WHEN csp.status = 1 THEN 'Success' ELSE 'Fail' END"),
                        "csp.amount",
                        "csp.customer_transaction_id as transaction_id",
                        "transaction_date" => new Expression("DATE_FORMAT(FROM_UNIXTIME(csp.created_at), '%d %M %Y')"),
                    ])
                    ->from("company_subscription_payment as csp")
                    ->leftJoin("company_subscription as cs", "cs.id = csp.subscription_id")
                    ->leftJoin("package_master as package", "package.id = cs.package_id")
                    ->leftJoin("lead_master as lead", "lead.id = csp.lead_id")
                    ->where(["cs.company_id" => $loggedInUserCompanyId])
                    ->andWhere(["csp.is_free" => CompanySubscriptionPayment::IS_FREE_NO]);

            if ($from_date != '' && $to_date != '') {
                $query->andWhere("csp.created_at BETWEEN '$from_date' AND '$to_date'");
            }
            $data = $query->createCommand()->queryAll();
//            $data = $query->createCommand()->rawSql;
//            echo "<pre/>";
//            print_r($data);
//            exit;
        } catch (\Exception $ex) {
            $data = [];
        }




        return $this->renderPartial('payment_load_data', [
                    'data' => $data,
        ]);
    }

}
