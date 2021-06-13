<?php

namespace common\models;

use Yii;
use common\CommonFunction;

/**
 * This is the model class for table "lead_rating".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $rating
 * @property int $user_id Job seeker ID
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class LeadRating extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lead_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['lead_id', 'rating', 'user_id', 'created_at', 'updated_at'], 'required'],
                [['lead_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
                [['rating'], 'number'],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'lead_id' => 'Lead ID',
            'rating' => 'Rating',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function saveRating($userId, $leadId, $rating) {
        $model = self::find()->where(['user_id' => $userId, 'lead_id' => $leadId])->one();
        if ($model == null) {
            $model = new self();
            $model->created_at = CommonFunction::currentTimestamp();
            $model->user_id = $userId;
            $model->lead_id = $leadId;
        }
        $model->rating = $rating;
        $model->updated_at = CommonFunction::currentTimestamp();
        return ($model->save()) ? true : $model->getErrors();
    }
    

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
