<?php

namespace api\modules\v1\components;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\data\ActiveDataProvider;
use \Firebase\JWT\JWT;
use common\models\base\BaseModel;
use common\models\User;
use common\models\MobileVersionMaster;
use yii\helpers\Json;

class Controller extends ActiveController {

    public $email;
    public $user_id;

    /**
     * check allowed domains and ip addresse for media syndication
     */
    public function beforeAction($action) {
        $data = [];
        $code = 201;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request;
        if (isset($request->headers['Platform']) && !empty($request->headers['Platform']) && isset($request->headers['Current-Version']) && !empty($request->headers['Current-Version'])) {
            $platform = $request->headers['Platform'] == 2 ? 'ios' : 'android';
            $mobileVersion = MobileVersionMaster::findOne(['device_type' => $platform]);
            if ($mobileVersion->version != $request->headers['Current-Version'] && $mobileVersion->force_update == 1) {
                $code = 304;
                $msg = "Update your app.";
            } else {
                if (!in_array($action->id, Yii::$app->params['disableAuth'])) {
                    if (isset($request->headers['Authorization']) && !empty($request->headers['Authorization'])) {
                        $jwtToken = $request->headers['Authorization'];
                        $checkAuthentication = $this->checkAuthentication($jwtToken);
                        if ($checkAuthentication) {
                            $user = User::findOne(['id' => $checkAuthentication->id, 'status' => User::STATUS_APPROVED, 'type' => User::TYPE_JOB_SEEKER]);
                            if (isset($user) && !empty($user)) {
                                if ($user->is_suspend == 1) {
                                    $code = 201;
                                    $msg = "Your Account Has Been Suspended.";
                                } else {
                                    $this->user_id = $user->id;
                                    $this->email = $user->email;
                                    return parent::beforeAction($action);
                                }
                            } else {
                                $code = 403;
                                $msg = "You are not authorized user.";
                            }
                        } else {
                            $code = 440;
                            $msg = "You are not authorized user.";
                        }
                    }
                } else {
                    return parent::beforeAction($action);
                }
            }
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function checkAuthentication($jwtToken) {
        $data = [];
        $code = 201;
        $msg = "Required parameter missing";
        $key = Yii::$app->params['jwtTokenInfo']["key"];
        try {
            $valid_data = JWT::decode($jwtToken, $key, array('HS256'));
            return $valid_data;
        } catch (\Exception $exc) {
            $code = 440;
            $msg = $exc->getMessage();
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

}

?>
