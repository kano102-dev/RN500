<?php
namespace frontend\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use common\models\User;


/**
 * Password reset form
 */
class ChangePasswordForm extends Model {

    public $password;
    public $new_password;
    public $confirm_password;

    /**
     * @var \common\models\User
     */
    private $_user;

    public function __construct($config = []) {
        $this->_user = User::findIdentity(Yii::$app->user->identity->id);
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['password', 'new_password', 'confirm_password'], 'required'],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
            ['password', 'validatePassword'],
//            [['new_password'], 'match', 'pattern' => "/^^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", 'message' => Yii::t('app', 'Minimum 8 Characters with at least 1 Capital, 1 Number and 1 special Characters.')],
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->_user;
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'password' => "Password",
            'new_password' => "New Password",
            'confirm_password' => "Confirm New Password",
        ];
    }

}
