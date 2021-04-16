<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lead_benefit".
 *
 * @property int $lead_id
 * @property int $benefit_id
 *
 * @property Benefits $benefit
 */
class LeadBenefit extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lead_benefit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['lead_id', 'benefit_id'], 'required'],
                [['lead_id', 'benefit_id'], 'integer'],
                [['benefit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Benefits::className(), 'targetAttribute' => ['benefit_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'lead_id' => 'Lead ID',
            'benefit_id' => 'Benefit ID',
        ];
    }

    /**
     * Gets query for [[Benefit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBenefit() {
        return $this->hasOne(Benefits::className(), ['id' => 'benefit_id']);
    }

}
