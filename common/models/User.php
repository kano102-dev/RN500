<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_PENDING = 0;
    const STATUS_REJECTED = 2;
    const STATUS_APPROVED = 1;
    const OWNER_NO = 0;
    const OWNER_YES = 1;
    // USER TYPES
    const TYPE_RECRUITER = 1;
    const TYPE_EMPLOYER = 2;
    const TYPE_JOB_SEEKER = 3;
    const TYPE_STAFF = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['email'], 'required'],
                [['comment'], 'required', 'on' => 'reject'],
                [['password_reset_token', 'original_password', 'auth_key', 'is_suspend', 'comment'], 'safe'],
                [['email'], 'email'],
                ['status', 'default', 'value' => self::STATUS_PENDING],
                ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_REJECTED]],
                ['is_owner', 'default', 'value' => self::OWNER_NO],
                ['is_owner', 'in', 'range' => [self::OWNER_YES, self::OWNER_NO]],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['approve'] = ['comment', 'status'];
        $scenarios['reject'] = ['comment', 'status'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_APPROVED]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['email' => $username, 'status' => self::STATUS_APPROVED]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                    'verification_token' => $token
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function getDetails() {
        return $this->hasOne(UserDetails::className(), ['user_id' => 'id']);
    }

    public function getBranch() {
        return $this->hasOne(CompanyBranch::className(), ['id' => 'branch_id']);
    }

    public function getFullName() {
        $name = '';
        if (!empty($this->details)) {
            $name = $this->details->first_name . " " . $this->details->last_name;
        }
        return $name;
    }

    // public function getBranch() {
    //     return $this->hasOne(UserDetails::className(), ['user_id' => 'id']);
    // }
}
