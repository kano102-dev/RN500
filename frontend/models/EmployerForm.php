<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\CommonFunction;
use common\models\UserDetails;

/**
 * Signup form
 */
class EmployerForm extends \common\models\UserDetails {

    public $email;
    public $type;
    public $companyName;
    public $state;
    public $password;
    public $confirm_password;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['email'], 'email'],
            [['email'], 'required'],
            [['created_at', 'updated_at', 'unique_id', 'user_id'], 'safe'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password'],
            [['first_name', 'last_name', 'email', 'password', 'confirm_password'], 'required'],
            [['email'], 'checkUniqueValidation'],
        ];
    }

    public function getUniqueId() {
        $unique_id = CommonFunction::generateRandomString();
        $details = UserDetails::findOne(['unique_id' => $unique_id]);
        if (!empty($details)) {
            $this->getUniqueId();
        }
        return $unique_id;
    }

}
