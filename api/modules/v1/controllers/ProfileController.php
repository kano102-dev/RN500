<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Json;
use api\modules\v1\components\Controller;
use common\models\UserDetails;
use common\CommonFunction;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use common\models\WorkExperience;
use common\models\Education;
use common\models\Licenses;
use common\models\Certifications;
use common\models\Documents;
use common\models\References;

/**
 * Company Controller API
 */
class ProfileController extends Controller {

    public $modelClass = 'common\models\User';

    public function actionTest() {
        echo "Profile APIs Working";
        exit;
    }

    public function actionGetStaticData() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";

        try {
            $employment_type = [];
            foreach (Yii::$app->params['EMPLOYEMENT_TYPE'] as $value => $text) {
                $employment_type[] = ['value' => (string) $value, 'text' => $text];
            }

            $degree_type = [];
            foreach (Yii::$app->params['DEGREE_TYPE'] as $value => $text) {
                $degree_type[] = ['value' => (string) $value, 'text' => $text];
            }

            $licenses_type = [];
            foreach (Yii::$app->params['LICENSE_TYPE'] as $value => $text) {
                $licenses_type[] = ['value' => (string) $value, 'text' => $text];
            }

            $references_type = [];
            foreach (Yii::$app->params['REFERENCE_TYPE'] as $value => $text) {
                $references_type[] = ['value' => (string) $value, 'text' => $text];
            }

            $documents_type = [];
            foreach (Yii::$app->params['DOCUMENT_TYPE'] as $value => $text) {
                $documents_type[] = ['value' => (string) $value, 'text' => $text];
            }

            $certification_type = [];
            foreach (Yii::$app->params['CERTIFICATION_TYPE'] as $value => $text) {
                $certification_type[] = ['value' => (string) $value, 'text' => $text];
            }

            $certification_active_startus = [];
            foreach (Yii::$app->params['CERTIFICATION_ACTIVE_STATUS'] as $value => $text) {
                $certification_active_startus[] = ['value' => (string) $value, 'text' => $text];
            }

            $data['document_type'] = $documents_type;
            $data['employment_type'] = $employment_type;
            $data['licenses_type'] = $licenses_type;
            $data['certification_type'] = $certification_type;
            $data['references_type'] = $references_type;
            $data['degree_type'] = $degree_type;
            $data['certification_active_startus'] = $certification_active_startus;
            $code = 200;
            $msg = "success!!";
        } catch (\Exception $exc) {
            $code = 500;
            $msg = "Internal server error";
            $data = ['message' => $exc->getMessage(), 'line' => $exc->getLine(), 'file' => $exc->getFile()];
        }
        $response = Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
        echo $response;
        exit;
    }

    public function actionGetProfileMaster() {

        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        try {

            $loggedInUserId = $this->user_id;
            $model = UserDetails::find()->where(['user_id' => $loggedInUserId])->one();
            if ($model !== null) {

                $model->email = $model->user->email;
                $model->profile_pic_url = ($model->profile_pic && file_exists(CommonFunction::getProfilePictureBasePath() . "/" . $model->profile_pic)) ? Url::to(Yii::$app->urlManagerFrontend->createUrl(["/uploads/user-details/profile/$model->profile_pic"]), true) : "";

                // SELF DETAIL OF LOGGED-IN USER
                $aboutYou['user_id'] = (string) $model->user_id;
                $aboutYou['name'] = $model->first_name . " " . $model->last_name;
                $aboutYou['email'] = (isset($model->user->email) && $model->user->email != "") ? $model->user->email : "";
                $aboutYou['mobile_no'] = ($model->mobile_no) ? $model->mobile_no : "";
                $aboutYou['ssn'] = ($model->ssn) ? (string) $model->ssn : "";
                $aboutYou['profile_pic'] = ($model->profile_pic) ? $model->profile_pic : "";
                $aboutYou['profile_pic_url'] = ($model->profile_pic_url) ? $model->profile_pic_url : "";

                // WORK EXPERIENCES LIST OF LOGGED-IN USER
                $workExperiences = WorkExperience::find()->where(['user_id' => $loggedInUserId])->all();
                $workExperienceList = [];
                foreach ($workExperiences as $key => $record) {
                    $workExperienceList[] = [
                        'id' => $record->id,
                        'title' => ($record->title) ? $record->title : '',
                        'discipline' => (isset($record->discipline->name)) ? $record->discipline->name : '',
                    ];
                }

                // EDUCATION LIST OF LOGGED-IN USER
                $educations = Education::find()->where(['user_id' => $loggedInUserId])->all();
                $educationList = [];
                foreach ($educations as $key => $record) {
                    $educationList[] = [
                        'id' => $record->id,
                        'institution' => ($record->institution) ? $record->institution : '',
                        'degree_name' => (isset(Yii::$app->params['DEGREE_TYPE'][$record['degree_name']])) ? Yii::$app->params['DEGREE_TYPE'][$record['degree_name']] : '',
                    ];
                }


                // LICENSES LIST OF LOGGED-IN USER
                $licenses = Licenses::find()->where(['user_id' => $loggedInUserId])->all();
                $licenseList = [];
                foreach ($licenses as $key => $record) {
                    $licenseList[] = [
                        'id' => $record->id,
                        'license_number' => ($record->license_number) ? $record->license_number : '',
                        'license_type' => (isset(Yii::$app->params['LICENSE_TYPE'][$record['license_name']])) ? Yii::$app->params['LICENSE_TYPE'][$record['license_name']] : '',
                    ];
                }

                // CERTIFICATION LIST OF LOGGED-IN USER
                $certifications = Certifications::find()->where(['user_id' => $loggedInUserId])->all();
                $certificationList = [];
                foreach ($certifications as $key => $record) {
                    $certificationList[] = [
                        'id' => $record->id,
                        'certificat_type' => (isset(Yii::$app->params['CERTIFICATION_TYPE'][$record->certificate_name])) ? Yii::$app->params['CERTIFICATION_TYPE'][$record->certificate_name] : ''
                    ];
                }

                // DOCUMENTS LIST OF LOGGED-IN USER
                $documents = Documents::find()->where(['user_id' => $loggedInUserId])->all();
                $documentList = [];
                foreach ($documents as $key => $record) {
                    $documentList[] = [
                        'id' => $record->id,
                        'document_type' => (isset(Yii::$app->params['DOCUMENT_TYPE'][$record->document_type])) ? Yii::$app->params['DOCUMENT_TYPE'][$record->document_type] : '',
                        'doc_name' => $record->path,
                        'url' => (isset($record->path) && file_exists(CommonFunction::getDocumentBasePath() . "/" . $record->path)) ? Url::to(Yii::$app->urlManagerFrontend->createUrl(["/uploads/user-details/document/$record->path"]), true) : '',
                    ];
                }


                // REFERENCE LIST OF LOGGED-IN USER
                $references = References::find()->where(['user_id' => $loggedInUserId])->all();
                $referenceList = [];
                foreach ($references as $key => $record) {
                    $referenceList[] = [
                        'id' => $record->id,
                        'name' => $record->first_name . " " . $record->last_name,
                        'email' => $record->email,
                    ];
                }

                $data['about_you'] = $aboutYou;
                $data['work_experiences'] = $workExperienceList;
                $data['educations'] = $educationList;
                $data['licenses'] = $licenseList;
                $data['certifications'] = $certificationList;
                $data['documents'] = $documentList;
                $data['references'] = $referenceList;
                $code = 200;
                $msg = "success!";
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
                $model->profile_pic_url = ($model->profile_pic && file_exists(CommonFunction::getProfilePictureBasePath() . "/" . $model->profile_pic)) ? Url::to(Yii::$app->urlManagerFrontend->createUrl(["/uploads/user-details/profile/$model->profile_pic"]), true) : "";

                $data['first_name'] = $model->first_name;
                $data['last_name'] = $model->last_name;
                $data['email'] = (isset($model->user->email) && $model->user->email != "") ? $model->user->email : "";
                $data['mobile_no'] = ($model->mobile_no) ? $model->mobile_no : "";
                $data['looking_for'] = ($model->looking_for) ? $model->looking_for : "";
                $data['apt'] = ($model->apt) ? $model->apt : "";
                $data['street_no'] = ($model->street_no) ? $model->street_no : "";
                $data['street_address'] = ($model->street_address) ? $model->street_address : "";
                $data['city'] = ($model->city) ? (string) $model->city : "";
                $data['city_name'] = $model->getCityStateName();
                $data['ssn'] = ($model->ssn) ? (string) $model->ssn : "";
                $data['dob'] = ($model->dob) ? $model->dob : "";
                $data['profile_pic'] = ($model->profile_pic) ? $model->profile_pic : "";
                $data['profile_pic_url'] = ($model->profile_pic_url) ? $model->profile_pic_url : "";
                $code = 200;
                $msg = "success!";
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
        $request = array_map("trim", Yii::$app->request->post());
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
                if (isset($_FILES['update_profile_pic']['name']) && !empty($_FILES['update_profile_pic']['name'])) {
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
                            $data = ['token' => $this->token, 'first_name' => $model->first_name, 'last_name' => $model->last_name, 'email' => $this->email, 'profile_image' => !empty($model->profile_pic) ? $model->profile_pic : ''];
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

    /*

      public function actionWorkExperienceList() {
      $data = [];
      $code = 202;
      $msg = "Required Data Missing in Request.";
      $request = Yii::$app->request->post();
      extract($request);
      try {
      $loggedInUserId = $this->user_id;
      $models = WorkExperience::find()->where(['user_id' => $loggedInUserId])->all();

      if (!empty($models)) {
      $result = [];
      foreach ($models as $record) {
      $result[] = [
      'id' => $record->id,
      'title' => $record->title,
      'start_date' => ($record->start_date) ? $record->start_date : '',
      'end_date' => ($record->end_date) ? $record->end_date : '',
      'discipline_id' => ($record->discipline_id) ? (string) $record->discipline_id : '',
      'discipline_name' => (isset($record->discipline->name)) ? $record->discipline->name : '',
      'specialty' => ($record->specialty) ? (string) $record->specialty : '',
      'specialty_name' => (isset($record->specialityRel->name)) ? $record->specialityRel->name : '',
      'employment_type' => ($record->employment_type) ? (string) $record->employment_type : '',
      'employment_type_name' => (isset(Yii::$app->params['EMPLOYEMENT_TYPE'][$record->employment_type])) ? Yii::$app->params['EMPLOYEMENT_TYPE'][$record->employment_type] : '',
      'currently_working' => ($record->currently_working == 1) ? "1" : "0",
      'facility_name' => ($record->facility_name) ? $record->facility_name : '',
      'city' => ($record->city) ? (string) $record->city : '',
      'city_name' => (isset($record->cityRel->city)) ? $record->cityRel->city : '',
      ];
      }
      $code = 200;
      $msg = "success!!";
      $data = $result;
      } else {
      $code = 201;
      $msg = "None of work experience is added.";
      $data = [];
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
     *
     */

    /*
     * WORK EXPERIENCES APIs START
     */

    public function actionWorkExperienceDetail() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = WorkExperience::find()->alias("we")->select("we.*")->where(['we.id' => $id, 'we.user_id' => $loggedInUserId])->one();
                if ($model !== null) {
//                    $data = array_map('strval', $model);
                    $data = array_map('strval', $model->getAttributes());
                    $data['start_date'] = ($model->start_date != '') ? date("Y-m", strtotime($model->start_date)) : '';
                    $data['end_date'] = ($model->end_date != '') ? date("Y-m", strtotime($model->end_date)) : '';
                    $data['discipline_name'] = (isset($model->discipline->name)) ? $model->discipline->name : '';
                    $data['specialty_name'] = (isset($model->specialityRel->name)) ? $model->specialityRel->name : '';
                    $data['employment_type_name'] = $model->getEmploymentTypeName();
                    $data['city_name'] = ($model->city != '') ? $model->getCityStateName() : '';

                    $code = 200;
                    $msg = "success!!";
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    public function actionWorkExperienceSubmit() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            $model = new WorkExperience();
            $model->user_id = $loggedInUserId;
            if (isset($id) && $id != '') {
                $model = WorkExperience::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model == null) {
                    $code = 204;
                    $msg = "No record exists with such id.";
                    echo Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
                    exit;
                }
            }
            if (isset($discipline_id) && $discipline_id != '' && isset($specialty) && $specialty != '' && isset($employment_type) && $employment_type != '' && isset($start_date) && $start_date != '' && isset($end_date)) {
                $model->setAttributes($request);
                $model->start_date = date('Y-m-d', strtotime($start_date));
                $model->end_date = (isset($currently_working) && $currently_working == "1" ) ? null : ($end_date) ? date('Y-m-d', strtotime($end_date)) : null;
                if ($model->save()) {
                    $code = 200;
                    $msg = "Record saved successfully.";
                } else {
                    $code = 205;
                    $msg = "Something went wrong.";
                }
            } else {
                $code = 201;
                $msg = "Missing parameters : discipline_id, specialty, employment_type, start_date or end_date ";
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

    public function actionWorkExperienceDelete() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = WorkExperience::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    if ($model->delete()) {
                        $code = 200;
                        $msg = "Record was deleted successfully.";
                    } else {
                        $code = 205;
                        $msg = "something went wrong.";
                    }
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    /*
     * EDUCATIONS APIs START
     */

    public function actionEducationDetail() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = Education::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    $data = array_map('strval', $model->getAttributes());
                    $data['year_complete'] = ($model['year_complete'] != '') ? date("Y-m", strtotime($model['year_complete'])) : '';
                    $data['degree_complete_name'] = $model->getDegreeTypeName();
                    $data['location_name'] = $model->getCityStateName();

                    $code = 200;
                    $msg = "success!!";
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    public function actionEducationSubmit() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            $model = new Education();
            $model->user_id = $loggedInUserId;
            if (isset($id) && $id != '') {
                $model = Education::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model == null) {
                    $code = 204;
                    $msg = "No record exists with such id.";
                    echo Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
                    exit;
                }
            }
            if (isset($institution) && $institution != '' && isset($year_complete) && $year_complete != '' && isset($degree_name) && $degree_name != '') {
                $model->setAttributes($request);
                if ($model->save()) {
                    $code = 200;
                    $msg = "Record saved successfully.";
                } else {
                    $code = 205;
                    $msg = "Something went wrong.";
                }
            } else {
                $code = 201;
                $msg = "Missing parameters : institution, year_complete, degree_name.";
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

    public function actionEducationDelete() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = Education::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    if ($model->delete()) {
                        $code = 200;
                        $msg = "Record was deleted successfully.";
                    } else {
                        $code = 205;
                        $msg = "something went wrong.";
                    }
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    /*
     * LICENSES APIs START
     */

    public function actionLicensesDetail() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = Licenses::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    $data = array_map('strval', $model->getAttributes());
                    $data['expiry_date'] = ($model->expiry_date != '') ? date("Y-m", strtotime($model['expiry_date'])) : '';

                    $data['license_name_text'] = (isset(Yii::$app->params['LICENSE_TYPE'][$model->license_name])) ? Yii::$app->params['LICENSE_TYPE'][$model->license_name] : '';
                    $data['issuing_state_name'] = $model->getCityStateName();

                    if ($model['document'] != '' && file_exists(CommonFunction::getLicensesBasePath() . "/" . $model['document'])) {
                        $data['document_url'] = Url::to(Yii::$app->urlManagerFrontend->createUrl(["/uploads/user-details/license/" . $model['document']]), true);
                    } else {
                        $data['document_url'] = $data['document'] = "";
                    }
                    $code = 200;
                    $msg = "success!!";
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    public function actionLicensesSubmit() {

        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        extract($request);
        try {
            $oldDocument = '';
            $location = CommonFunction::getLicensesBasePath();
            $loggedInUserId = $this->user_id;
            $fileUploadingError = "";
            $isFileAttached = false;
            $model = new Licenses();
            $model->user_id = $loggedInUserId;
            if (isset($id) && $id != '') {
                $model = Licenses::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model == null) {
                    $code = 204;
                    $msg = "No record exists with such id.";
                    echo Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
                    exit;
                } else {
                    $oldDocument = $model->document;
                }
            }

            // IF DOCUMENT WAS UPLOADED
            if (isset($_FILES['document_file']['name']) && !empty($_FILES['document_file']['name'])) {

                // PREVENT FILE UPLOAD SIZE UPTO 2 MB AND TYPE MUST BE OF PNG, JPG
                $isFileAttached = true;
                $upoadingFile = $_FILES['document_file'];
                $maxsize = 1024 * 1024 * 2; // 2 UPTO MB
                $acceptable = ['image/jpeg', 'image/jpg', 'image/png'];
                if (($upoadingFile['size'] >= $maxsize) || ($upoadingFile["size"] == 0)) {
                    $fileUploadingError = 'File is too large. File must be less than 2 MB.';
                }
                if ((!in_array($upoadingFile['type'], $acceptable)) && (!empty($upoadingFile["type"]))) {
                    $fileUploadingError = 'Invalid file type, only JPG, JPEG and PNG types are accepted.';
                }
                $path_parts = pathinfo($upoadingFile["name"]);
                $extension = (isset($path_parts['extension'])) ? $path_parts['extension'] : "png";

                if (!file_exists($location)) {
                    FileHelper::createDirectory($location, 0777);
                }

                $fileName = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $extension;
                if (!$fileUploadingError && move_uploaded_file($upoadingFile['tmp_name'], $location . "/" . $fileName)) {
                    $model->document = $fileName;
                }
            }

            if (!$fileUploadingError) {
                if (isset($license_name) && $license_name != "" && isset($expiry_date) && $expiry_date != '' && isset($issue_by) && $issue_by != '') {
                    $model->license_name = $license_name;
                    $model->issue_by = $issue_by;
                    $model->expiry_date = date('Y-m-d', strtotime($expiry_date));
                    $model->verified = 0;
                    $model->compact_states = (isset($compact_states) && $compact_states != '') ? $compact_states : 0;
                    $model->license_number = (isset($license_number) && $license_number != '') ? $license_number : null;
                    $model->issuing_state = (isset($issuing_state) && $issuing_state != '') ? $issuing_state : 0;
                    if ($model->save(false)) {
                        ($oldDocument != '') ? $this->deleteFile("$location/$oldDocument") : '';
                        $code = 200;
                        $msg = "Record saved successully.";
                    }
                } else {
                    $code = 202;
                    $msg = "Required Data Missing in Request : license_name, expiry_date or issue_by . ";
                }
            } else {
                $code = 203;
                $msg = $fileUploadingError;
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

    public function actionLicensesDelete() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = Licenses::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    if ($this->deleteFile(CommonFunction::getLicensesBasePath() . "/" . $model->document) && $model->delete()) {
                        $code = 200;
                        $msg = "Record was deleted successfully.";
                    } else {
                        $code = 205;
                        $msg = "something went wrong.";
                    }
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    /*
     * REFERENCES APIs START
     */

    public function actionReferenceDetail() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = References::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    $data = array_map('strval', $model->getAttributes());
                    $data['title_name'] = (isset(Yii::$app->params['REFERENCE_TYPE'][$model->title])) ? Yii::$app->params['REFERENCE_TYPE'][$model->title] : '';
                    $code = 200;
                    $msg = "success!!";
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    public function actionReferenceSubmit() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            $model = new References();
            $model->user_id = $loggedInUserId;
            if (isset($id) && $id != '') {
                $model = References::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model == null) {
                    $code = 204;
                    $msg = "No record exists with such id.";
                    echo Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
                    exit;
                }
            }
            if (isset($first_name) && $first_name != '' && isset($title) && $title != '' && isset($last_name) && $last_name != '' && isset($mobile_no) && $mobile_no != '' && isset($email) && $email != '' && isset($relation) && $relation != '') {
                $model->setAttributes($request);
                if ($model->save(false)) {
                    $code = 200;
                    $msg = "Record saved successfully.";
                } else {
                    $code = 205;
                    $msg = "Something went wrong.";
                }
            } else {
                $code = 201;
                $msg = "Missing parameters : first_name, last_name, mobile_no, email, relation or title.";
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

    public function actionReferenceDelete() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = References::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    if ($model->delete()) {
                        $code = 200;
                        $msg = "Record was deleted successfully.";
                    } else {
                        $code = 205;
                        $msg = "something went wrong.";
                    }
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    /*
     * DOCUMENT APIs START
     */

    public function actionDocumentAdd() {

        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        extract($request);
        try {
            $location = CommonFunction::getDocumentBasePath();
            $loggedInUserId = $this->user_id;
            $fileUploadingError = "";
            $model = new Documents();
            $model->user_id = $loggedInUserId;

            // IF DOCUMENT WAS UPLOADED
            if (isset($_FILES['document_file']['name']) && !empty($_FILES['document_file']['name'])) {

                // PREVENT FILE UPLOAD SIZE UPTO 2 MB AND TYPE MUST BE OF PNG, JPG
                $upoadingFile = $_FILES['document_file'];
                $maxsize = 1024 * 1024 * 2; // 2 UPTO MB
//                $acceptable = ['image/jpeg', 'image/jpg', 'image/png'];
                if (($upoadingFile['size'] >= $maxsize) || ($upoadingFile["size"] == 0)) {
                    $fileUploadingError = 'File is too large. File must be less than 2 MB.';
                }
//                if ((!in_array($upoadingFile['type'], $acceptable)) && (!empty($upoadingFile["type"]))) {
//                    $fileUploadingError = 'Invalid file type, only JPG, JPEG and PNG types are accepted.';
//                }
                $path_parts = pathinfo($upoadingFile["name"]);
                $extension = (isset($path_parts['extension'])) ? $path_parts['extension'] : "png";

                if (!file_exists($location)) {
                    FileHelper::createDirectory($location, 0777);
                }

                $fileName = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $extension;
                if (!$fileUploadingError && move_uploaded_file($upoadingFile['tmp_name'], $location . "/" . $fileName)) {
                    $model->path = $fileName;
                    $model->document_type = (isset($document_type) && $document_type) ? $document_type : '0';
                    if ($model->save(false)) {
                        $code = 200;
                        $msg = "Record saved successully.";
                    }
                } else {
                    $code = 203;
                    $msg = $fileUploadingError;
                }
            } else {
                $code = 202;
                $msg = "Required Data Missing in Request : document_type or document_file. ";
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

    public function actionDocumentDelete() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = Documents::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    if ($this->deleteFile(CommonFunction::getDocumentBasePath() . "/" . $model->path) && $model->delete()) {
                        $code = 200;
                        $msg = "Record was deleted successfully.";
                    } else {
                        $code = 205;
                        $msg = "something went wrong.";
                    }
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    /*
     * CERTIFICATION APIs START
     */

    public function actionCertificationDetail() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = Certifications::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    $data = array_map('strval', $model->getAttributes());
                    $data['certificate_name_text'] = (isset(Yii::$app->params['CERTIFICATION_TYPE'][$model->certificate_name])) ? Yii::$app->params['CERTIFICATION_TYPE'][$model->certificate_name] : '';
                    $data['issuing_state_name'] = $model->getCityStateName();
                    $data['expiry_date'] = ($model->expiry_date && $model->expiry_date != '1970-01-01' && $model->expiry_date != '0000-00-00') ? date('Y-m', strtotime($model->expiry_date)) : '';
                    $data['certification_active_status'] = (isset(Yii::$app->params['CERTIFICATION_ACTIVE_STATUS'][$model->certification_active])) ? Yii::$app->params['CERTIFICATION_ACTIVE_STATUS'][$model->certification_active] : '';
                    if ($model->document != '' && file_exists(CommonFunction::getCertificateBasePath() . "/" . $model->document)) {
                        $data['document_url'] = Url::to(Yii::$app->urlManagerFrontend->createUrl(["/uploads/user-details/certification/" . $model->document]), true);
                    } else {
                        $data['document_url'] = $data['document'] = "";
                    }
                    $code = 200;
                    $msg = "success!!";
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    public function actionCertificationSubmit() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = array_map("trim", Yii::$app->request->post());
        extract($request);
        try {
            $oldDocument = '';
            $location = CommonFunction::getCertificateBasePath();
            $loggedInUserId = $this->user_id;
            $fileUploadingError = "";
            $isFileAttached = false;
            $model = new Certifications();
            $model->user_id = $loggedInUserId;
            if (isset($id) && $id != '') {
                $model = Certifications::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model == null) {
                    $code = 204;
                    $msg = "No record exists with such id.";
                    echo Json::encode(['code' => $code, 'msg' => $msg, "data" => $data]);
                    exit;
                } else {
                    $oldDocument = $model->document;
                }
            }

            // IF DOCUMENT WAS UPLOADED
            if (isset($_FILES['document_file']['name']) && !empty($_FILES['document_file']['name'])) {

                // PREVENT FILE UPLOAD SIZE UPTO 2 MB AND TYPE MUST BE OF PNG, JPG
                $isFileAttached = true;
                $upoadingFile = $_FILES['document_file'];
                $maxsize = 1024 * 1024 * 2; // 2 UPTO MB
//                $acceptable = ['image/jpeg', 'image/jpg', 'image/png'];
                if (($upoadingFile['size'] >= $maxsize) || ($upoadingFile["size"] == 0)) {
                    $fileUploadingError = 'File is too large. File must be less than 2 MB.';
                }
//                if ((!in_array($upoadingFile['type'], $acceptable)) && (!empty($upoadingFile["type"]))) {
//                    $fileUploadingError = 'Invalid file type, only JPG, JPEG and PNG types are accepted.';
//                }
                $path_parts = pathinfo($upoadingFile["name"]);
                $extension = (isset($path_parts['extension'])) ? $path_parts['extension'] : "png";

                if (!file_exists($location)) {
                    FileHelper::createDirectory($location, 0777);
                }

                $fileName = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $extension;
                if (!$fileUploadingError && move_uploaded_file($upoadingFile['tmp_name'], $location . "/" . $fileName)) {
                    $model->document = $fileName;
                }
            }

            if (!$fileUploadingError) {
                if (isset($certificate_name) && $certificate_name != '' && isset($issue_by) && $issue_by != '') {
//                $model->setAttributes($request);
                    $certification_active = isset($certification_active) ? $certification_active : "2";
                    $expiry_date = isset($expiry_date) ? $expiry_date : "";
                    $issuing_state = isset($issuing_state) ? $issuing_state : "";
                    $issue_by = isset($issue_by) ? $issue_by : "";

                    $model->certificate_name = $certificate_name;
                    $model->certification_active = $certification_active;
                    $model->expiry_date = ($certification_active == '1' && $expiry_date) ? date('Y-m', strtotime($expiry_date)) : '';
                    $model->issuing_state = $issuing_state;
                    $model->issue_by = $issue_by;
                    if ($model->save(false)) {
                        ($oldDocument != '') ? $this->deleteFile("$location/$oldDocument") : '';
                        $code = 200;
                        $msg = "Record saved successfully.";
                    } else {
                        $code = 205;
                        $msg = "Something went wrong.";
                    }
                } else {
                    $code = 201;
                    $msg = "Missing parameters : certificate_name, issue_by .";
                }
            } else {
                $code = 203;
                $msg = $fileUploadingError;
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

    public function actionCertificationDelete() {
        $data = [];
        $code = 202;
        $msg = "Required Data Missing in Request.";
        $request = Yii::$app->request->post();
        extract($request);
        try {
            $loggedInUserId = $this->user_id;
            if (isset($id) && $id != '') {
                $model = Certifications::find()->where(['id' => $id, 'user_id' => $loggedInUserId])->one();
                if ($model !== null) {
                    $documentName = $model->document;
                    if ($model->delete()) {
                        ($documentName) ? $this->deleteFile(CommonFunction::getCertificateBasePath() . "/" . $documentName) : '';
                        $code = 200;
                        $msg = "Record was deleted successfully.";
                    } else {
                        $code = 205;
                        $msg = "something went wrong.";
                    }
                } else {
                    $code = 204;
                    $msg = "No record exists.";
                }
            } else {
                $code = 204;
                $msg = "Missing parameter : id";
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

    public function deleteFile($absPathWithFilename) {
        $flag = true;
        try {
            if (file_exists($absPathWithFilename)) {
                $flag = FileHelper::unlink($absPathWithFilename);
            }
        } catch (\Exception $ex) {
            $flag = true;
        } finally {
            return $flag;
        }
    }

}
