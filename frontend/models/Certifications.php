<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "certifications".
 *
 * @property int $id
 * @property int $issuing_state
 * @property string $certificate_name
 * @property int|null $certification_active
 * @property string|null $document
 * @property string $expiry_date
 * @property string $issue_by
 * @property int $verified
 * @property int $user_id
 *
 * @property User $user
 */
class Certifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'certifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['certificate_name', 'user_id'], 'required'],
            [['issuing_state', 'certification_active', 'verified', 'user_id'], 'integer'],
            [['certificate_name', 'expiry_date'], 'string', 'max' => 250],
            [['document'], 'string', 'max' => 255],
            [['issue_by'], 'string', 'max' => 500],
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
            'issuing_state' => 'Issuing State',
            'certificate_name' => 'Certificate Name',
            'certification_active' => 'Certification Active',
            'document' => 'Document',
            'expiry_date' => 'Expiry Date',
            'issue_by' => 'Issue By',
            'verified' => 'Verified',
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
