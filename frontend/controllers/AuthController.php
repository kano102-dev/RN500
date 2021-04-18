<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use common\models\UserDetails;
use common\models\CompanyMaster;
use common\models\CompanyBranch;
use yii\helpers\ArrayHelper;
use common\models\States;
use common\models\Cities;
use common\CommonFunction;
use frontend\models\EmployerForm;
use frontend\models\JobseekerForm;
use common\models\PasswordResetRequestForm;

/**
 * Site controller
 */
class AuthController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action) {
        if ($action->id == 'logout') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'get-cities', 'register', 'login', 'error', 'check-mail', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['get-cities', 'register', 'login', 'error', 'check-mail', 'reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
//                'actions' => ['logout' => ['post']],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        $this->layout = 'main-login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if (
                $model->load(Yii::$app->request->post()) &&
                $model->validatePassword('password', []) &&
                $model->sendOTP() &&
                $model->OTPVerified() &&
                $model->login()
        ) {
            if (Yii::$app->user->identity->type == 1) {
                return $this->redirect(['/site/index']);
            } else {
                return $this->goHome();
            }
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionRegister() {
        $this->layout = 'main-login';
        $model = new JobseekerForm();
        $employer = new EmployerForm();
        $companyMasterModel = new CompanyMaster;
        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        if (\Yii::$app->request->isPost) {
            if (isset($_POST['type']) && Yii::$app->request->post('type') === 'employer') {
                $companyMasterModel->reference_no = $companyMasterModel->getUniqueReferenceNumber();
                if ($employer->load(Yii::$app->request->post()) && $companyMasterModel->load(Yii::$app->request->post())) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        $companyMasterModel->created_at = $companyMasterModel->updated_at = CommonFunction::currentTimestamp();
                        if ($companyMasterModel->save()) {
                            $company_branch = new CompanyBranch();
                            $company_branch->branch_name = "HO";
                            $company_branch->city = $companyMasterModel->city;
                            $company_branch->company_id = $companyMasterModel->id;
                            $company_branch->setAttributes($companyMasterModel->getAttributes());
                            $company_branch->is_default = CompanyBranch::IS_DEFAULT_YES;
                            $company_branch->created_at = $company_branch->updated_at = CommonFunction::currentTimestamp();
                            if ($company_branch->save()) {
                                $user = new User();
                                $user->email = $employer->email;
                                $user->type = User::TYPE_EMPLOYER;
                                $user->status = User::STATUS_PENDING;
                                $user->is_owner = User::OWNER_YES;
                                $user->branch_id = $company_branch->id;
                                if ($user->save()) {
                                    $userDetails = New UserDetails();
                                    $userDetails->scenario = 'registration';
                                    $userDetails->email = $employer->email;
                                    $userDetails->first_name = $employer->first_name;
                                    $userDetails->last_name = $employer->last_name;
                                    $userDetails->user_id = $user->id;
                                    $userDetails->unique_id = $employer->getUniqueId();
                                    $userDetails->created_at = $userDetails->updated_at = CommonFunction::currentTimestamp();
                                    if ($userDetails->save(false)) {
                                        $is_error = 1;
                                        $resetPasswordModel = new PasswordResetRequestForm();
                                        $resetPasswordModel->email = $user->email;
                                        $is_welcome_mail = 1;
                                        if ($resetPasswordModel->sendEmail($is_welcome_mail)) {
                                            $is_error = 1;
                                        }
                                        CommonFunction::sendWelcomeMail($user);
                                    }
                                }
                            }
                        }
                        if ($is_error) {
                            $transaction->commit();
                            Yii::$app->session->setFlash("success", "You have registered successfully. Please check your email for verification.");
                            return $this->redirect(['login']);
                        } else {
                            $transaction->rollBack();
                            Yii::$app->session->setFlash("warning", "Something went wrong.");
                        }
                    } catch (\Exception $ex) {
                        $transaction->rollBack();
                    }
                }
            } else {
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        $user = new User();
                        $user->email = $model->email;
                        $user->type = User::TYPE_JOB_SEEKER;
                        $user->status = User::STATUS_APPROVED;
                        if ($user->save()) {
                            $userDetails = New UserDetails();
                            $userDetails->scenario = 'registration';
                            $userDetails->email = $model->email;
                            $userDetails->first_name = $model->first_name;
                            $userDetails->last_name = $model->last_name;
                            $userDetails->user_id = $user->id;
                            $userDetails->unique_id = $model->getUniqueId();
                            $userDetails->created_at = $userDetails->updated_at = CommonFunction::currentTimestamp();
                            if ($userDetails->save(false)) {
                                $transaction->commit();
                                $resetPasswordModel = new PasswordResetRequestForm();
                                $resetPasswordModel->email = $user->email;
                                $is_welcome_mail = 1;
                                $resetPasswordModel->sendEmail($is_welcome_mail);
                                CommonFunction::sendWelcomeMail($user);
                                Yii::$app->session->setFlash("success", "You have registered successfully. Please check your email for verification.");
                                return $this->redirect(['login']);
                            } else {
                                $transaction->rollBack();
                                Yii::$app->session->setFlash("warning", "Something went wrong.");
                            }
                        } else {
                            $transaction->rollBack();
                            Yii::$app->session->setFlash("warning", "Something went wrong.");
                        }
                    } catch (\Exception $ex) {
                        $transaction->rollBack();
                    }
                }
            }
        }
        return $this->render('register', [
                    'model' => $model, 'companyMasterModel' => $companyMasterModel,
                    'states' => $states, 'employer' => $employer
        ]);
    }

    public function actionGetCities($id) {
        $options = '';
        if (!empty($id)) {
            $cities = ArrayHelper::map(Cities::find()->where(['state_id' => $id])->all(), 'id', 'city');
            if (!empty($cities)) {
                foreach ($cities as $key => $city) {
                    $options .= "<option value=$key>$city</option>";
                }
            }
        }
        echo $options;
        exit;
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();
//        return $this->goHome();
        return $this->redirect(['login']);
    }

    public function actionCheckMail() {
        try {

//            $sent = \Yii::$app->mailer->compose('login-otp', ['otp' => $otp])
//                    ->setFrom([$to_email => 'Test Mail'])
//                    ->setTo("dxffn3@kjjit.eu")
//                    ->setSubject('One Time Password (OTP) ')
//                    ->send();
            $sent = \Yii::$app->mailer->compose()->setTextBody("Hii <br/> Your OT is 11111")
//                    ->setFrom(["info@RN500.com" => 'Test Mail'])
                    ->setFrom([\Yii::$app->params['senderEmail'] => \Yii::$app->params['senderName']])
                    ->setTo('ranamehul19@gmail.com')
                    ->setSubject('One Time Password (OTP) ')
                    ->send();
            echo "SENT : " . $sent;
        } catch (\Exception $ex) {
            echo "<pre/>";
            print_r($ex);
            exit;
        }
    }

}
