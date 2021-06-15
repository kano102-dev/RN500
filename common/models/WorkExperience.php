<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "work_experience".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property int|null $discipline_id
 * @property int|null $specialty
 * @property int|null $employment_type
 * @property int|null $currently_working
 * @property string|null $facility_name
 * @property int|null $city
 * @property string $start_date
 * @property string $end_date
 * @property string $organization_name
 * @property string $description
 * @property string $updated_at
 * @property string $created_at
 *
 * @property User $user
 */
class WorkExperience extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'work_experience';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['user_id', 'start_date', 'employment_type','title'], 'required'],
                [['user_id', 'discipline_id', 'specialty', 'employment_type', 'currently_working','created_at','updated_at'], 'integer'],
                [['start_date', 'end_date', 'city'], 'safe'],
                [['end_date'], 'required', "message" => "Please enter {attribute}.", 'when' => function($model) {
                    return $model->currently_working == 0;
                }, 'whenClient' => "function (attribute, value) {
                return (!$('#currently_working').is(':checked'));
            }"],
                [['title', 'facility_name'], 'string', 'max' => 255],
                [['organization_name', 'description'], 'string', 'max' => 500],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
                [['title', 'facility_name'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'discipline_id' => 'Discipline',
            'specialty' => 'Specialty',
            'employment_type' => 'Employment Type',
            'currently_working' => 'Currently Working',
            'facility_name' => 'Facility Name',
            'city' => 'City',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'organization_name' => 'Organization Name',
            'description' => 'Description',
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

    public function getDiscipline() {
        return $this->hasOne(\common\models\Discipline::className(), ['id' => 'discipline_id']);
    }

    public function getSpecialityRel() {
        return $this->hasOne(\common\models\Speciality::className(), ['id' => 'specialty']);
    }

    public function getCityRel() {
        return $this->hasOne(\common\models\Cities::className(), ['id' => 'city']);
    }
    
    public function getStateName() {
        return isset($this->cityRel->stateRef->state) ? $this->cityRel->stateRef->state :"" ;
    }
    
    public function getCityStateName(){
        $name = '';
        if($this->cityRel){
            $name .= $this->cityRel->city . " - " . $this->getStateName();
            
        }
        return $name;
    }
    
    public function getEmploymentTypeName(){
        $name = '';
        if($this->employment_type){
            $name = isset(Yii::$app->params['EMPLOYEMENT_TYPE'][$this->employment_type]) ? Yii::$app->params['EMPLOYEMENT_TYPE'][$this->employment_type] : '';
            
        }
        return $name;
    }

}
