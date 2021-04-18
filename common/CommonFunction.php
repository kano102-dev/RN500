<?php

namespace common;

use Yii;
use common\models\User;

class CommonFunction {

    public static function generateOTP($digits = 6) {
//      return (string) sprintf("%06d", mt_rand(1, 999999));
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $digits; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function currentTimestamp() {
        return time();
    }

    public static function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomNo = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNo .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomNo;
    }

    public static function checkAccess($permission, $user_id) {
        $flag = false;
        $auth = Yii::$app->authManager;
        $user = User::findOne(['id' => $user_id]);
        $isAdmin = $user->is_master_admin;
        $permissions = [];
        if (!$isAdmin) {
            if (!empty($user->role_id)) {
                $permissions = array_keys($auth->getAssignments($user->role_id));
            }
            $flag = in_array($permission, $permissions);
        } else {
            $flag = true;
        }
        return $flag;
    }

    public static function isMasterAdmin($user_id) {
        $user = User::findOne(['id' => $user_id]);
        $isAdmin = $user->is_master_admin;
        return $isAdmin;
    }

    public static function isHoAdmin($user_id) {
        $user = User::findOne(['id' => $user_id]);
        $isHoAdmin = $user->branch->is_default == 1 && $user->is_owner == 1 ? true : false;
        return $isHoAdmin;
    }

}
