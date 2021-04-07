<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use common\models\UserDetails;

/**
 * Site controller
 */
class AuthController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['register', 'login', 'error', 'check-mail', 'reset-password'],
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
                'actions' => [
//                    'logout' => ['post'],
                ],
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
            return $this->goBack();
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
        return $this->render('register', [
                    'model' => $model,
        ]);
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
