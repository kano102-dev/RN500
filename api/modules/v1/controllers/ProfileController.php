<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Json;
use api\modules\v1\components\Controller;
use common\models\UserDetails;
use common\CommonFunction;
use yii\helpers\FileHelper;

/**
 * Company Controller API
 */
class ProfileController extends Controller {

    public $modelClass = 'common\models\User';

    public function actionTest() {
        echo "Profile APIs Working";
        exit;
    }

    public function actionGetProfile() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        try {
            $loggedInUserId = $this->user_id;
            $model = UserDetails::find()->where(['user_id' => $loggedInUserId])->one();
            if ($model !== null) {
                $model->email = $model->user->email;
                $code = 200;
                $msg = "Success!";
                $data = $model;
            } else {
                $code = 203;
                $msg = "No such user detail exists.";
            }
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

    public function actionUpdateProfile() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            $fileUploadingError = "";
            $isFileAttached = false;
            $model = UserDetails::find()->where(['user_id' => $loggedInUserId])->one();
            if ($model !== null) {
                $model->scenario = 'profile';
                $oldProfilePicName = $model->profile_pic;

                // IF PROFILE PICTURE WAS CHANGE/UPDATED 
                if (isset($_FILES['update_profile_pic']) && !empty($_FILES['update_profile_pic'])) {
                    // PREVENT FILE UPLOAD SIZE UPTO 2 MB AND TYPE MUST BE OF PNG, JPG
                    $isFileAttached = true;
                    $upoadingFile = $_FILES['update_profile_pic'];
                    $maxsize = 1024 * 1024 * 2; // UPTO MB
                    $acceptable = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (($upoadingFile['size'] >= $maxsize) || ($upoadingFile["size"] == 0)) {
                        $fileUploadingError = 'File is too large. File must be less than 2 MB.';
                    }
                    if ((!in_array($upoadingFile['type'], $acceptable)) && (!empty($upoadingFile["type"]))) {
                        $fileUploadingError = 'Invalid file type, only JPG, JPEG and PNG types are accepted.';
                    }
                    $path_parts = pathinfo($upoadingFile["name"]);
                    $extension = (isset($path_parts['extension'])) ? $path_parts['extension'] : "png";
                    $location = CommonFunction::getProfilePictureBasePath();
                    if (!file_exists($location)) {
                        FileHelper::createDirectory($location, 0777);
                    }

                    $fileName = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $extension;
                    if (!$fileUploadingError && move_uploaded_file($upoadingFile['tmp_name'], $location . "/" . $fileName)) {
                        $model->profile_pic = $fileName;
                        if ($oldProfilePicName && file_exists("$location/$oldProfilePicName")) {
                            unlink("$location/$oldProfilePicName");
                        }
                    }
                }

                if (!$fileUploadingError) {
                    if ($first_name != "" && $last_name != "" && $street_no && $street_address) {
                        $model->first_name = ($first_name != '') ? $first_name : null;
                        $model->last_name = ($last_name != '') ? $last_name : null;
                        $model->mobile_no = ($mobile_no != '') ? $mobile_no : null;
                        $model->looking_for = ($looking_for != '') ? $looking_for : null;
                        $model->apt = ($apt != '') ? $apt : null;
                        $model->street_no = ($street_no != '') ? $street_no : null;
                        $model->street_address = ($street_address != '') ? $street_address : null;
                        $model->city = ($city != '') ? $city : null;
                        $model->ssn = ($ssn != '') ? $ssn : null;
                        $model->dob = ($dob != '') ? date('Y-m-d', strtotime($dob)) : null;
                        $model->updated_at = CommonFunction::currentTimestamp();
                        if ($model->update(false)) {
                            $code = 200;
                            $msg = "Profile saved successfully.";
                        }
                    } else {
                        $code = 202;
                        $msg = "Required Data Missing in Request : first_name, last_name, street_no or street_name";
                    }
                } else {
                    $code = 203;
                    $msg = $fileUploadingError;
                }
            } else {
                $code = 203;
                $msg = "No such user detail exists.";
            }
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

}
