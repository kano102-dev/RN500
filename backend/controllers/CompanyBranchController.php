<?php

namespace backend\controllers;

use Yii;
use common\models\CompanyBranch;
use common\models\CompanyBranchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Cities;
use yii\helpers\ArrayHelper;
use common\models\UserDetails;
use common\CommonFunction;
use common\models\User;
use common\models\RoleMaster;
use common\models\PasswordResetRequestForm;
use yii\helpers\Url;
use yii\filters\AccessControl;

/**
 * CompanyBranchController implements the CRUD actions for CompanyBranch model.
 */
class CompanyBranchController extends Controller {

    public $title = "Branch";
    public $activeBreadcrumb, $breadcrumb;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'get-cities', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'get-cities'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('branch-create', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'update', 'get-cities'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('branch-update', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('branch-view', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('branch-delete', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
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
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['company-branch/index']),
        ];
    }

    /**
     * Lists all CompanyBranch models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new CompanyBranchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyBranch model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->activeBreadcrumb = "Detail View";
        $user = User::find()->where(['branch_id' => $id, 'is_owner' => User::OWNER_YES])->one();
        if ($user == null) {
            throw new NotFoundHttpException('Branch owner does not exists.');
        }
        $userDetailModel = $user->details;
        $userDetailModel->email = $user->email;
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'userDetailModel' => $userDetailModel,
        ]);
    }

    /**
     * Creates a new CompanyBranch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->activeBreadcrumb = "Create";
        $companyBranchModel = new CompanyBranch();
        $userDetailModel = new UserDetails();
        $branch_cities = $owner_cities = [];
        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1])->all(), 'id', 'company_name');
        if (!\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) {
            $companyList = [];
        }

        $roles = ArrayHelper::map(\common\models\RoleMaster::find()->where(['NOT IN', 'id', [\common\models\RoleMaster::RECRUITER_OWNER, \common\models\RoleMaster::Employer_OWNER]])->all(), 'id', function ($data) {
                    return $data->role_name . "-" . $data->company->company_name;
                });
        if (!\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) {
            $roles = ArrayHelper::map(\common\models\RoleMaster::find()->where(['company_id' => \Yii::$app->user->identity->branch->company_id])->andWhere(['NOT IN', 'id', [\common\models\RoleMaster::RECRUITER_OWNER, \common\models\RoleMaster::Employer_OWNER]])->all(), 'id', 'role_name');
        }

        if ($companyBranchModel->load(Yii::$app->request->post()) && $userDetailModel->load(Yii::$app->request->post())) {
            $is_success = false;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
                    $companyBranchModel->company_id = Yii::$app->user->identity->branch->company_id;
                }
                $companyBranchModel->is_default = CompanyBranch::IS_DEFAULT_NO;
                $companyBranchModel->created_at = $companyBranchModel->updated_at = CommonFunction::currentTimestamp();
                $userDetailModel->created_at = $userDetailModel->updated_at = CommonFunction::currentTimestamp();
                if ($companyBranchModel->save()) {
                    $user = new User();
                    $user->email = $userDetailModel->email;
                    $user->type = $companyBranchModel->company->type == 1 ? User::TYPE_RECRUITER : User::TYPE_EMPLOYER;
                    $user->status = User::STATUS_APPROVED;
                    $user->branch_id = $companyBranchModel->id;
                    $user->role_id = $userDetailModel->role_id;
                    $user->is_owner = User::OWNER_YES;
                    if ($user->save()) {
                        $userDetailModel->user_id = $user->id;
                        if ($userDetailModel->save()) {
                            $is_success = true;
                            $resetPasswordModel = new PasswordResetRequestForm();
                            $resetPasswordModel->email = $user->email;
                            if ($resetPasswordModel->sendEmail($is_welcome_mail = 1)) {
                                $is_success = true;
                            }
                        }
                    }
                }
                if ($is_success) {
                    $transaction->commit();
                    Yii::$app->session->setFlash("success", "Branch Added Successfully.");
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash("warning", "Something went wrong.");
                }
            } catch (\Exception $ex) {
                $transaction->rollBack();
            } finally {
//                return $this->redirect(['index']);
            }
        }

        return $this->render('_form', [
                    'companyBranchModel' => $companyBranchModel,
                    'states' => $states, 'companyList' => $companyList,
                    'branch_cities' => $branch_cities,
                    'owner_cities' => $owner_cities,
                    'userDetailModel' => $userDetailModel, 'roles' => $roles
        ]);
    }

    /**
     * Updates an existing CompanyBranch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $this->activeBreadcrumb = "Update";
        $companyBranchModel = $this->findModel($id);
        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        $companyBranchModel->state = isset($companyBranchModel->cityRef->state_id) ? $companyBranchModel->cityRef->state_id : '';
        $user = User::find()->where(['branch_id' => $id, 'is_owner' => User::OWNER_YES])->one();
        if ($user == null) {
            throw new NotFoundHttpException('Branch owner does not exists.');
        }
        $userDetailModel = $user->details;
        $userDetailModel->email = $user->email;
        $userDetailModel->state = isset($userDetailModel->cityRef->state_id) ? $userDetailModel->cityRef->state_id : '';

        $branch_cities = ArrayHelper::map(Cities::findAll(['state_id' => $companyBranchModel->state]), 'id', 'city');
        $owner_cities = ArrayHelper::map(Cities::findAll(['state_id' => $userDetailModel->state]), 'id', 'city');
        $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1])->all(), 'id', 'company_name');
        if (!\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) {
            if (\common\CommonFunction::isHoAdmin(Yii::$app->user->identity->id)) {
                $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1, 'id' => Yii::$app->user->identity->branch->company_id])->all(), 'id', 'company_name');
            } else {
                $companyList = [];
            }
        }
        $roles = ArrayHelper::map(\common\models\RoleMaster::find()->where(['NOT IN', 'id', [\common\models\RoleMaster::RECRUITER_OWNER, \common\models\RoleMaster::Employer_OWNER]])->all(), 'id', function ($data) {
                    return $data->role_name . "-" . $data->company->company_name;
                });
        if (!\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) {
            $roles = ArrayHelper::map(\common\models\RoleMaster::find()->where(['company_id' => \Yii::$app->user->identity->branch->company_id])->andWhere(['NOT IN', 'id', [\common\models\RoleMaster::RECRUITER_OWNER, \common\models\RoleMaster::Employer_OWNER]])->all(), 'id', 'role_name');
        }
        if ($companyBranchModel->load(Yii::$app->request->post()) && $userDetailModel->load(Yii::$app->request->post())) {
            $is_success = false;
            $transaction = Yii::$app->db->beginTransaction();
            try {

                $companyBranchModel->updated_at = $userDetailModel->updated_at = CommonFunction::currentTimestamp();
                $user->email = $userDetailModel->email;
                if ($companyBranchModel->save() && $userDetailModel->save() && $user->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash("success", "Branch Updated Successfully.");
                } else {
                    Yii::$app->session->setFlash("warning", "Something went wrong.");
                }
            } catch (\Exception $ex) {
                $transaction->rollBack();
            } finally {
                return $this->redirect(['view', 'id' => $companyBranchModel->id]);
            }
        }

        return $this->render('_form', [
                    'companyBranchModel' => $companyBranchModel,
                    'userDetailModel' => $userDetailModel,
                    'states' => $states, 'companyList' => $companyList,
                    'branch_cities' => $branch_cities,
                    'owner_cities' => $owner_cities, 'roles' => $roles
        ]);
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
     * Deletes an existing CompanyBranch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CompanyBranch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyBranch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = CompanyBranch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
