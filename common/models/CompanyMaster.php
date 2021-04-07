<?php

namespace common\models;

use Yii;

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
 */
class CompanyMaster extends \yii\db\ActiveRecord {

    public $state;

    public static function tableName() {
        return 'company_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['company_name', 'company_email', 'company_mobile', 'street_no', 'street_address', 'city', 'updated_at'], 'required'],
            [['priority', 'city', 'is_master', 'created_at', 'updated_at'], 'integer'],
            [['company_name'], 'string', 'max' => 250],
            [['company_email'], 'email'],
            [['company_email'], 'string', 'max' => 100],
            [['company_mobile'], 'string', 'max' => 11],
            [['street_no', 'street_address', 'apt'], 'string', 'max' => 255],
            [['zip_code'], 'string', 'max' => 20],
            [['state', 'type'], 'safe'],
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

}
