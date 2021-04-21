<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LeadMaster;
use common\CommonFunction;
use common\models\CompanyBranch;
use common\models\Benefits;
use common\models\Speciality;
use common\models\Discipline;
use yii\helpers\ArrayHelper;
use common\models\LeadDiscipline;
use common\models\LeadBenefit;
use common\models\LeadSpeciality;
use yii\helpers\Json;

/**
 * BrowseJobs controller
 */
class BrowseJobsController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    public function actionIndex() {

        return $this->render('index');
    }

    public function actionGetDiscipline($page = 0) {
        $offset = isset($page) && !empty($page) ? $page : 0;
        $limit = 10;
        $totalRecord = Discipline::find()->count();
        $lists = ArrayHelper::map(Discipline::find()->limit($limit)->offset($offset)->all(), 'id', 'name');
        $options = "";
        foreach ($lists as $key => $list) {
            $options .= "<li>
                                <input type='checkbox' name='discipline' value='$key' id='desc-$key' />
                                <label for='$key'></label>" . $list . " 
                            </li>";
        }
        $response = ['options' => $options, 'totalPage' => $totalRecord, 'offset' => count($lists)];
        echo Json::encode($response);
        exit;
    }
    
    public function actionGetSpecialty($page = 0) {
        $offset = isset($page) && !empty($page) ? $page : 0;
        $limit = 10;
        $totalRecord = Speciality::find()->count();
        $lists = ArrayHelper::map(Speciality::find()->limit($limit)->offset($offset)->all(), 'id', 'name');
        $options = "";
        foreach ($lists as $key => $list) {
            $options .= "<li>
                                <input type='checkbox' name='speciality' value='$key' id='spec-$key' />
                                <label for='$key'></label>" . $list . " 
                            </li>";
        }
        $response = ['options' => $options, 'totalPage' => $totalRecord, 'offset' => count($lists)];
        echo Json::encode($response);
        exit;
    }

}
