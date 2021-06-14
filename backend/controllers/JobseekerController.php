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
use common\models\RoleMaster;
use common\models\PasswordResetRequestForm;
use yii\helpers\Url;
use common\models\States;
use yii\filters\AccessControl;
use common\models\WorkExperience;
use common\models\Documents;
use common\models\Licenses;
use common\models\Certifications;
use common\models\Education;
use common\models\References;

/**
 * RecruiterController implements the CRUD actions for RecruiterMaster model.
 */
class JobseekerController extends Controller {

    public $title = "Jobseeker";
    public $activeBreadcrumb, $breadcrumb;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('jobseeker-view', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->breadcrumb = [
            'Home' => Url::base(true),
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['jobseeker/index']),
        ];
    }

    public function actionIndex() {
        $searchModel = new UserDetailsSearch();
        $dataProvider = $searchModel->searchJobseeker(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($ref) {
        $this->activeBreadcrumb = "Jobseeker Detail";
        $model = UserDetails::find()->where(['unique_id' => $ref])->one();
        if ($model !== null) {
            $userId = $model->user_id;

            $workExperiences = WorkExperience::find()->where(['user_id' => $userId])->joinWith('discipline')->all();
            $certifications = Certifications::find()->where(['user_id' => $userId])->all();
            $documents = Documents::find()->where(['user_id' => $userId])->all();
            $licenses = Licenses::find()->where(['user_id' => $userId])->all();
            $educations = Education::find()->where(['user_id' => $userId])->all();
            $references = References::find()->where(['user_id' => $userId])->all();

            return $this->render('view', ['model' => $model, 'workExperiences' => $workExperiences, 'certifications' => $certifications, 'documents' => $documents, 'licenses' => $licenses, 'educations' => $educations, 'references' => $references]);
        } else {
            throw new \yii\web\NotFoundHttpException("Oops! Something went wrong");
        }
    }

}
