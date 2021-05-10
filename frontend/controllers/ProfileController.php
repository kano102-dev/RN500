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
class ProfileController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action) {
        if ($action->id == 'logout') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

//    public function behaviors() {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout', 'index', 'get-cities', 'register', 'login', 'error', 'check-mail', 'reset-password'],
//                'rules' => [
//                    [
//                        'actions' => ['get-cities', 'register', 'login', 'error', 'check-mail', 'reset-password'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['logout', 'index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
////                'actions' => ['logout' => ['post']],
//            ],
//        ];
//    }

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
    
    public function actionEditProfile() {        
        return $this->renderAjax('edit-profile');
    }
    
    

}
