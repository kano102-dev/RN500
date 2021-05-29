<?php

namespace common\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "licenses".
 *
 * @property int $id
 * @property int $issuing_state
 * @property string $license_name
 * @property string|null $license_number
 * @property int|null $compact_states
 * @property string|null $document
 * @property string $expiry_date
 * @property string $issue_by
 * @property int $verified 1:yes 0:no
 * @property int $user_id
 *
 * @property User $user
 */
class Licenses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'licenses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['license_name', 'expiry_date', 'user_id'], 'required'],
            [['issuing_state', 'compact_states', 'verified', 'user_id'], 'integer'],
            [['license_name', 'license_number', 'issue_by'], 'string', 'max' => 250],
            [['document'], 'string', 'max' => 255],
            [['expiry_date'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['license_number'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
            [['document'], 'file', 'skipOnEmpty' => true, 'extensions'=>['png', 'jpg', 'jpeg'], 'checkExtensionByMimeType'=>false]
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
            'license_name' => 'License Name',
            'license_number' => 'License Number',
            'compact_states' => 'Compact States',
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
