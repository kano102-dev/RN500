<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\CommonFunction;
use common\models\CompanyMaster;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * Signup form
 */
class RecruiterCompanyForm extends CompanyMaster {

    public $state;
    public $mobile;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['mobile', 'company_name', 'company_email', 'website_link', 'company_mobile', 'street_no', 'street_address', 'city', 'updated_at'], 'required'],
            [['priority', 'city', 'is_master', 'created_at', 'updated_at'], 'integer'],
            [['company_name'], 'string', 'max' => 250],
            [['company_email'], 'email'],
            [['company_email'], 'string', 'max' => 100],
            [['employer_identification_number'], 'string', 'max' => 200],
            [['employer_identification_number'], 'checkUniqueEIN'],
            [['company_mobile'], 'string'],
            [['employer_identification_number'], 'required'],
            ['company_mobile' , 'required', 'message' => 'Mobile No. cannot be blank.'],
            [['company_mobile'], PhoneInputValidator::className()],
            [['street_no', 'street_address', 'apt'], 'string', 'max' => 255],
            [['zip_code'], 'string', 'max' => 20],
            [['website_link'], 'url'],
            [['state', 'type', 'status', 'reference_no', 'employer_identification_number','website_link'], 'safe'],
            [['company_name'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
            [['street_no'], 'match', 'pattern' => '/^[0-9 ]*$/', 'message' => 'Only number allowed for {attribute} field']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_name' => 'Name',
            'company_email' => 'Email',
            'company_mobile' => 'Mobile',
            'employer_identification_number' => 'Employer Indetification Number',
            'website_link' => 'Website Link',
            'mobile' => 'Mobile',
            'priority' => 'Priority',
            'street_no' => 'Street No',
            'street_address' => 'Street Address',
            'apt' => 'Suit/Apt',
            'city' => 'City',
            'zip_code' => 'Zip Code',
            'is_master' => 'Is Master',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function checkUniqueEIN($attribute) {
        $checkein = CompanyMaster::findOne(['employer_identification_number' => $this->employer_identification_number]);
        if (isset($checkein) && !empty($checkein)) {
            $this->addError("employer_identification_number", "Company already registered.");
        }
    }

    public function getUniqueReferenceNumber() {
        $code = CommonFunction::generateRandomString(15);
        $exits = self::find()->where(['reference_no' => $code])->one();
        if ($exits) {
            $this->getUniqueReferenceNumber();
        } else {
            return $code;
        }
    }

}
