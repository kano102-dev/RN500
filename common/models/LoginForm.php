<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\CommonFunction;

/**
 * Login form
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;
    public $otp;
    public $is_otp_sent;
    public $general_info;
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // username and password are both required
                [['username', 'password'], 'required'],
                ['username', 'email', 'message' => 'Please eneter valid email.'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            // otp validation
            ['is_otp_sent', 'boolean'],
                ['otp', 'number', 'message' => 'Please eneter numeric values only.'],
                ['otp', 'required', 'when' => function ($model) {
                    return $model->is_otp_sent;
                }],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }else{
                return true;
            }
        }
    }

    public function sendOTP() {
        $otp_generated = CommonFunction::generateOTP(6);
        $otp_request = new OtpRequest();
        $otp_request->otp = $otp_generated;
        $otp_request->is_verified = 0;
        $otp_request->created_at = $otp_request->updated_at = CommonFunction::currentTimestamp();
        $otp_request->user_id = ($this->_user) ? $this->_user->id : 0;
        if ($otp_request->save() && $this->sendOTPMail($otp_generated)) {
            $this->is_otp_sent = true;
        }else {
            $this->is_otp_sent = false;
        }
        return $this->is_otp_sent;

//                $this->otp = $otp_generated;
//                $this->general_info = "We have sent any OTP to your registered email  ";
    }

    public function sendOTPMail($otp) {
        $to_email = "ahuja.mohan5@gmail.com";
//        if($this->_user){
//            $to_email = $this->_user->email;
//        };
        
        try {
           $sent =  \Yii::$app->mailer->compose('login-otp',['otp'=>$otp])
                ->setFrom([$to_email => 'Test Mail'])
                ->setTo("dxffn3@kjjit.eu")
                ->setSubject('One Time Password (OTP) ')
                ->send();
           
           echo "<pre/>";
            print_r(" sent : ".$sent);
            exit;
            
        } catch (\Exception $ex) {
            echo "<pre/>";
            print_r($ex );
            exit;
            
        }
        
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
//            return $this->getUser();
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}
