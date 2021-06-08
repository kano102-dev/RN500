<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\UserDetails;
use common\models\WorkExperience;
use common\models\Documents;
use common\models\Licenses;
use common\models\Certifications;
use common\models\Education;
use common\models\References;

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

    // THIS ACTION CAN BE ACCESSIBLE WITHOUT LOGIN
    public function actionUserSummary($ref) {
        $model = UserDetails::find()->where(['unique_id' => $ref])->one();
        if ($model !== null) {
            $userId = $model->user_id;

            $workExperiences = WorkExperience::find()->where(['user_id' => $userId])->joinWith('discipline')->all();
            $certifications = Certifications::find()->where(['user_id' => $userId])->all();
            $documents = Documents::find()->where(['user_id' => $userId])->all();
            $licenses = Licenses::find()->where(['user_id' => $userId])->all();
            $educations = Education::find()->where(['user_id' => $userId])->all();
            $references = References::find()->where(['user_id' => $userId])->all();

            return $this->render('user-summary', ['model' => $model, 'workExperiences' => $workExperiences, 'certifications' => $certifications, 'documents' => $documents, 'licenses' => $licenses, 'educations' => $educations, 'references' => $references]);
        } else {
            throw new \yii\web\NotFoundHttpException("Oops! Something went wrong");
        }
    }

}
