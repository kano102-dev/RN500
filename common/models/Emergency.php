<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emergency".
 *
 * @property int $id
 * @property string $name
 */
class Emergency extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'emergency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
            [['name'], 'string', 'max' => 255],
            [['status'], 'integer'],
            [['name', 'status'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public static function getAllEmergency() {
        return self::find()->all();
    }

    /**
     * Gets query for [[LeadEmergency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeadEmergency() {
        return $this->hasMany(LeadEmergency::className(), ['emergency_id' => 'id']);
    }

}
