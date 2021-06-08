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

/**
 * RecruiterController implements the CRUD actions for RecruiterMaster model.
 */
class RecruiterController extends Controller {

    public $title = "Recruiter Company";
    public $activeBreadcrumb, $breadcrumb;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'get-cities'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'get-cities'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('recruiter-create', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'update', 'get-cities'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('recruiter-update', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('recruiter-view', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('recruiter-delete', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ]
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
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['recruiter/index']),
        ];
    }

    public function actionIndex() {
        $searchModel = new UserDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PackageMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->activeBreadcrumb = "Detail View";
        $model = $this->findModel($id);

        $userDetailModel = isset($model->details) ? $model->details : [];
        $userDetailModel->email = $model->email;
        $companyMasterModel = isset($model->branch->company) ? $model->branch->company : [];
        return $this->render('view', [
                    'model' => $model,
                    'userDetailModel' => $userDetailModel,
                    'companyMasterModel' => $companyMasterModel,
        ]);
    }

    /**
     * Creates a new PackageMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->activeBreadcrumb = "Create";
        $model = new User();
        $model->scenario = "create";
        $userDetailModel = new UserDetails();
        $userDetailModel->scenario = 'recruiter';
        $companyMasterModel = new CompanyMaster();

        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');

        $city = $CompanyCity = [];
        if ($userDetailModel->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post()) && $companyMasterModel->load(Yii::$app->request->post())) {
            $CompanyCity = ArrayHelper::map(Cities::findAll(['state_id' => $companyMasterModel->state]), 'id', 'city');
            $city = ArrayHelper::map(Cities::findAll(['state_id' => $userDetailModel->state]), 'id', 'city');
            $is_error = 0;
            $userDetailModel->role_id = RoleMaster::RECRUITER_OWNER;
            $userDetailModel->created_at = $companyMasterModel->created_at = CommonFunction::currentTimestamp();
            $userDetailModel->updated_at = $companyMasterModel->updated_at = CommonFunction::currentTimestamp();
            $companyMasterModel->reference_no = $companyMasterModel->getUniqueReferenceNumber();
            if ($userDetailModel->validate(['first_name', 'last_name', 'mobile_no', 'profile_pic', 'current_position', 'speciality', 'job_title', 'job_looking_from', 'travel_preference', 'ssn', 'work_authorization', 'work_authorization_comment', 'license_suspended', 'professional_liability']) && $companyMasterModel->validate()) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $companyMasterModel->type = 1;
                    if ($companyMasterModel->save()) {
                        $companySubscription = new CompanySubscription;
                        $companySubscription->company_id = $companyMasterModel->id;
                        $companySubscription->package_id = PackageMaster::PAY_AS_A_GO;
                        $companySubscription->created_at = $companySubscription->updated_at = CommonFunction::currentTimestamp();
                        if ($companySubscription->save()) {
                            $company_branch = new CompanyBranch();
                            $company_branch->branch_name = "HO";
                            $company_branch->email = $companyMasterModel->company_email;
                            $company_branch->city = $companyMasterModel->city;
                            $company_branch->company_id = $companyMasterModel->id;
                            $company_branch->setAttributes($companyMasterModel->getAttributes());
                            $company_branch->is_default = CompanyBranch::IS_DEFAULT_YES;
                            if ($company_branch->save()) {
                                $model->type = User::TYPE_RECRUITER;
                                $model->status = User::STATUS_PENDING;
                                $model->branch_id = $company_branch->id;
                                $model->role_id = RoleMaster::RECRUITER_OWNER;
                                $model->is_owner = User::OWNER_YES;
                                if ($model->save()) {
                                    $userDetailModel->user_id = $model->id;
                                    $unique_id = CommonFunction::generateRandomString();
                                    $details = UserDetails::findOne(['unique_id' => $unique_id]);
                                    if (!empty($details)) {
                                        $unique_id = CommonFunction::generateRandomString();
                                    }
                                    $userDetailModel->unique_id = $unique_id;
                                    if ($userDetailModel->save()) {
                                        $is_error = 1;
                                        $resetPasswordModel = new PasswordResetRequestForm();
                                        $resetPasswordModel->email = $model->email;
                                        $is_welcome_mail = 1;
                                        if ($resetPasswordModel->sendEmail($is_welcome_mail)) {
                                            $is_error = 1;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($is_error) {
                        $transaction->commit();
                        Yii::$app->session->setFlash("success", "Recruiter was added successfully.");
                        return $this->redirect(['index']);
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash("warning", "Something went wrong.");
                    }
                } catch (\Exception $ex) {
                    $transaction->rollBack();
                }
            }
        }


        return $this->render('_form', [
                    'model' => $model, 'CompanyCity' => $CompanyCity, 'city' => $city,
                    'userDetailModel' => $userDetailModel,
                    'companyMasterModel' => $companyMasterModel,
                    'states' => $states
        ]);
    }

    /**
     * Updates an existing PackageMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $this->activeBreadcrumb = "Update";
        $model = $this->findModel($id);
        $model->scenario = "create";
        
        $userDetailModel = isset($model->details) ? $model->details : [];
        $userDetailModel->scenario = 'recruiter';
        $userDetailModel->email = $model->email;
        $companyMasterModel = isset($model->branch->company) ? $model->branch->company : [];
        $states = ArrayHelper::map(States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        $city = !empty($userDetailModel->cityRef->state_id) ? ArrayHelper::map(Cities::findAll(['state_id' => $userDetailModel->cityRef->state_id]), 'id', 'city') : [];
        $CompanyCity = !empty($companyMasterModel->cityRef->state_id) ? ArrayHelper::map(Cities::findAll(['state_id' => $companyMasterModel->cityRef->state_id]), 'id', 'city') : [];
        $userDetailModel->state = !empty($userDetailModel->cityRef->state_id) ? $userDetailModel->cityRef->state_id : '';
        $companyMasterModel->state = !empty($model->branch->company->cityRef->state_id) ? $model->branch->company->cityRef->state_id : '';
        if ($userDetailModel->load(Yii::$app->request->post()) && $companyMasterModel->load(Yii::$app->request->post())) {
            $userDetailModel->role_id = RoleMaster::RECRUITER_OWNER;
            $userDetailModel->updated_at = $companyMasterModel->updated_at = CommonFunction::currentTimestamp();
            if ($userDetailModel->validate(['first_name', 'last_name', 'mobile_no', 'profile_pic', 'current_position', 'speciality', 'job_title', 'job_looking_from', 'travel_preference', 'ssn', 'work_authorization', 'work_authorization_comment', 'license_suspended', 'professional_liability']) && $companyMasterModel->validate()) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($companyMasterModel->save()) {
                        $company_branch = CompanyBranch::find()->where(['company_id' => $companyMasterModel->id, 'is_default' => CompanyBranch::IS_DEFAULT_YES])->one();
                        $company_branch->email = $companyMasterModel->company_email;
                        $company_branch->setAttributes($companyMasterModel->getAttributes());
                        if ($company_branch->save()) {
                            $model->type = User::TYPE_RECRUITER;
                            $model->branch_id = $company_branch->id;
                            $model->role_id = RoleMaster::RECRUITER_OWNER;
                            if ($model->save()) {
                                $userDetailModel->user_id = $model->id;
                                if ($userDetailModel->save()) {
                                    $transaction->commit();
                                    Yii::$app->session->setFlash("success", "Recruiter was updated successfully.");
                                    return $this->redirect(['view', 'id' => $id]);
                                } else {
                                    Yii::$app->session->setFlash("warning", "Something went wrong.");
                                }
                            }
                        }
                    }
                } catch (\Exception $ex) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('_form', [
                    'model' => $model, 'CompanyCity' => $CompanyCity,
                    'userDetailModel' => $userDetailModel,
                    'companyMasterModel' => $companyMasterModel,
                    'states' => $states, 'city' => $city
        ]);
    }

    /**
     * Deletes an existing PackageMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetCities($id) {
        $cities = ArrayHelper::map(Cities::find()->where(['state_id' => $id])->all(), 'id', 'city');
        $options = '';
        if (!empty($cities)) {
            foreach ($cities as $key => $city) {
                $options .= "<option value=$key>$city</option>";
            }
        }
        echo $options;
        exit;
    }

    /**
     * Finds the PackageMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PackageMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
