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
use common\models\Cities;

/**
 * Site controller
 */
class JobController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['post'],
                'rules' => [
                    [
                        'actions' => ['post'],
                        'allow' => true,
                        'roles' => (CommonFunction::isEmployer() || CommonFunction::isRecruiter()) ? ['@'] : ['*'],
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

    public function actionPost() {
        $model = new LeadMaster();
        $model->reference_no = $model->getUniqueReferenceNumber();
        $model->branch_id = CommonFunction::getLoggedInUserBranchId();
        $disciplineList = ArrayHelper::map(Discipline::getAllDiscipline(), 'id', 'name');
        $benefitList = ArrayHelper::map(Benefits::getAllBenefits(), 'id', 'name');
        $specialiesList = ArrayHelper::map(Speciality::getAllSpecialities(), 'id', 'name');
        $branchList = ArrayHelper::map(CompanyBranch::getAllBranchesOfLoggedInUser(), 'id', 'branch_name');
        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        $cities = [];
        if ($model->load(Yii::$app->request->post())) {
            if (!CommonFunction::isLoggedInUserDefaultBranch()) {
                $model->branch_id = CommonFunction::getLoggedInUserBranchId();
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->start_date = date("Y-m-d", strtotime($model->start_date));
                $model->end_date = ($model->end_date) ? $model->end_date = date("Y-m-d", strtotime($model->end_date)) : null;
                $model->created_at = $model->updated_at = CommonFunction::currentTimestamp();
                $model->created_by = $model->updated_by = Yii::$app->user->identity->id;
                if ($model->validate() && $model->save()) {
                    $lead_id = $model->id;
                    if (isset($model->disciplines) && !empty($model->disciplines)) {
                        foreach ($model->disciplines as $key => $discipline_id) {
                            $leadDiscipline = new LeadDiscipline();
                            $leadDiscipline->lead_id = $lead_id;
                            $leadDiscipline->discipline_id = $discipline_id;
                            $leadDiscipline->save();
                        }
                    }

                    if (isset($model->benefits) && !empty($model->benefits)) {
                        foreach ($model->benefits as $key => $benefit_id) {
                            $leadBenefit = new LeadBenefit();
                            $leadBenefit->lead_id = $lead_id;
                            $leadBenefit->benefit_id = $benefit_id;
                            $leadBenefit->save();
                        }
                    }

                    if (isset($model->specialies) && !empty($model->specialies)) {
                        foreach ($model->specialies as $key => $specialt_id) {
                            $leadSpeciality = new LeadSpeciality();
                            $leadSpeciality->lead_id = $lead_id;
                            $leadSpeciality->speciality_id = $specialt_id;
                            $leadSpeciality->save();
                        }
                    }
                    $transaction->commit();
                    Yii::$app->session->setFlash("success", "Job Posted Successfully.");
                }
            } catch (\Exception $ex) {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
                $transaction->rollBack();
            } finally {
                return $this->redirect(['post']);
            }
        }
        return $this->render('post', [
                    'model' => $model,
                    'disciplinesList' => $disciplineList,
                    'benefitList' => $benefitList,
                    'specialiesList' => $specialiesList, 'cities' => $cities,
                    'branchList' => $branchList, 'states' => $states,
        ]);
    }

    public function actionGetCities($id) {
        $cities = ArrayHelper::map(Cities::find()->where(['state_id' => $id])->all(), 'id', 'city');
        $options = '';
        if (!empty($cities)) {
            foreach ($cities as $key => $city) {
                $options .= "<option value=$key>$city</option>";
            }
        }
        echo $options;
        exit;
    }

}
