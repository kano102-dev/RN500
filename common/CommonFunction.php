<?php

namespace common;

use Yii;
use common\models\User;
use common\models\CompanyBranch;

class CommonFunction {

    public static function generateOTP($digits = 6) {
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

    // RETURN LOGGED_IN USER NAME ELSE EMPTY
    public static function getLoggedInUserFullname() {
        $name = "";
        if (isset(Yii::$app->user->identity->type)) {
            $name = Yii::$app->user->identity->getFullName();
        }
        return $name;
    }

    // RETURN LOGGED-IN USER BRANCH ID
    public static function getLoggedInUserBranchId() {
        $branchId = "";
        if (isset(Yii::$app->user->identity->branch)) {
            $branchId = Yii::$app->user->identity->branch->id;
        }
        return $branchId;
    }

    // RETURN LOGGED-IN USER COMPANY ID
    public static function getLoggedInUserCompanyId() {
        $companyId = "";
        if (isset(Yii::$app->user->identity->branch)) {
            $companyId = Yii::$app->user->identity->branch->company_id;
        }
        return $companyId;
    }

    // RETURN TRUE IF LOGGED-IN USER BELONGS TO DEFAULT BRANCH, GENERALLY "HO"
    public static function isLoggedInUserDefaultBranch() {
        $isDefaultBranchUser = false;
        if (isset(Yii::$app->user->identity->branch) && Yii::$app->user->identity->branch->is_default == CompanyBranch::IS_DEFAULT_YES) {
            $isDefaultBranchUser = true;
        }
        return $isDefaultBranchUser;
    }

    // RETURN TRUE IF LOGGED_IN USER IS RECRUITER ELSE FALSE
    public static function isRecruiter() {
        return (isset(Yii::$app->user->identity->type) && Yii::$app->user->identity->type == User::TYPE_RECRUITER) ? true : false;
    }

    // RETURN TRUE IF LOGGED_IN USER IS EMPLOYER ELSE FALSE
    public static function isEmployer() {
        return (isset(Yii::$app->user->identity->type) && Yii::$app->user->identity->type == User::TYPE_EMPLOYER) ? true : false;
    }

}
