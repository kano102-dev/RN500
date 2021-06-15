<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['error', 'login', 'error', 'check-mail', 'reset-password', 'logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'check-mail', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['error', 'logout', 'check-mail', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        $counts = [];
        $counts['recruiter'] = \common\models\User::find()->where(['type' => \common\models\User::TYPE_RECRUITER, 'is_suspend' => 0, 'status' => \common\models\User::STATUS_APPROVED])->count();
        $counts['employer'] = \common\models\User::find()->where(['type' => \common\models\User::TYPE_EMPLOYER, 'is_suspend' => 0, 'status' => \common\models\User::STATUS_APPROVED])->count();
        $counts['jobseeker'] = \common\models\User::find()->where(['type' => 3, 'is_suspend' => 0, 'status' => \common\models\User::STATUS_APPROVED])->count();
        $counts['lead'] = \common\models\LeadMaster::find()->where(['status' => \common\models\LeadMaster::STATUS_APPROVED])->count();
        $counts['branch'] = \common\models\CompanyBranch::find()->where(['company_id' => \Yii::$app->user->identity->branch->company_id])->count();
        $staff = \common\models\User::find()->joinWith(['branch'])->innerJoin('company_master', 'company_master.id=company_branch.company_id')->andWhere(['!=', 'is_owner', 1]);
        if (\common\CommonFunction::isHoAdmin(Yii::$app->user->identity->id)) {
            $staff->andWhere(['company_master.id' => \Yii::$app->user->identity->branch->company_id]);
        } else {
            $staff->andWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }
        $counts['staff'] = $staff->count();
        return $this->render('index', ['counts' => $counts]);
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

    //This will call on error
    public function actionError() {
        $this->layout = "error";
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    public function actionCheckMail() {
        try {
//            $resetPasswordModel = new \common\models\PasswordResetRequestForm();
//            $resetPasswordModel->email = "ranamehulj@gmail.com";
//            $is_welcome_mail=1;
//            echo $resetPasswordModel->sendEmail($is_welcome_mail);exit;
//            $sent = \Yii::$app->mailer->compose('login-otp', ['otp' => $otp])
//                    ->setFrom([$to_email => 'Test Mail'])
//                    ->setTo("dxffn3@kjjit.eu")
//                    ->setSubject('One Time Password (OTP) ')
//                    ->send();
            $sent = \Yii::$app->mailer->compose()->setTextBody("Hii <br/> Your OT is 11111")
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
