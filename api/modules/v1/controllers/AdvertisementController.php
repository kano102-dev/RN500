<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Json;
use api\modules\v1\components\Controller;
use common\CommonFunction;
use common\models\Advertisement;
use yii\helpers\Url;

/**
 * Company Controller API
 */
class AdvertisementController extends Controller {

    public $modelClass = 'common\models\Advertisement';

    public function actionTest() {
        echo "Job Apply APIs Working";
        exit;
    }

    public function actionGetList() {
        $data = [];
        $code = 201;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        $today = date('Y-m-d');
        try {
            $paging = (isset($request['page']) && $request['page'] != '' && $request['page'] != 0) ? $request['page'] : 1;
            $search = (isset($request['filter']) && !empty($request['filter'])) ? $request['filter'] : '';

            $advertisementList = [];

            $query = Advertisement::find()->alias('ads')->where(['ads.is_active' => '1'])
                    ->andWhere("'$today' BETWEEN ads.active_from AND ads.active_to");

            if ($search != '') {
                $query->andWhere(['OR', ['ads.location' => $search], ['like', 'ads.name', $search]]);
            }

            $total_pages = (ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])) ? ceil($query->count() / Yii::$app->params['API_PAGINATION_RECORD_LIMIT']) : 1;
            if ($paging <= $total_pages) {
                $query->offset(($paging - 1) * Yii::$app->params['API_PAGINATION_RECORD_LIMIT'])->limit(Yii::$app->params['API_PAGINATION_RECORD_LIMIT']);
                $lists = $query->all();
                foreach ($lists as $model) {
                    $advertisementList[] = [
                        'name' => (string) $model->name,
                        'location' => $model->location,
                        'location_name' => isset($model->city->city) ? $model->city->city : '',
                        'active_from' => ($model->active_from != '' && $model->active_from != '0000-00-00') ? date('d-M-y', strtotime($model->active_from)) : '',
                        'active_to' => ($model->active_to != '' && $model->active_to != '0000-00-00') ? date('d-M-y', strtotime($model->active_to)) : '',
                        'file_type' => $model->file_type,
                        'file_type_name' => (isset(Yii::$app->params['ADS_FILE_TYPE'][$model->file_type])) ? Yii::$app->params['ADS_FILE_TYPE'][$model->file_type] : '',
                        'link_url' => $model->link_url,
                        'image' => ($model->file_type == Advertisement::FILE_TYPE_IMAGE && $model->icon != '' && file_exists(CommonFunction::getAdvertisementBasePath() . "/" . $model->icon) ) ? $model->icon : '',
                        'image_url' => ($model->file_type == Advertisement::FILE_TYPE_IMAGE && $model->icon != '' && file_exists(CommonFunction::getAdvertisementBasePath() . "/" . $model->icon) ) ? Url::to(Yii::$app->urlManagerFrontend->createUrl(["/uploads/advertisement/$model->icon"]), true) : '',
                    ];
                }
            }
            $code = 200;
            $msg = "Success";
            $data = $advertisementList;
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
