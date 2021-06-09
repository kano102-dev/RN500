<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discipline".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property LeadDiscipline[] $leadDisciplines
 */
class Discipline extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 500],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
            ['name', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getAllDiscipline() {
        return self::find()->all();
    }

    /**
     * Gets query for [[LeadDisciplines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeadDisciplines() {
        return $this->hasMany(LeadDiscipline::className(), ['discipline_id' => 'id']);
    }

}
