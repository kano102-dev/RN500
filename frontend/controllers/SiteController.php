<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\WorkExperience;
use common\models\Documents;
use common\models\Licenses;
use common\models\Certifications;
use common\models\Education;
use common\models\References;
use common\models\UserDetails;
use common\models\JobPreference;
use common\models\LeadMaster;
use yii\base\DynamicModel;
use yii\web\NotFoundHttpException;

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
                'only' => ['logout', 'signup', 'job-seeker'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['job-seeker'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? ['@'] : ['*'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $today = date('Y-m-d', strtotime('now'));
        $advertisment = \common\models\Advertisement::find()->where(['is_active' => '1'])->andWhere(['and', "active_from>=$today", "active_to<=$today"])->asArray()->all();
        $query = LeadMaster::find()->joinWith(['benefits', 'disciplines', 'specialty', 'branch'])->where(['lead_master.status' => LeadMaster::STATUS_APPROVED]);
        $query->groupBy(['lead_master.id']);
        $query->orderBy(['lead_master.created_at' => SORT_DESC]);
        $leadModels = $query->limit(10)->all();
        return $this->render('index', [
                    'advertisment' => $advertisment, 'leadModels' => $leadModels
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionJobSeeker() {


//        if (isset(\Yii::$app->user->identity->id) && isset(\Yii::$app->user->identity->type) && \Yii::$app->user->identity->type == \common\models\User::TYPE_JOB_SEEKER) {
        $workExperience = WorkExperience::find()->where(['user_id' => Yii::$app->user->id])->joinWith('discipline')->asArray()->all();
        $certification = Certifications::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
        $documents = Documents::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
        $license = Licenses::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
        $education = Education::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
        $references = References::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
        $userDetails = UserDetails::findOne(['user_id' => Yii::$app->user->id]);
        $jobPreference = JobPreference::find()->where(['user_id' => Yii::$app->user->id])->all();

        return $this->render('job-seeker', [
                    'workExperience' => $workExperience,
                    'certification' => $certification,
                    'documents' => $documents,
                    'license' => $license,
                    'education' => $education,
                    'references' => $references,
                    'userDetails' => $userDetails,
                    'jobPreference' => $jobPreference
        ]);
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token) {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail() {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
                    'model' => $model
        ]);
    }

    public function actionContactUs() {
        $postData = Yii::$app->request->post();
        $model = new DynamicModel(['name', 'email', 'subject', 'message']);

        $model->addRule(['name', 'email', 'subject', 'message'], 'string')
                ->addRule(['name', 'email', 'subject', 'message'], 'required')
                ->addRule('email', 'email');

        if ($model->load(Yii::$app->request->post())) {
            if (ContactForm::sendContactUsEmail($postData)) {
                Yii::$app->session->setFlash("success", "Thank you for contacting. We will right back to you soon.");
                return $this->redirect(['site/contact-us']);
            }
        }

        return $this->render('contact-us', ['model' => $model]);
    }

    public function actionAboutUs() {
        return $this->render('about-us');
    }

}
