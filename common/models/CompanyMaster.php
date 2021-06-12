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
 * @property int $is_suspend
 */
class CompanyMaster extends \yii\db\ActiveRecord {

    public $state;

    const PRIORITY_HIGH = 1;
    const PRIORITY_MODRATE = 2;
    const PRIORITY_SEMIMODRATE = 3;
    const PRIORITY_LOW = 4;

    public static function tableName() {
        return 'company_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [

            [['company_name','website_link', 'company_email', 'street_address', 'city', 'updated_at','zip_code'], 'required'],
            ['company_mobile', 'required', 'message' => 'Mobile No. cannot be blank.'],
            ['street_no', 'required', 'message' => 'Street No. cannot be blank.'],
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
            [['zip_code'], 'match', 'pattern' => '/^([0-9]){5}?$/', 'message' => 'Please enter a valid 5 digit numeric {attribute}.'],
            [['company_name','company_email','state', 'type', 'status','company_mobile' ,'reference_no', 'employer_identification_number','mobile','street_no','street_address','apt','zip_code'], 'safe'],
            [['website_link'], 'url'],
            [['company_name'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
            [['street_no'], 'match', 'pattern' => '/^[0-9 ]*$/', 'message' => 'Only number allowed for {attribute} field'],
            [['is_suspend'], 'safe']
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
            'street_no' => 'Street No.',
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
        $query = CompanyMaster::find()->where(['employer_identification_number' => $this->employer_identification_number]);
        if (isset($this->id) && !empty($this->id)) {
            $query->andWhere(['!=', 'id', $this->id]);
        }
        $checkein = $query->one();
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
