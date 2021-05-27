<?php

namespace common\models;

use Yii;
use common\CommonFunction;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * This is the model class for table "company_master".
 *
 * @property int $id
 * @property string $company_name
 * @property string $company_email
 * @property string $company_mobile
 * @property int $priority 1:high 2:modrate 3:semi modrate 4:low
 * @property string $street_no
 * @property string $street_address
 * @property string|null $apt
 * @property int|null $city
 * @property string|null $zip_code
 * @property int $is_master
 * @property int $created_at
 * @property int $updated_at
 * @property string $reference_no
 */
class CompanyMaster extends \yii\db\ActiveRecord {

    public $state;

    const PRIORITY_HIGH = 1;
    const PRIORITY_MODRATE = 2;
    const PRIORITY_SEMIMODRATE = 3;
    const PRIORITY_LOW = 4;

    public $mobile;

    public static function tableName() {
        return 'company_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['mobile', 'company_name', 'company_email', 'company_mobile', 'street_no', 'street_address', 'city', 'updated_at'], 'required'],
            [['priority', 'city', 'is_master', 'created_at', 'updated_at'], 'integer'],
            [['company_name'], 'string', 'max' => 250],
            [['company_email'], 'email'],
            [['company_email'], 'string', 'max' => 100],
            [['employer_identification_number'], 'string', 'max' => 200],
            [['employer_identification_number'], 'checkUniqueEIN'],
            [['employer_identification_number'], 'required'],
            [['company_mobile'], 'string'],
            [['company_mobile'], PhoneInputValidator::className()],
            [['street_no', 'street_address', 'apt'], 'string', 'max' => 255],
            [['zip_code'], 'string', 'max' => 20],
            [['state', 'type', 'status', 'reference_no', 'employer_identification_number'], 'safe'],
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

    public function getCityRef() {
        return $this->hasOne(Cities::className(), ['id' => 'city']);
    }

}
