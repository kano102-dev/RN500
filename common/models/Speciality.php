<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "speciality".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property LeadSpeciality[] $leadSpecialities
 */
class Speciality extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'speciality';
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
            ['name','safe']
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

    public static function getAllSpecialities() {
        return self::find()->all();
    }

    /**
     * Gets query for [[LeadSpecialities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeadSpecialities() {
        return $this->hasMany(LeadSpeciality::className(), ['speciality_id' => 'id']);
    }

}
