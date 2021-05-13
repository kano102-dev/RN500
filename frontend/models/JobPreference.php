<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "job_preference".
 *
 * @property int $id
 * @property int $user_id
 * @property string $job_preference
 * @property string $location
 * @property string $shift
 * @property string $pay
 */
class JobPreference extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_preference';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'job_preference', 'location', 'shift', 'pay'], 'required'],
            [['user_id'], 'integer'],
            [['job_preference', 'location', 'shift', 'pay'], 'string', 'max' => 255],
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
            'job_preference' => 'Job Preference',
            'location' => 'Location',
            'shift' => 'Shift',
            'pay' => 'Pay',
        ];
    }
}
