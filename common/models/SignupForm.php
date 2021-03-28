<?php
//
//namespace common\models;
//
//use Yii;
//use yii\base\Model;
//use common\CommonFunction;
//
///**
// * Login form
// */
//class SignupForm extends Model {
//
//    // scenarios
//
//    CONST SCENARIO_ADMINPANEL_RECRUITER_CREATE = 'adminpanel-recruiter-create';
//
//    public $user_type;
//    // COMPANY FIELDS
//    public $company_name;
//    public $company_email;
//    public $company_mobile;
//    public $company_priority;
//    public $company_street_no;
//    public $company_street_address;
//    public $company_apt;
//    public $company_city;
//    public $company_zip_code;
//    // USER FIELDS
//    public $user_first_name;
//    public $user_last_name;
//    public $user_email;
//    public $user_street_no;
//    public $user_street_address;
//    public $user_apt;
//    public $user_city;
//    public $user_zip_code;
//
//    /**
//     * {@inheritdoc}
//     */
//    public function rules() {
//        return [
//                [['user_type', 'company_name', 'company_email', 'company_mobile', 'company_street_no', 'company_street_address', 'company_apt', 'company_city', 'company_zip_code', 'user_first_name', 'user_last_name', 'user_email', 'user_street_no', 'user_street_address', 'user_apt', 'user_city', 'user_zip_code'], 'required', 'on' => self::SCENARIO_ADMINPANEL_RECRUITER_CREATE],
//                [['user_type', 'company_name', 'company_email', 'company_mobile', 'company_priority', 'company_street_no', 'company_street_address', 'company_apt', 'company_city', 'company_zip_code', 'user_first_name', 'user_last_name', 'user_email', 'user_street_no', 'user_street_address', 'user_apt', 'user_city', 'user_zip_code'], 'safe']
//        ];
//    }
//
//    public function scenarios() {
//        $scenarios = parent::scenarios();
//        $scenarios[self::SCENARIO_ADMINPANEL_RECRUITER_CREATE] = ['user_type', 'company_name', 'company_email', 'company_mobile', 'company_priority', 'company_street_no', 'company_street_address', 'company_apt', 'company_city', 'company_zip_code', 'user_first_name', 'user_last_name', 'user_email', 'user_street_no', 'user_street_address', 'user_apt', 'user_city', 'user_zip_code']; //Scenario Values Only Accepted
//        return $scenarios;
//    }
//
//    public function attributeLabels() {
//        return [
//            'user_type' => 'Type',
//            'company_name' => 'company_name',
//            'company_email' => 'company_email',
//            'company_mobile' => 'company_mobile',
//            'company_priority' => 'company_priority',
//            'company_street_no' => 'company_street_no',
//            'company_street_address' => 'company_street_address',
//            'company_apt' => 'company_apt',
//            'company_city' => 'company_city',
//            'company_zip_code' => 'company_zip_code',
//            'user_first_name' => 'user_first_name',
//            'user_last_name' => 'user_last_name',
//            'user_email' => 'user_email',
//            'user_street_no' => 'user_street_no',
//            'user_street_address' => 'user_street_address',
//            'user_apt' => 'user_apt',
//            'user_city' => 'user_city',
//            'user_zip_code' => 'user_zip_code',
//        ];
//    }
//
//}
