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
class RecruiterForm extends \common\models\UserDetails {

    public $email;
    public $type;
    public $companyName;
    public $state;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['email'], 'email'],
            [['email'], 'required'],
            [['created_at', 'updated_at', 'unique_id', 'user_id'], 'safe'],
            [['first_name', 'last_name', 'email'], 'required'],
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

    public function checkUniqueValidation() {
        $userModel = User::find(['email' => $this->email])->orWhere(['status'=>0])->orWhere(['status'=>1])->createCommand()->rawSql;
        echo $userModel;exit;
        if (!empty($userModel)) {
            if ($userModel->status == 0 || $userModel->status == 1) {
                return $this->addError('email', 'Account Already Exist.');
            }
        }
    }

}
