<?php

namespace common;

use Yii;
use common\models\User;
use common\models\CompanyBranch;
use common\models\CompanyMaster;
use common\models\CompanySubscription;
use common\models\CompanySubscriptionPayment;
use yii\helpers\Html;
use common\models\LeadMaster;
use common\models\LeadRecruiterJobSeekerMapping;

class CommonFunction {

    // GENERATE RANDOM DIGITS, ACCORDING TO LENGTH PASSED OTHERWISE 6 DIGITS
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

    // RETURN LOGGED-IN USER COMPANY ID
    public static function getLoggedInUserCompanyPriority() {
        $priority = "";
        if (isset(Yii::$app->user->identity->branch)) {
            $priority = Yii::$app->user->identity->branch->company->priority;
        }
        return $priority;
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

    // RETURN TRUE IF LOGGED_IN USER IS Jobseeker ELSE FALSE
    public static function isJobSeeker() {
        return (isset(Yii::$app->user->identity->type) && Yii::$app->user->identity->type == User::TYPE_JOB_SEEKER) ? true : false;
    }

    // RETURN TRUE IF LOGGED_IN USER assign permission ELSE FALSE
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

    // RETURN TRUE IF LOGGED_IN USER IS Super Admin ELSE FALSE
    public static function isMasterAdmin($user_id) {
        $user = User::findOne(['id' => $user_id]);
        $isAdmin = $user->is_master_admin;
        return $isAdmin;
    }

    // RETURN TRUE IF LOGGED_IN USER IS HO Admin ELSE FALSE
    public static function isHoAdmin($user_id) {
        $user = User::findOne(['id' => $user_id]);
        $isHoAdmin = $user->branch->is_default == 1 && $user->is_owner == 1 ? true : false;
        return $isHoAdmin;
    }

    // send Welcome mail
    public static function sendWelcomeMail($user) {
        $htmlLayout = '@common/mail/welcomeMail-html';
        $textLayout = '@common/mail/welcomeMail-text';
        $subject = 'Welcome To RN500';
        $name = isset($user->fullName) ? $user->fullName : "";
        return \Yii::$app->mailer->compose(['html' => $htmlLayout, 'text' => $textLayout], ['user' => $user, 'name' => $name])
                        ->setFrom([Yii::$app->params['senderEmail'] => \Yii::$app->params['senderName']])
                        ->setTo($user->email)
                        ->setSubject($subject)
                        ->send();
    }

    public static function dateDiffInDays($date1) {
        $date2 = strtotime('now');
        // Calculating the difference in timestamps
        $diff = $date2 - $date1;

        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400));
    }

    public static function isExpired() {
        $flag = true;
        $company_id = CommonFunction::getLoggedInUserCompanyId();
        if (isset(Yii::$app->user->identity) && !empty($company_id)) {
            $subscription = CompanySubscription::find()->where(['>=', 'start_date', date('Y-m-d', strtotime('now'))])->andWhere(['>=', 'start_date', date('Y-m-d', strtotime('now'))])->one();
            if (!empty($subscription)) {
                return false;
            } else {
                return true;
            }
        }
    }

    public static function getAllPurchasedLead() {
        $leads = [];
        $company_id = CommonFunction::getLoggedInUserCompanyId();
        if (isset(Yii::$app->user->identity) && !empty($company_id)) {
            $subscription_lead = CompanySubscriptionPayment::find()->select('company_subscription_payment.lead_id')->innerJoin('company_subscription', 'company_subscription.id=company_subscription_payment.subscription_id')->where(['company_subscription.company_id' => $company_id])->andWhere('company_subscription_payment.lead_id IS NOT NULL')->asArray()->all();
            $leads = array_column($subscription_lead, 'lead_id');
        }
        return $leads;
    }

    public static function isVisibleLead($approved_at) {
        $flag = false;
        $priority = CommonFunction::getLoggedInUserCompanyPriority();
        $approved_date = date('Y-m-d H:i:s', $approved_at);
        if (!empty($priority)) {
            if ($priority == CompanyMaster::PRIORITY_HIGH) {
                $flag = true;
            } else if ($priority == CompanyMaster::PRIORITY_MODRATE) {
                $new_time = date("Y-m-d H:i:s", strtotime($approved_date . '+24 hours'));
                $time = date("Y-m-d H:i:s", strtotime('now'));
                if ($new_time <= $time) {
                    $flag = true;
                }
            } else if ($priority == CompanyMaster::PRIORITY_SEMIMODRATE) {
                $new_time = date("Y-m-d H:i:s", strtotime($approved_date . '+36 hours'));
                $time = date("Y-m-d H:i:s", strtotime('now'));
                if ($new_time <= $time) {
                    $flag = true;
                }
            } else {
                $new_time = date("Y-m-d H:i:s", strtotime($approved_date . '+42 hours'));
                $time = date("Y-m-d H:i:s", strtotime('now'));
                if ($new_time <= $time) {
                    $flag = true;
                }
            }
        }
        return $flag;
    }

    public static function htmlEncodeLabel($str) {
        $var = Html::encode($str);
        return str_replace("&amp;", "&", $var);
    }

    // RETURN BASE PATH OF PROFILE PICTURE FOLDER
    public static function getProfilePictureBasePath() {
        return Yii::getAlias('@frontend') . "/web/uploads/user-details/profile";
    }

    // RETURN BASE PATH OF DOCUMENTS FOLDER
    public static function getDocumentBasePath() {
        return Yii::getAlias('@frontend') . "/web/uploads/user-details/document";
    }

    // RETURN BASE PATH OF LICENSES FOLDER
    public static function getLicensesBasePath() {
        return Yii::getAlias('@frontend') . "/web/uploads/user-details/license";
    }

    // RETURN BASE PATH OF LICENSES FOLDER
    public static function getCertificateBasePath() {
        return Yii::getAlias('@frontend') . "/web/uploads/user-details/certification";
    }

    /*
     * lead_master TABLE's branch_id WILL BE CONSIDERED AS EMPLOYER BRANCH OR LEAD POSTED BRANCH
     * 
     */

    public static function isLeadAppliedBranchAndPostedBranchSame($leadId, $appliedBranchId) {
        $flag = false;
        try {
            $leadMaster = LeadMaster::findOne($leadId);
            if ($leadMaster !== null) {
                $flag = (string) $leadMaster->branch_id == (string) $appliedBranchId;
            }
        } catch (\Exception $ex) {
            $flag = false;
        } finally {
            return $flag;
        }
    }

}
