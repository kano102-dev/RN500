<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_details".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_no
 * @property int $address_id
 * @property string|null $profile_pic
 * @property string|null $current_position
 * @property string|null $speciality
 * @property string|null $work experience
 * @property int|null $job_title (1) Actively Looking, (2) Looking from Date: MM/DD/YYYY.
 * @property string|null $job_looking_from required when job_title 2
 * @property int|null $travel_preference (1) 100%, (2) 50%, (3) 25% (3) 0% (4) Available anytime.
 * @property int|null $ssn Last 4 Digit of SSN
 * @property int|null $work_authorization 1:US Citizen ( ),2: Green Card Holder ( ),3: Other
 * @property string|null $work_authorization_comment required when work_authorization 3
 * @property string|null $license_suspended
 * @property string|null $professional_liability
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class UserDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name', 'last_name', 'mobile_no', 'address_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'address_id', 'job_title', 'travel_preference', 'ssn', 'work_authorization', 'created_at', 'updated_at'], 'integer'],
            [['job_looking_from'], 'safe'],
            [['work_authorization_comment', 'license_suspended', 'professional_liability'], 'string'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['mobile_no'], 'string', 'max' => 11],
            [['profile_pic', 'current_position', 'speciality', 'work experience'], 'string', 'max' => 250],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'mobile_no' => 'Mobile No',
            'address_id' => 'Address ID',
            'profile_pic' => 'Profile Pic',
            'current_position' => 'Current Position',
            'speciality' => 'Speciality',
            'work experience' => 'Work Experience',
            'job_title' => '(1) Actively Looking, (2) Looking from Date: MM/DD/YYYY.',
            'job_looking_from' => 'required when job_title 2',
            'travel_preference' => '(1) 100%, (2) 50%, (3) 25% (3) 0% (4) Available anytime.',
            'ssn' => 'Last 4 Digit of SSN',
            'work_authorization' => '1:US Citizen ( ),2: Green Card Holder ( ),3: Other',
            'work_authorization_comment' => 'required when work_authorization 3',
            'license_suspended' => 'License Suspended',
            'professional_liability' => 'Professional Liability',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}