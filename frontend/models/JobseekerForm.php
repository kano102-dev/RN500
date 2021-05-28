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
class JobseekerForm extends \common\models\UserDetails {

    public $email;
    public $type;
    public $companyName;
    public $state;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['email'], 'email', 'message' => 'Please enter valid email id!'],
            [['email'], 'checkUniqueValidation'],
            [['email'], 'required'],
            [['created_at', 'updated_at', 'unique_id', 'user_id'], 'safe'],
            [['first_name', 'last_name', 'email'], 'required'],
            [['first_name', 'last_name'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field']
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

    public function checkUniqueValidation($attribute, $param) {
        $query = User::find()->where(['email' => $this->email, 'is_suspend' => 0])->andWhere(['in', 'status', ["0", "1"]]);
        if (isset($this->id) && !empty($this->id)) {
            $query->andWhere(['!=', 'id', $this->id]);
        }
        $data = $query->one();
        if (!empty($data)) {
            return $this->addError('email', "Email already exists.");
        }
        return true;
    }

}
