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

/**
 * Company Controller API
 */
class AuthController extends Controller {

    public $modelClass = 'common\models\User';

    public function actionLogin() {
        $data = [];
        $code = 201;
        $msg = "Required parameter missing";
        $request = Yii::$app->request->post();
        try {
            if (isset($request["email"]) && isset($request['password']) && !empty($request["email"]) && !empty($request["password"])) {
                $user = User::findOne(['email' => $request["email"], 'status' => User::STATUS_APPROVED, 'type' => User::TYPE_JOB_SEEKER, 'is_suspend' => 0]);
                if (!empty($user) && $user->validatePassword($request['password'])) {
                    $model = new LoginForm();
                    $model->username = $user->email;
                    $model->password = $request["password"];
                    if (isset($request['otp']) && !empty($request['otp'])) {
                        $model->otp = $request['otp'];
                        if ($model->OTPVerified()) {
                            $jwtToken = $this->generateJWTtoken($user);
                            $code = 200;
                            $msg = "You have successfully Logged In!";
                            $data = ['token' => $jwtToken];
                        } else {
                            $code = 202;
                            $msg = "Invalid OTP.";
                        }
                    } else {
                        $model->sendOTP();
                        $code = 301;
                        $msg = "We have sent an OTP to your registered email.";
                    }
                } else {
                    $code = 202;
                    $msg = "Invalid email or password";
                }
            }
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, (count($data) > 0) ? $data : new \yii\base\Object]);
        echo $response;
        exit;
    }

    public function actionResendOtp() {
        $data = [];
        $code = 201;
        $msg = "Required parameter missing";
        $request = Yii::$app->request->post();
        try {
            if (isset($request["email"]) && isset($request['password']) && !empty($request["email"]) && !empty($request["password"])) {
                $user = User::findOne(['email' => $request["email"], 'status' => User::STATUS_APPROVED, 'type' => User::TYPE_JOB_SEEKER, 'is_suspend' => 0]);
                if (!empty($user) && $user->validatePassword($request['password'])) {
                    $sent_otp_detail = OtpRequest::find()->where(['user_id' => $user->id, 'is_verified' => OtpRequest::STATUS_NOT_VERIFIED])->orderBy("id desc")->one();
                    if (!empty($sent_otp_detail)) {
                        $sent = \Yii::$app->mailer->compose('login-otp', ['otp' => $sent_otp_detail->otp])
                                ->setFrom([\Yii::$app->params['senderEmail'] => \Yii::$app->params['senderName']])
                                ->setTo($user->email)
                                ->setSubject('RN500 Verification Code')
                                ->send();
                    }
                } else {
                    $code = 202;
                    $msg = "Invalid email or password";
                }
            }
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, (count($data) > 0) ? $data : new \yii\base\Object]);
        echo $response;
        exit;
    }

    public function generateJWTtoken($user) {
        $key = Yii::$app->params['jwtTokenInfo']["key"];
        $token = array(
            "id" => $user->id,
            "encPID" => (string) $user->id,
            "randomString" => \common\CommonFunction::generateRandomString(32),
            "iat" => time(),
            "exp" => time(),
        );
        return JWT::encode($token, $key);
    }

}
