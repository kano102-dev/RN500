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

}
