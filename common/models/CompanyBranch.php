<?php

namespace common\models;

use Yii;
use common\CommonFunction;

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
 * @property string|null $email
 */
class CompanyBranch extends \yii\db\ActiveRecord {

    const IS_DEFAULT_YES = '1';
    const IS_DEFAULT_NO = '0';

    public $state;
    public $company_name;
    public $is_already_applied;

    public static function tableName() {
        return 'company_branch';
    }

    public function rules() {
        return [
            [['branch_name', 'street_no', 'street_address', 'city', 'updated_at', 'zip_code'], 'required'],
            [['company_id', 'city', 'is_default', 'created_at', 'updated_at'], 'integer'],
            [['branch_name'], 'string', 'max' => 200],
            [['street_no', 'street_address', 'apt'], 'string', 'max' => 255],
//            [['zip_code'], 'string', 'max' => 20],
            [['zip_code'], 'match', 'pattern' => '/^([0-9]){5}?$/', 'message' => 'Please enter a valid 5 digit numeric {attribute}.'],
            ['company_id', 'required', 'when' => function ($model) {
                    return isset(\Yii::$app->user->identity->id) ? CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id) : false;
                }],
            [['email', 'branch_name', 'street_no', 'street_address', 'apt', 'zip_code'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company',
            'branch_name' => 'Branch Name',
            'street_no' => 'Street No.',
            'street_address' => 'Street Address',
            'apt' => 'Suit/apt',
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

    public function getCityRef() {
        return $this->hasOne(Cities::className(), ['id' => 'city']);
    }

    public static function getAllBranchesOfLoggedInUser() {
        return self::find()->where(['company_id' => CommonFunction::getLoggedInUserCompanyId()])->all();
    }

    public function getLocation() {
        $location = "";
        if (isset($this->cityRef)) {
            $location = $this->cityRef->city . "-" . $this->cityRef->state_code;
        }
        return $location;
    }

}
