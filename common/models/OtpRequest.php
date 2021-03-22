<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "otp_request".
 *
 * @property int $id
 * @property int $otp
 * @property int $is_verified
 * @property int $created_at
 * @property int $updated_at
 * @property int $user_id
 *
 * @property User $user
 */
class OtpRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'otp_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['otp', 'is_verified', 'created_at', 'updated_at', 'user_id'], 'required'],
            [['otp', 'is_verified', 'created_at', 'updated_at', 'user_id'], 'integer'],
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
            'otp' => 'Otp',
            'is_verified' => 'Is Verified',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
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
