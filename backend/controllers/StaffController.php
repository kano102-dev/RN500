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
use common\models\States;
use yii\filters\AccessControl;

/**
 * RecruiterController implements the CRUD actions for RecruiterMaster model.
 */
class StaffController extends Controller {

    public $title = "Staff Management";
    public $activeBreadcrumb, $breadcrumb;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'get-cities', 'get-branches'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'get-cities', 'get-branches'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('user-create', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'update', 'get-cities', 'get-branches'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('user-update', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('user-view', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('user-delete', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
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
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['staff/index']),
        ];
    }

    public function actionIndex() {
        $searchModel = new UserDetailsSearch();
        $dataProvider = $searchModel->searchStaff(Yii::$app->request->queryParams);

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
        $userDetailModel->scenario = 'staff';

        $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1])->all(), 'id', 'company_name');
        if (!\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) {
            if (\common\CommonFunction::isHoAdmin(Yii::$app->user->identity->id)) {
                $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1, 'id' => Yii::$app->user->identity->branch->company_id])->all(), 'id', 'company_name');
            } else {
                $companyList = [];
            }
        }
        $roles = ArrayHelper::map(\common\models\RoleMaster::find()->all(), 'id', function ($data) {
                    return $data->role_name . "-" . $data->company->company_name;
                });
        if (!\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) {
            $roles = ArrayHelper::map(\common\models\RoleMaster::findAll(['company_id' => \Yii::$app->user->identity->branch->company_id]), 'id', 'role_name');
        }
        $states = ArrayHelper::map(States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        $city = [];
        $branchList = [];
        if ($userDetailModel->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
            $city = ArrayHelper::map(Cities::findAll(['state_id' => $userDetailModel->state]), 'id', 'city');
            $branchList = ArrayHelper::map(CompanyBranch::findAll(['company_id' => $userDetailModel->company_id]), 'id', 'branch_name');
            $is_error = 0;
            $userDetailModel->created_at = CommonFunction::currentTimestamp();
            $userDetailModel->updated_at = CommonFunction::currentTimestamp();
            if ($userDetailModel->validate(['first_name', 'last_name', 'mobile_no', 'profile_pic', 'current_position', 'speciality', 'job_title', 'job_looking_from', 'travel_preference', 'ssn', 'work_authorization', 'work_authorization_comment', 'license_suspended', 'professional_liability'])) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model->role_id = $userDetailModel->role_id;
                    $model->status = User::STATUS_APPROVED;
                    if (!\common\CommonFunction::isHoAdmin(Yii::$app->user->identity->id)) {
                        $model->branch_id = \Yii::$app->user->identity->branch_id;
                    } else {
                        $model->branch_id = $userDetailModel->branch_id;
                    }
                    $branch = CompanyBranch::findOne(['id' => $model->branch_id]);
                    $model->type = $branch->company->type == 0 ? User::TYPE_EMPLOYER : User::TYPE_RECRUITER;
                    $model->is_owner = User::OWNER_NO;
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
                            $resetPasswordModel = new \common\models\PasswordResetRequestForm();
                            $resetPasswordModel->email = $model->email;
                            $is_welcome_mail = 1;
                            if ($resetPasswordModel->sendEmail($is_welcome_mail)) {
                                CommonFunction::sendWelcomeMail($model);
                                $is_error = 1;
                            }
                        }
                    }
                    if ($is_error) {
                        $transaction->commit();
                        Yii::$app->session->setFlash("success", "Staff added successfully.");
                        return $this->redirect(['index']);
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash("warning", "Something went wrong.");
                    }
                } catch (\Exception $ex) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash("warning", "Something went wrong.");
                }
            }
        }
        return $this->render('_form', ['model' => $model, 'branchList' => $branchList,
                    'userDetailModel' => $userDetailModel, 'companyList' => $companyList,
                    'states' => $states, 'city' => $city, 'roles' => $roles
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
        $userDetailModel->scenario = 'staff';

        $userDetailModel->company_id = $model->branch->company_id;
        $userDetailModel->branch_id = $model->branch_id;
        $userDetailModel->role_id = $model->role_id;

        $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1])->all(), 'id', 'company_name');
        if (!\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) {
            if (\common\CommonFunction::isHoAdmin(Yii::$app->user->identity->id)) {
                $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1, 'id' => Yii::$app->user->identity->branch->company_id])->all(), 'id', 'company_name');
            } else {
                $companyList = [];
            }
        }
        $roles = ArrayHelper::map(\common\models\RoleMaster::find()->all(), 'id', function ($data) {
                    return $data->role_name . "-" . $data->company->company_name;
                });
        if (!\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) {
            $roles = ArrayHelper::map(\common\models\RoleMaster::findAll(['company_id' => \Yii::$app->user->identity->branch->company_id]), 'id', 'role_name');
        }
        $branchList = ArrayHelper::map(CompanyBranch::find()->where(['company_id' => $model->branch->company_id])->all(), 'id', 'branch_name');
        $userDetailModel->email = $model->email;
        $states = ArrayHelper::map(States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        $city = !empty($userDetailModel->cityRef->state_id) ? ArrayHelper::map(Cities::findAll(['state_id' => $userDetailModel->cityRef->state_id]), 'id', 'city') : [];
        $userDetailModel->state = !empty($userDetailModel->cityRef->state_id) ? $userDetailModel->cityRef->state_id : '';
        if ($userDetailModel->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
            $userDetailModel->updated_at = CommonFunction::currentTimestamp();
            if ($userDetailModel->validate(['first_name', 'last_name', 'mobile_no', 'profile_pic', 'current_position', 'speciality', 'job_title', 'job_looking_from', 'travel_preference', 'ssn', 'work_authorization', 'work_authorization_comment', 'license_suspended', 'professional_liability'])) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model->role_id = $userDetailModel->role_id;
                    if (!\common\CommonFunction::isHoAdmin(Yii::$app->user->identity->id)) {
                        $model->branch_id = \Yii::$app->user->identity->branch_id;
                    } else {
                        $model->branch_id = $userDetailModel->branch_id;
                    }
                    if ($model->save()) {
                        $userDetailModel->user_id = $model->id;
                        if ($userDetailModel->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash("success", "Details updated successfully.");
                            return $this->redirect(['index']);
                        } else {
                            Yii::$app->session->setFlash("warning", "Something went wrong.");
                        }
                    }
                } catch (\Exception $ex) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('_form', [
                    'model' => $model, 'roles' => $roles,
                    'userDetailModel' => $userDetailModel,
                    'states' => $states, 'city' => $city,
                    'companyList' => $companyList, 'branchList' => $branchList
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

    public function actionGetBranches($id) {
        $branches = ArrayHelper::map(CompanyBranch::find()->where(['company_id' => $id])->all(), 'id', 'branch_name');
        $options = '';
        if (!empty($branches)) {
            foreach ($branches as $key => $branch) {
                $options .= "<option value=$key>$branch</option>";
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
