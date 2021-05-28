<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "education".
 *
 * @property int $id
 * @property int $user_id
 * @property string $degree_name
 * @property string $year_complete
 * @property string $institution
 * @property string $location
 *
 * @property User $user
 */
class Education extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'education';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['user_id', 'degree_name', 'year_complete', 'institution'], 'required'],
                [['user_id'], 'integer'],
                [['degree_name'], 'string', 'max' => 250],
                [['year_complete'], 'string', 'max' => 50],
                [['institution', 'location'], 'string', 'max' => 500],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
                [['institution'], 'match', 'pattern' => '/^[a-zA-Z0-9. ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
                [['user_id', 'degree_name', 'year_complete', 'institution', 'location'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'degree_name' => 'Degree Name',
            'year_complete' => 'Year Complete',
            'institution' => 'Institution',
            'location' => 'Location',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getLocationRel() {
        return $this->hasOne(Cities::className(), ['id' => 'location']);
    }

    public function getStateName() {
        return isset($this->locationRel->stateRef->state) ? $this->locationRel->stateRef->state : "";
    }

    
    public function getCityStateName() {
        $name = '';
        if ($this->locationRel) {
            $name .= $this->locationRel->city . " - " . $this->getStateName();
        }
        return $name;
    }

    public function getDegreeTypeName() {
        $name = '';
        if ($this->degree_name) {
            $name = isset(Yii::$app->params['DEGREE_TYPE'][$this->degree_name]) ? Yii::$app->params['DEGREE_TYPE'][$this->degree_name] : '';
        }
        return $name;
    }

}
