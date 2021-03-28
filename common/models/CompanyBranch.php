<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_branch".
 *
 * @property int $id
 * @property int $company_id
 * @property string $branch_name
 * @property string $street_no
 * @property string $street_address
 * @property string|null $apt
 * @property int|null $city
 * @property string|null $zip_code
 * @property int $is_default 1:yes 0:no
 * @property int $created_at
 * @property int $updated_at
 */
class CompanyBranch extends \yii\db\ActiveRecord {

    const IS_DEFAULT_YES = '1';
    const IS_DEFAULT_NO = '0';

    public static function tableName() {
        return 'company_branch';
    }

    public function rules() {
        return [
                [['company_id', 'branch_name', 'street_no', 'street_address', 'is_default', 'created_at', 'updated_at'], 'required'],
                [['company_id', 'city', 'is_default', 'created_at', 'updated_at'], 'integer'],
                [['branch_name'], 'string', 'max' => 200],
                [['street_no', 'street_address', 'apt'], 'string', 'max' => 255],
                [['zip_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'branch_name' => 'Branch Name',
            'street_no' => 'Street No',
            'street_address' => 'Street Address',
            'apt' => 'Apt',
            'city' => 'City',
            'zip_code' => 'Zip Code',
            'is_default' => 'Is Default',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    
     public function getCompany() {
        return $this->hasOne(CompanyMaster::className(), ['id' => 'company_id']);
    }

}
