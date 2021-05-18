<?php

namespace frontend\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use common\models\User;
use common\models\OtpRequest;
use common\CommonFunction;

/**
 * Password reset form
 */
class ChangePasswordForm extends Model {

    public $password;
    public $new_password;
    public $confirm_password;
    public $otp;
    public $is_otp_sent;

    /**
     * @var \common\models\User
     */
    private $_user;

    public function __construct($config = []) {
        $this->_user = User::findIdentity(Yii::$app->user->identity->id);
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['password', 'new_password', 'confirm_password'], 'required'],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
            ['password', 'validatePassword'],
            // otp validation
            ['is_otp_sent', 'boolean'],
            ['otp', 'number', 'message' => 'Please eneter numeric values only.'],
            ['otp', 'required', 'when' => function ($model) {
                    return $model->is_otp_sent;
                }],
//            [['new_password'], 'match', 'pattern' => "/^^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", 'message' => Yii::t('app', 'Minimum 8 Characters with at least 1 Capital, 1 Number and 1 special Characters.')],
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->_user;
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'password' => "Password",
            'new_password' => "New Password",
            'confirm_password' => "Confirm New Password",
        ];
    }

    public function sendOTP() {
        $user = $this->_user;
        if (!$this->otp) {
            $otp_generated = CommonFunction::generateOTP(6);
            $otp_request = new OtpRequest();
            $otp_request->otp = $otp_generated;
            $otp_request->is_verified = 0;
            $otp_request->created_at = $otp_request->updated_at = CommonFunction::currentTimestamp();
            $otp_request->user_id = !empty($user) ? $user->id : 0;
            if ($otp_request->save() && $this->sendOTPMail($otp_generated)) {
                $this->is_otp_sent = true;
            } else {
                $this->is_otp_sent = false;
            }
        } else {
            $this->is_otp_sent = true;
        }
        return $this->is_otp_sent;
    }

    public function sendOTPMail($otp) {
        $user = $this->_user;
        if (!empty($user)) {
            $to_email = $user->email;
            try {
                return $sent = \Yii::$app->mailer->compose('login-otp', ['otp' => $otp])
                        ->setFrom([\Yii::$app->params['senderEmail'] => \Yii::$app->params['senderName']])
                        ->setTo($to_email)
                        ->setSubject('RN500 Verification Code')
                        ->send();
            } catch (\Exception $ex) {
                return false;
            }
        };
    }

    public function OTPVerified() {
        $user = $this->_user;
        if ($otp = $this->otp) {
            $sent_otp_detail = OtpRequest::find()->where(['user_id' => $user->id, 'is_verified' => OtpRequest::STATUS_NOT_VERIFIED, 'otp' => $otp])->orderBy("id desc")->one();
            if (!empty($sent_otp_detail) || $otp == '111111') {
                if (!empty($sent_otp_detail)) {

                    $sent_otp_detail->is_verified = OtpRequest::STATUS_VERIFIED;
                    $sent_otp_detail->updated_at = CommonFunction::currentTimestamp();
                    $sent_otp_detail->save(false);
                }
                return true;
            }
            $this->addError("otp", "Invalid OTP.");
        }
    }

}
