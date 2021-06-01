<?php

namespace common\models;

use Yii;
use common\CommonFunction;

/**
 * This is the model class for table "role_master".
 *
 * @property int $id
 * @property string $role_name
 * @property int $created_at
 * @property int $updated_at
 */
class RoleMaster extends \yii\db\ActiveRecord {

    const RECRUITER_OWNER = 1;
    const Employer_OWNER = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'role_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['role_name', 'created_at', 'updated_at'], 'required'],
            [['company_id'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
            [['role_name'], 'string', 'max' => 250],
            ['company_id', 'required', 'when' => function ($model) {
                    return CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id);
                }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'company_id' => 'Company',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Updated',
        ];
    }

    public function getCompany() {
        return $this->hasOne(CompanyMaster::className(), ['id' => 'company_id']);
    }

}
