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
use yii\web\Response;
use common\models\Cities;

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
                'only' => ['index', 'recruiter-lead', 'get-discipline', 'get-specialty', 'get-benefits'],
                'rules' => [
                    [
                        'actions' => ['index', 'get-discipline', 'get-specialty', 'get-benefits'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? ['@'] : ['*']
                    ],
                    [
                        'actions' => ['recruiter-lead'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::isRecruiter() ? ['@'] : ['*'] : ['*'],
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
        $request = \Yii::$app->getRequest()->get();
        $query = LeadMaster::find()->joinWith(['benefits', 'disciplines', 'specialty', 'branch'])->where(['lead_master.status' => LeadMaster::STATUS_APPROVED]);
        if (isset($request['discipline']) && !empty($request['discipline'])) {
            $query->andWhere(['IN', 'lead_discipline.discipline_id', implode(',', $request['discipline'])]);
        }
        if (isset($request['speciality']) && !empty($request['speciality'])) {
            $query->andWhere(['IN', 'lead_speciality.speciality_id', implode(',', $request['speciality'])]);
        }
        if (isset($request['benefit']) && !empty($request['benefit'])) {
            $query->andWhere(['IN', 'lead_benefit.benefit_id', implode(',', $request['benefit'])]);
        }
        if (isset($request['location']) && !empty($request['location'])) {
            $query->andWhere(['IN', 'lead_master.city', implode(',', $request['location'])]);
        }
        if (isset($request['salary']) && !empty($request['salary'])) {
            foreach ($request['salary'] as $value) {
                if ($value == 1) {
                    $query->andWhere(['>=', 'jobseeker_payment', 0]);
                    $query->andWhere(['<=', 'jobseeker_payment', 100]);
                }
                if ($value == 2) {
                    $query->andWhere(['>=', 'jobseeker_payment', 100]);
                    $query->andWhere(['<=', 'jobseeker_payment', 199]);
                }
                if ($value == 3) {
                    $query->andWhere(['>=', 'jobseeker_payment', 199]);
                    $query->andWhere(['<=', 'jobseeker_payment', 499]);
                }
                if ($value == 4) {
                    $query->andWhere(['>=', 'jobseeker_payment', 499]);
                    $query->andWhere(['<=', 'jobseeker_payment', 999]);
                }
                if ($value == 5) {
                    $query->andWhere(['>=', 'jobseeker_payment', 999]);
                    $query->andWhere(['<=', 'jobseeker_payment', 4999]);
                }
                if ($value == 6) {
                    $query->andWhere(['>=', 'jobseeker_payment', 4999]);
                }
            }
        }

        $query->groupBy(['lead_benefit.lead_id', 'lead_discipline.lead_id', 'lead_speciality.lead_id']);
        $query->orderBy(['lead_master.created_at' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
//        echo "<pre/>";print_r($pages);exit;
        return $this->render('index', ['models' => $models, 'pages' => $pages]);
    }

    public function actionRecruiterLead() {
        $request = \Yii::$app->getRequest()->get();
        $query = LeadMaster::find()->joinWith(['benefits', 'disciplines', 'specialty', 'branch'])->where(['lead_master.status' => LeadMaster::STATUS_APPROVED]);
        if (isset($request['discipline']) && !empty($request['discipline'])) {
            $query->andWhere(['IN', 'lead_discipline.discipline_id', implode(',', $request['discipline'])]);
        }
        if (isset($request['speciality']) && !empty($request['speciality'])) {
            $query->andWhere(['IN', 'lead_speciality.speciality_id', implode(',', $request['discipline'])]);
        }
        if (isset($request['benefit']) && !empty($request['benefit'])) {
            $query->andWhere(['IN', 'lead_benefit.benefit_id', implode(',', $request['benefit'])]);
        }
        if (isset($request['location']) && !empty($request['location'])) {
            $query->andWhere(['IN', 'lead_master.city', implode(',', $request['location'])]);
        }
        if (isset($request['salary']) && !empty($request['salary'])) {
            foreach ($request['salary'] as $value) {
                if ($value == 1) {
                    $query->andWhere(['>=', 'jobseeker_payment', 0]);
                    $query->andWhere(['<=', 'jobseeker_payment', 100]);
                }
                if ($value == 2) {
                    $query->andWhere(['>=', 'jobseeker_payment', 100]);
                    $query->andWhere(['<=', 'jobseeker_payment', 199]);
                }
                if ($value == 3) {
                    $query->andWhere(['>=', 'jobseeker_payment', 199]);
                    $query->andWhere(['<=', 'jobseeker_payment', 499]);
                }
                if ($value == 4) {
                    $query->andWhere(['>=', 'jobseeker_payment', 499]);
                    $query->andWhere(['<=', 'jobseeker_payment', 999]);
                }
                if ($value == 5) {
                    $query->andWhere(['>=', 'jobseeker_payment', 999]);
                    $query->andWhere(['<=', 'jobseeker_payment', 4999]);
                }
                if ($value == 6) {
                    $query->andWhere(['>=', 'jobseeker_payment', 4999]);
                }
            }
        }
        $query->groupBy(['lead_benefit.lead_id', 'lead_discipline.lead_id', 'lead_speciality.lead_id']);
        $query->orderBy(['lead_master.created_at' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('recruiter-lead', ['models' => $models, 'pages' => $pages]);
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

    public function actionGetCities($page, $q = null, $id = null) {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'name' => '']];
        if (!is_null($q) && !empty($q)) {
            $query = new \yii\db\Query;
            $query->select(['cities.id', 'CONCAT(city,"-",states.state) as name'])
                    ->from('cities')
                    ->innerJoin('states', 'states.id=cities.state_id')
                    ->where(['like', 'cities.city', $q])
                    ->offset($offset)
                    ->limit($limit);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            $out['pagination'] = ['more' => !empty($data) ? true : false];
        } elseif ($id > 0) {
            $query = new \yii\db\Query;
            $query->select(['cities.id', 'CONCAT(city,"-",states.state) as name'])
                    ->from('cities')
                    ->innerJoin('states', 'states.id=cities.state_id')
                    ->where(['in', 'cities.id', $id])
                    ->offset($offset)
                    ->limit($limit);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            $out['pagination'] = ['more' => !empty($data) ? true : false];
        }
        return $out;
    }

    public function actionView($id) {
        $model = LeadMaster::findOne(['id' => $id]);
        $benefit = LeadBenefit::findAll(['lead_id' => $id]);
        $specialty = LeadSpeciality::findAll(['lead_id' => $id]);
        $discipline = LeadDiscipline::findAll(['lead_id' => $id]);
        return $this->render('view', ['model' => $model, 'benefit' => $benefit, 'specialty' => $specialty, 'discipline' => $discipline]);
    }
    
    public function actionRecruiterView($id) {
        $model = LeadMaster::findOne(['id' => $id]);
        $benefit = LeadBenefit::findAll(['lead_id' => $id]);
        $specialty = LeadSpeciality::findAll(['lead_id' => $id]);
        $discipline = LeadDiscipline::findAll(['lead_id' => $id]);
        return $this->render('recruiter-view', ['model' => $model, 'benefit' => $benefit, 'specialty' => $specialty, 'discipline' => $discipline]);
    }

}
