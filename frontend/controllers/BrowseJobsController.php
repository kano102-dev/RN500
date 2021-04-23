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
        $query = LeadMaster::find();
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', ['models' => $models, 'pages' => $pages]);
    }

    public function actionGetDiscipline() {
        $request = Yii::$app->getRequest()->post();
        $page = isset($request['page']) ? $request['page'] : 0;
        $filter = isset($request['filter']) && !empty($request['filter']) ? explode(',', $request['filter']) : [];
        $offset = isset($page) && !empty($page) ? $page : 0;
        $limit = 10;
        $totalRecord = Discipline::find()->count();
        $lists = ArrayHelper::map(Discipline::find()->limit($limit)->offset($offset)->all(), 'id', 'name');
        $options = "";
        foreach ($lists as $key => $list) {
            $options .= "<li>";
            if (in_array($key, $filter)) {
                $options .= "<input type='checkbox' name='discipline[]' value='$key' id='desc-$key' checked />";
            } else {
                $options .= "<input type='checkbox' name='discipline[]' value='$key' id='desc-$key' />";
            }
            $options .= "<label for='desc-$key'></label>" . $list;
            $options .= "</li>";
        }
        $response = ['options' => $options, 'totalPage' => $totalRecord, 'offset' => count($lists)];
        echo Json::encode($response);
        exit;
    }

    public function actionGetSpecialty() {
        $request = Yii::$app->getRequest()->post();
        $page = isset($request['page']) ? $request['page'] : 0;
        $filter = isset($request['filter']) && !empty($request['filter']) ? explode(',', $request['filter']) : [];
        $offset = isset($page) && !empty($page) ? $page : 0;
        $limit = 10;
        $totalRecord = Speciality::find()->count();
        $lists = ArrayHelper::map(Speciality::find()->limit($limit)->offset($offset)->all(), 'id', 'name');
        $options = "";
        foreach ($lists as $key => $list) {
            $options .= "<li>";
            if (in_array($key, $filter)) {
                $options .= "<input type='checkbox' name='speciality[]' value='$key' id='spec-$key' checked />";
            } else {
                $options .= "<input type='checkbox' name='speciality[]' value='$key' id='spec-$key' />";
            }
            $options .= "<label for='spec-$key'></label>" . $list;
            $options .= "</li>";
        }
        $response = ['options' => $options, 'totalPage' => $totalRecord, 'offset' => count($lists)];
        echo Json::encode($response);
        exit;
    }

    public function actionGetBenefits() {
        $request = Yii::$app->getRequest()->post();
        $page = isset($request['page']) ? $request['page'] : 0;
        $filter = isset($request['filter']) && !empty($request['filter']) ? explode(',', $request['filter']) : [];
        $offset = isset($page) && !empty($page) ? $page : 0;
        $limit = 10;
        $totalRecord = Benefits::find()->count();
        $lists = ArrayHelper::map(Benefits::find()->limit($limit)->offset($offset)->all(), 'id', 'name');
        $options = "";
        foreach ($lists as $key => $list) {
            $options .= "<li>";
            if (in_array($key, $filter)) {
                $options .= "<input type='checkbox' name='benefit[]' value='$key' id='benefit-$key' checked />";
            } else {
                $options .= "<input type='checkbox' name='benefit[]' value='$key' id='benefit-$key' />";
            }
            $options .= "<label for='benefit-$key'></label>" . $list;
            $options .= "</li>";
        }
        $response = ['options' => $options, 'totalPage' => $totalRecord, 'offset' => count($lists)];
        echo Json::encode($response);
        exit;
    }

}
