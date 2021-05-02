<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\User;
use yii\helpers\Json;
use api\modules\v1\components\Controller;
use Firebase\JWT\JWT;
use common\models\OtpRequest;
use common\models\LoginForm;
use frontend\models\JobseekerForm;
use common\models\UserDetails;
use common\models\PasswordResetRequestForm;
use common\CommonFunction;
use common\models\LeadMaster;
use common\models\Benefits;
use common\models\Speciality;
use common\models\Discipline;
use common\models\Cities;

/**
 * Company Controller API
 */
class BrowseJobsController extends Controller {

    public $modelClass = 'common\models\LeadMaster';

    public function actionDisciplines() {
        $data = [];
        $code = 201;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        try {
            $paging = (isset($request['page']) && $request['page'] != '' && $request['page'] != 0) ? $request['page'] : 1;
            $disciplinList = [];
            $query = Discipline::find();
            $total_pages = (ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])) ? ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT']) : 1;
            if ($paging <= $total_pages) {
                $query->offset(($paging - 1) * Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])->limit(Yii::$app->params['API_PAGINATION_RECORD_LIMIT']);
                $lists = $query->all();
                foreach ($lists as $value) {
                    $disciplinList[] = ['id' => $value->id, 'name' => $value->name];
                }
            }
            $code = 200;
            $msg = "Success";
            $data = ['discipline' => $disciplinList];
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

    public function actionBenefits() {
        $data = [];
        $code = 201;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        try {
            $paging = (isset($request['page']) && $request['page'] != '' && $request['page'] != 0) ? $request['page'] : 1;
            $benfitsList = [];
            $query = Benefits::find();
            $total_pages = (ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])) ? ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT']) : 1;
            if ($paging <= $total_pages) {
                $query->offset(($paging - 1) * Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])->limit(Yii::$app->params['API_PAGINATION_RECORD_LIMIT']);
                $lists = $query->all();
                foreach ($lists as $value) {
                    $benfitsList[] = ['id' => $value->id, 'name' => $value->name];
                }
            }
            $code = 200;
            $msg = "Success";
            $data = ['benefits' => $benfitsList];
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

    public function actionSpecialty() {
        $data = [];
        $code = 201;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        try {
            $paging = (isset($request['page']) && $request['page'] != '' && $request['page'] != 0) ? $request['page'] : 1;
            $specialtyList = [];
            $query = Speciality::find();
            $total_pages = (ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])) ? ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT']) : 1;
            if ($paging <= $total_pages) {
                $query->offset(($paging - 1) * Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])->limit(Yii::$app->params['API_PAGINATION_RECORD_LIMIT']);
                $lists = $query->all();
                foreach ($lists as $value) {
                    $specialtyList[] = ['id' => $value->id, 'name' => $value->name];
                }
            }
            $code = 200;
            $msg = "Success";
            $data = ['specialty' => $specialtyList];
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

}
