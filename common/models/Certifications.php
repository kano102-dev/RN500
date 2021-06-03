<?php

namespace common\models;

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
 * @property int $created_at
 * @property int $updated_at
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
            [['certificate_name', 'user_id','issue_by'], 'required'],
            ['document','required','on' => 'create'],
            [['issuing_state', 'certification_active', 'verified', 'user_id','created_at','updated_at'], 'integer'],
            [['certificate_name', 'expiry_date'], 'string', 'max' => 250],
            [['document'], 'string', 'max' => 255],
            [['issue_by'], 'string', 'max' => 500],
            [['issue_by'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['document', 'file', 'extensions' => ['png', 'jpg','jpeg','docx','pdf'], 'maxSize' => 1024 * 1024 * 2],
        ];
    }
    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['certificate_name','certification_active','issue_by','issuing_state','expiry_date','document','user_id','created_at','updated_at'];
        return $scenarios;
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
    
    public function getIssuingStateRef() {
        return $this->hasOne(Cities::className(), ['id' => 'issuing_state']);
    }

    public function getStateName() {
        return isset($this->issuingStateRef->stateRef->state) ? $this->issuingStateRef->stateRef->state : "";
    }

    public function getCityStateName() {
        $name = '';
        if ($this->issuingStateRef) {
            $name .= $this->issuingStateRef->city . " - " . $this->getStateName();
        }
        return $name;
    }
}
