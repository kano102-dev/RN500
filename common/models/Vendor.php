<?php

namespace common\models;

use Yii;
use borales\extensions\phoneInput\PhoneInputValidator;
/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 * @property string $company_name
 * @property string $email
 * @property int $phone
 * @property string $street_no
 * @property string $street_address
 * @property string|null $apt
 * @property string $city
 * @property int $zip_code
 * @property int $state
 * @property int $country
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name', 'email', 'phone', 'street_no', 'street_address', 'city', 'zip_code', 'state'], 'required'],
            ['email','email'],
            ['phone' , 'required', 'message' => 'Mobile No. cannot be blank.'],
            [['phone'], PhoneInputValidator::className()],
            [['zip_code'], 'match', 'pattern' => '/^([0-9]){5}?$/', 'message' => 'Please enter a valid 5 digit numeric {attribute}.'],
            [['phone', 'state', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['company_name', 'email', 'street_no', 'street_address', 'apt', 'city'], 'string', 'max' => 255],
            [['company_name','street_no','street_address','apt'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
            [['company_name','street_no','street_address','apt'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'street_no' => 'Street No.',
            'street_address' => 'Street Address',
            'apt' => 'Apt',
            'city' => 'City',
            'zip_code' => 'Zip Code',
            'state' => 'State',
            'country' => 'Country',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
    
    public function getStates()
    {
        return $this->hasOne(States::className(), ['id' => 'state']);
    }
    
    public function getCities()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city']);
    }
}
