<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lead_speciality".
 *
 * @property int $lead_id
 * @property int $speciality_id
 *
 * @property Speciality $speciality
 */
class LeadSpeciality extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lead_speciality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['lead_id', 'speciality_id'], 'required'],
                [['lead_id', 'speciality_id'], 'integer'],
                [['speciality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speciality::className(), 'targetAttribute' => ['speciality_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'lead_id' => 'Lead ID',
            'speciality_id' => 'Speciality ID',
        ];
    }

    /**
     * Gets query for [[Speciality]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpeciality() {
        return $this->hasOne(Speciality::className(), ['id' => 'speciality_id']);
    }

}
