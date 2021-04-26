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

class Controller extends ActiveController {

    /**
     * check allowed domains and ip addresse for media syndication
     */
    public function beforeAction($action) {
        $request = Yii::$app->request;
        if (!in_array($action->id, Yii::$app->params['disableAuth'])) {
            if (isset($request->headers['auth_csrf_token']) && !empty($request->headers['auth_csrf_token'])) {
                $jwtToken = $request->headers['auth_csrf_token'];
                $checkAuthentication = $this->checkAuthentication($jwtToken);
            }
            if ($checkAuthentication) {
                $user = User::findOne(['id' => $checkAuthentication->id, 'status' => User::STATUS_APPROVED, 'type' => User::TYPE_JOB_SEEKER, 'is_suspend' => 0]);
                if (!isset($user) && empty($user)) {
                    return $this->authResponse();
                }
            } else {
                return $this->authResponse();
            }
        }
        return parent::beforeAction($action);
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function authResponse() {
        header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
        $this->asJson([
            'code' => '403',
            'message' => 'You don\'t have permission to access this APP',
        ]);
        return false;
    }

    public function checkAuthentication($jwtToken) {
        $key = Yii::$app->params['jwtTokenInfo']["key"];
        try {
            $valid_data = JWT::decode($jwtToken, $key, array('HS256'));
            return $valid_data;
        } catch (\Exception $e) {
            return $this->authResponse();
        }
    }

}

?>
