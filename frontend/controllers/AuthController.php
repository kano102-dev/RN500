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
                'actions' => ['logout' => ['post']],
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
//            $model->password = '';
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionRegister() {
        $this->layout = 'main-login';
        $model = new UserDetails();
        $model->scenario = 'registration';
        $companyMasterModel = new CompanyMaster;
        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (isset($_POST['type']) && Yii::$app->request->post('type') === 'employer') {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($companyMasterModel->save()) {
                        $company_branch = new CompanyBranch();
                        $company_branch->branch_name = "HO";
                        $company_branch->city = $companyMasterModel->city;
                        $company_branch->company_id = $companyMasterModel->id;
                        $company_branch->setAttributes($companyMasterModel->getAttributes());
                        $company_branch->is_default = CompanyBranch::IS_DEFAULT_YES;
                        if ($company_branch->save()) {
                            $user = new User();
                            $user->email = $model->email;
                            $user->setPassword($model->password);
                            $user->original_password = $model->password;
                            $user->type = User::TYPE_RECRUITER;
                            $user->status = User::STATUS_INACTIVE;
                            $user->branch_id = $company_branch->id;
                            $user->is_owner = User::OWNER_YES;
                            if ($user->save()) {
                                $model->user_id = $user->id;
                                $unique_id = CommonFunction::generateRandomString();
                                $details = UserDetails::findOne(['unique_id' => $unique_id]);
                                if (!empty($details)) {
                                    $unique_id = CommonFunction::generateRandomString();
                                }
                                $model->unique_id = $unique_id;
                                if ($model->save()) {
                                    $is_error = 1;
                                }
                            }
                        }
                    }
                    if ($is_error) {
                        $transaction->commit();
                        Yii::$app->session->setFlash("success", "You have registered successfully.");
                        return $this->redirect(['login']);
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash("warning", "Something went wrong.");
                    }
                } catch (\Exception $ex) {
                    $transaction->rollBack();
                }
            } else {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $user = new User();
                    $user->email = $model->email;
                    $user->setPassword($model->password);
                    $user->original_password = $model->password;
                    $user->type = User::TYPE_JOB_SEEKER;
                    $user->status = User::STATUS_ACTIVE;
                    if ($user->save()) {
                        $model->user_id = $user->id;
                        $unique_id = CommonFunction::generateRandomString();
                        $details = UserDetails::findOne(['unique_id' => $unique_id]);
                        if (!empty($details)) {
                            $unique_id = CommonFunction::generateRandomString();
                        }
                        $model->unique_id = $unique_id;
                        if ($model->save(false)) {
                            $transaction->commit();
                            Yii::$app->session->setFlash("success", "You have registered successfully.");
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
        return $this->render('register', [
                    'model' => $model, 'companyMasterModel' => $companyMasterModel,
                    'states' => $states
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
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $this->layout = 'main-login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', "Reset Password Link sent sucessfully. Ckeck your registered email id");

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', "something went wrong");
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        $this->layout = 'main-login';
        try {
            $model = new \common\models\ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Password reset sucessfully');

            return $this->goHome();
        }

        return $this->render('reset-password', [
                    'model' => $model,
        ]);
    }

    public function actionChangePassword() {
        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = \app\models\User::findIdentity(Yii::$app->user->identity->id);
            $user->password_hash = trim($model->new_password);
            if ($user->save()) {
                Yii::$app->session->setFlash('success', "Password changed successfully");
                Yii::$app->user->logout();
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', "Something went wrong");
            }
            return $this->redirect(['dashboard/index']);
        }

        return $this->render('change-password', [
                    'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
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
