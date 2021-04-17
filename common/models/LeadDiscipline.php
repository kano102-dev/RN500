<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lead_discipline".
 *
 * @property int $lead_id
 * @property int $discipline_id
 *
 * @property Discipline $discipline
 */
class LeadDiscipline extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lead_discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['lead_id', 'discipline_id'], 'required'],
                [['lead_id', 'discipline_id'], 'integer'],
                [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::className(), 'targetAttribute' => ['discipline_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'lead_id' => 'Lead ID',
            'discipline_id' => 'Discipline ID',
        ];
    }

    /**
     * Gets query for [[Discipline]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiscipline() {
        return $this->hasOne(Discipline::className(), ['id' => 'discipline_id']);
    }

}
