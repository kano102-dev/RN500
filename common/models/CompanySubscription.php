<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_subscription".
 *
 * @property int $id
 * @property int $company_id
 * @property int $package_id
 * @property string|null $start_date
 * @property string|null $expiry_date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class CompanySubscription extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'company_subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['company_id', 'package_id'], 'required'],
            [['company_id', 'package_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['start_date', 'expiry_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'package_id' => 'Package ID',
            'start_date' => 'Start Date',
            'expiry_date' => 'Expiry Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
