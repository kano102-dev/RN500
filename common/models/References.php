<?php

namespace common\models;

use Yii;
use common\models\User;
use borales\extensions\phoneInput\PhoneInputValidator;
/**
 * This is the model class for table "references".
 *
 * @property int $id
 * @property string $first_name
 * @property int|null $title
 * @property string $last_name
 * @property string $mobile_no
 * @property string $email
 * @property int $city
 * @property int $state
 * @property string $relation
 * @property int $user_id
 *
 * @property User $user
 */
class References extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'references';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'mobile_no', 'email', 'user_id'], 'required'],
            [['title', 'city', 'state', 'user_id'], 'integer'],
            ['email','email'],
//            [['mobile_no'], 'match', 'pattern' => '/^([0-9]){10}?$/', 'message' => 'Please enter a valid 10 digit numeric {attribute}.'],
            [['mobile_no'], PhoneInputValidator::className()],
            [['first_name', 'last_name', 'email', 'relation'], 'string', 'max' => 250],
            [['mobile_no'], 'string', 'max' => 11],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['first_name','last_name'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'title' => 'Title',
            'last_name' => 'Last Name',
            'mobile_no' => 'Mobile No',
            'email' => 'Email',
            'city' => 'City',
            'state' => 'State',
            'relation' => 'Relation',
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
