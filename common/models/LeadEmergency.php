<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lead_emergency".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $emergency_id
 */
class LeadEmergency extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lead_emergency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['lead_id', 'emergency_id'], 'required'],
            [['lead_id', 'emergency_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'lead_id' => 'Lead ID',
            'emergency_id' => 'Emergency ID',
        ];
    }

    /**
     * Gets query for [[Discipline]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmergency() {
        return $this->hasOne(Emergency::className(), ['id' => 'emergency_id']);
    }

}
