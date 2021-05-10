<?php

namespace frontend\models;

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
class Education extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'education';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'degree_name', 'year_complete', 'institution', 'location'], 'required'],
            [['user_id'], 'integer'],
            [['degree_name'], 'string', 'max' => 250],
            [['year_complete'], 'string', 'max' => 50],
            [['institution', 'location'], 'string', 'max' => 500],
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
