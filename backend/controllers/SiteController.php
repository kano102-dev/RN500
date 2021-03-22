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
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'check-mail'],
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validatePassword('password', []) && $model->sendOTP()) {
            echo "<pre/>";
            $user = $model->getUser();
            print_r($user);
            exit;
//            $user->

            return $this->goBack();
        } else {
//            $model->password = '';
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
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
//            echo "<pre/>";
//            print_r(\Yii::$app->mailer);
//            exit;
            $sent = \Yii::$app->mailer->compose()
//                    ->setFrom(["info@RN500.com" => 'Test Mail'])
                    ->setFrom(["info@RN500.com" => 'Test Mail'])
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
