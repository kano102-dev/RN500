<?php

namespace frontend\controllers;

use Yii;
use common\models\UserDetails;
use common\models\UserDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\WorkExperience;
use yii\helpers\ArrayHelper;
use common\models\Speciality;
use common\models\Discipline;
use common\models\Education;
use common\models\Licenses;
use common\models\Certifications;
use common\models\Documents;
use common\models\References;
use common\models\JobPreference;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use common\models\CompanyBranch;
use common\models\CompanyMaster;
use common\CommonFunction;
use common\models\Cities;

/**
 * UserDetailsController implements the CRUD actions for UserDetails model.
 */
class UserDetailsController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        if ($action->id == 'get-profile-percentage') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all UserDetails models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserDetails model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new UserDetails();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->created_at = time();
            $model->updated_at = time();

            if ($model->validate()) {

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "User Details Updated successfully.");
                    return json_encode(['error' => 0, 'message' => 'User Details Updated successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('error', "User Details Updated failed.");
                return json_encode(['error' => 1, 'message' => 'something went wrong.', 'date' => $model->getErrors()]);
            }
        } else {
            
        }

        return $this->renderAjax('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {

        $postData = Yii::$app->request->post();
        $model = UserDetails::findOne(['user_id' => $id]);
        $model->scenario = 'profile';
        $model->updated_at = CommonFunction::currentTimestamp();
        if (isset($model->dob) && !empty($model->dob)) {
            $model->dob = date('M-d-Y', strtotime($model->dob));
        } else {
            $model->dob = date('d-m-Y');
        }
        if (isset($model->city) && !empty($model->city)) {
            $selectedLocations = ArrayHelper::map(Cities::find()->where(['id' => $model->city])->all(), 'id', 'city');
        } else {
            $selectedLocations = [];
        }
        $temp_document_file = isset($model->profile_pic) && !empty($model->profile_pic) ? $model->profile_pic : NULL;
        $document_upload_flag = '';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->city = isset($_POST['city']) && !empty($_POST['city']) ? $_POST['city'] : '';
            $model->dob = date('Y-m-d', strtotime($model->dob));

            $document_file = UploadedFile::getInstance($model, 'profile_pic');

            $folder = \Yii::$app->basePath . "/web/uploads/user-details/profile/";
            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            $uploadPath = './uploads/user-details/profile/';

            if ($document_file) {
                $model->profile_pic = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $document_file->getExtension();
                $document_upload_flag = $document_file->saveAs($uploadPath . '/' . $model->profile_pic);
            }

            if (isset($temp_document_file) && !empty($temp_document_file) && file_exists($folder . $temp_document_file)) {
                if ($document_upload_flag) {
                    unlink($uploadPath . $temp_document_file);
                } else {
                    $model->profile_pic = $temp_document_file;
                }
            }

            if ($model->validate()) {

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "User Details Updated successfully.");
                    return json_encode(['error' => 0, 'message' => 'User Details Updated successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('error', "User Details Updated failed.");
                return json_encode(['error' => 1, 'message' => 'something went wrong.', 'date' => $model->getErrors()]);
            }
        } else {
            
        }

        return $this->renderAjax('update', [
                    'model' => $model, 'selectedLocations' => $selectedLocations
        ]);
    }

    public function actionProfile($id) {
        $postData = Yii::$app->request->post();
        $model = UserDetails::findOne(['user_id' => $id]);

        $model->scenario = 'profile';
        $model->updated_at = CommonFunction::currentTimestamp();
        $temp_document_file = isset($model->profile_pic) && !empty($model->profile_pic) ? $model->profile_pic : NULL;
        $document_upload_flag = '';
        $branch = CompanyBranch::findOne(['id' => CommonFunction::getLoggedInUserBranchId()]);
        $companyDetail = CompanyMaster::findOne(['id' => CommonFunction::getLoggedInUserCompanyId()]);

        if (isset($model->dob) && !empty($model->dob)) {
            $model->dob = date('M-d-Y', strtotime($model->dob));
        }

        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        $city = ArrayHelper::map(Cities::findAll(['state_id' => $model->state]), 'id', 'city');
        if (isset($model->city) && !empty($model->city)) {
            $model->state = $model->cityRef->state_id;
            $states = ArrayHelper::map(\common\models\States::find()->where(['id' => $model->cityRef->state_id])->all(), 'id', 'state');
            $city = ArrayHelper::map(Cities::findAll(['state_id' => $model->cityRef->state_id]), 'id', 'city');
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->dob = date('Y-m-d', strtotime($model->dob));

            $document_file = UploadedFile::getInstance($model, 'profile_pic');

            $folder = \Yii::$app->basePath . "/web/uploads/user-details/profile/";
            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            $uploadPath = './uploads/user-details/profile/';

            if ($document_file) {
                $model->profile_pic = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $document_file->getExtension();
                $document_upload_flag = $document_file->saveAs($uploadPath . '/' . $model->profile_pic);
            }

            if (isset($temp_document_file) && !empty($temp_document_file) && file_exists($folder . $temp_document_file)) {
                if ($document_upload_flag) {
                    unlink($uploadPath . $temp_document_file);
                } else {
                    $model->profile_pic = $temp_document_file;
                }
            }

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "User Details Updated Successfully.");
                    return $this->redirect(['profile', 'id' => $id]);
                }
            } else {

                echo "<pre>";
                print_r($model->getErrors());
                exit;
                Yii::$app->session->setFlash('error', "User Details Updated failed.");
                return $this->redirect(['profile', 'id' => $id]);
            }
        }

        return $this->render('profile', [
                    'model' => $model,
                    'companyDetail' => $companyDetail,
                    'branch' => $branch, 'states' => $states, 'city' => $city
        ]);
    }

    public function actionGetCities($id) {
        $cities = ArrayHelper::map(Cities::find()->where(['state_id' => $id])->all(), 'id', 'city');
        $options = '';
        if (!empty($cities)) {
            foreach ($cities as $key => $city) {
                $options .= "<option value=$key>$city</option>";
            }
        }
        echo $options;
        exit;
    }

    /**
     * Deletes an existing UserDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

//    public function actionAddJobPrefernce() {
//        $id = \Yii::$app->request->get('id');
//        $postData = Yii::$app->request->post();
//
//        if ($id !== null) {
//            $model = JobPreference::findOne($id);
//        } else {
//            $model = new JobPreference();
//        }
//
//        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//
//            $model->location = $postData['location'];
//            $model->user_id = \Yii::$app->user->id;
//
//            if ($model->validate()) {
//                if ($model->save()) {
//                    Yii::$app->session->setFlash('success', "Job Prefernce Updated successfully.");
//                    return json_encode(['error' => 0, 'message' => 'Job Prefernce Updated successfully.']);
//                }
//            } else {
//                Yii::$app->session->setFlash('success', "Job Prefernce Updated failed.");
//                return json_encode(['error' => 0, 'message' => 'Work Experience Updated failed.', 'data' => $model->getErrors()]);
//            }
//        }
//
//        return $this->renderAjax('add-job-prefernce', [
//                    'model' => $model
//        ]);
//    }

    public function actionWorkExperience() {
        $postData = Yii::$app->request->post();
        $id = \Yii::$app->request->get('id');
        $message = '';
        if ($id !== null) {
            $model = WorkExperience::findOne($id);
            $message = 'Updated';
            $model->updated_at = CommonFunction::currentTimestamp();
            $model->start_date = date('m-Y', strtotime($model->start_date));

            if ($model->currently_working != '1') {
                $model->end_date = date('m-Y', strtotime($model->end_date));
            } else {
                $model->end_date = null;
            }
        } else {
            $model = new WorkExperience();
            $message = 'Created';
            $model->created_at = CommonFunction::currentTimestamp();
            $model->updated_at = CommonFunction::currentTimestamp();
        }
        if (isset($model->city) && !empty($model->city)) {
            $selectedLocations = ArrayHelper::map(Cities::find()->where(['id' => $model->city])->all(), 'id', 'city');
        } else {
            $selectedLocations = [];
        }
        $speciality = ArrayHelper::map(Speciality::find()->all(), 'id', 'name');
        $discipline = ArrayHelper::map(Discipline::find()->all(), 'id', 'name');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            $model->user_id = \Yii::$app->user->id;
            $model->start_date = date('Y-m-d', strtotime("01-" . $model->start_date));

            if ($model->currently_working != '1') {
                $model->end_date = date('Y-m-d', strtotime("01-" . $model->end_date));
            }

            $model->city = $postData['city'];

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Work Experience " . $message . " successfully.");
                    return json_encode(['error' => 0, 'message' => 'Work Experience ' . $message . ' successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('error', "Work Experience Updated failed.");
                return json_encode(['error' => 0, 'message' => 'Work Experience Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('work-experience', [
                    'model' => $model,
                    'discipline' => $discipline, 'selectedLocations' => $selectedLocations,
                    'speciality' => $speciality,
        ]);
    }

    public function actionAddEducation() {
        $postData = Yii::$app->request->post();
        $id = \Yii::$app->request->get('id');
        $message = '';

        if ($id !== null) {
            $model = Education::findOne($id);
            $message = 'Updated';
            $model->updated_at = CommonFunction::currentTimestamp();
            $model->year_complete = date('m-Y', strtotime($model->year_complete));
        } else {
            $model = new Education();
            $message = 'Created';
            $model->created_at = CommonFunction::currentTimestamp();
            $model->updated_at = CommonFunction::currentTimestamp();
        }

        if (isset($model->location) && !empty($model->location)) {
            $selectedLocations = ArrayHelper::map(Cities::find()->where(['id' => $model->location])->all(), 'id', 'city');
        } else {
            $selectedLocations = [];
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->year_complete = date('Y-m-d', strtotime("01-" . $model->year_complete));
            $model->location = $postData['location'];

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Education Details " . $message . " successfully.");
                    return json_encode(['error' => 0, 'message' => 'Education Details ' . $message . ' successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('error', "Education Details Updated failed.");
                return json_encode(['error' => 0, 'message' => 'Education Details Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('add-education', [
                    'model' => $model, 'selectedLocations' => $selectedLocations,
        ]);
    }

    public function actionAddLicence() {
        $postData = Yii::$app->request->post();
        $id = \Yii::$app->request->get('id');
        $deleteFlag = false;
        $document_upload_flag = '';
        $message = '';

        if ($id !== null) {
            $model = Licenses::findOne($id);
            $message = 'Updated';
            $model->updated_at = CommonFunction::currentTimestamp();
            $model->expiry_date = date('m-Y', strtotime($model->expiry_date));
            $temp_document_file = isset($model->document) && !empty($model->document) ? $model->document : NULL;
            $deleteFlag = true;
        } else {
            $model = new Licenses();
            $message = 'Create';
            $model->scenario = 'create';
            $model->created_at = CommonFunction::currentTimestamp();
            $model->updated_at = CommonFunction::currentTimestamp();
        }
        if (isset($model->issuing_state) && !empty($model->issuing_state)) {
            $selectedLocations = ArrayHelper::map(Cities::find()->where(['id' => $model->issuing_state])->all(), 'id', 'city');
        } else {
            $selectedLocations = [];
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->expiry_date = date('Y-m-d', strtotime("01-" . $model->expiry_date));
            $model->issuing_state = $postData['issuing_state'];
            $document_file = UploadedFile::getInstance($model, 'document');

            $folder = CommonFunction::getLicensesBasePath();
            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            $uploadPath = CommonFunction::getLicensesBasePath();

            if ($document_file) {
                $model->document = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $document_file->getExtension();
                $document_upload_flag = $document_file->saveAs($uploadPath . '/' . $model->document);
            }

            if (isset($temp_document_file) && !empty($temp_document_file) && file_exists($folder . $temp_document_file)) {
                if ($document_upload_flag) {
                    unlink($uploadPath . "/" . $temp_document_file);
                } else {
                    $model->document = $temp_document_file;
                }
            } else {
                if (!$document_upload_flag) {
                    $model->document = NULL;
                }
            }


            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "License Details " . $message . " successfully.");
                    return json_encode(['error' => 0, 'message' => 'License Details ' . $message . ' successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('error', "License Details Updated failed.");
                return json_encode(['error' => 0, 'message' => 'License Details Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('add-licence', [
                    'model' => $model, 'selectedLocations' => $selectedLocations,
                    'deleteFlag' => $deleteFlag
        ]);
    }

    public function actionAddCertification() {

        $id = \Yii::$app->request->get('id');
        $deleteFlag = false;
        $document_upload_flag = '';
        $message = '';

        if ($id !== null) {
            $model = Certifications::findOne($id);
            $message = 'Updated';
            $model->updated_at = CommonFunction::currentTimestamp();
            $model->expiry_date = date('m-Y', strtotime($model->expiry_date));
            $temp_document_file = isset($model->document) && !empty($model->document) ? $model->document : NULL;
            $deleteFlag = true;
        } else {
            $model = new Certifications();
            $message = 'Create';
            $model->scenario = 'create';
            $model->created_at = CommonFunction::currentTimestamp();
            $model->updated_at = CommonFunction::currentTimestamp();
        }

        if (isset($model->issuing_state) && !empty($model->issuing_state)) {
            $selectedLocations = ArrayHelper::map(Cities::find()->where(['id' => $model->issuing_state])->all(), 'id', 'city');
        } else {
            $selectedLocations = [];
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->expiry_date = date('Y-m-d', strtotime("01-" . $model->expiry_date));
            $model->issuing_state = $_POST['issuing_state'];

            $document_file = UploadedFile::getInstance($model, 'document');

            $folder = \Yii::$app->basePath . "/web/uploads/user-details/certification/";
            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            $uploadPath = \Yii::$app->basePath . "/web/uploads/user-details/certification/";

            if ($document_file) {
                $model->document = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $document_file->getExtension();
                $document_upload_flag = $document_file->saveAs($uploadPath . '/' . $model->document);
            }

            if (isset($temp_document_file) && !empty($temp_document_file) && file_exists($folder . $temp_document_file)) {
                if ($document_upload_flag) {
                    unlink($uploadPath . $temp_document_file);
                } else {
                    $model->document = $temp_document_file;
                }
            } else {
                if (!$document_upload_flag) {
                    $model->document = NULL;
                }
            }

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Certification Details " . $message . " successfully.");
                    return json_encode(['error' => 0, 'message' => 'Certification Details ' . $message . ' successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('error', "Certification Details Updated failed.");
                return json_encode(['error' => 0, 'message' => 'Certification Details Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('add-certification', [
                    'model' => $model,
                    'deleteFlag' => $deleteFlag, 'selectedLocations' => $selectedLocations
        ]);
    }

    public function actionAddDocument() {

        $id = \Yii::$app->request->get('id');
        $deleteFlag = false;
        $document_upload_flag = '';
        $message = '';

        if ($id !== null) {
            $model = Documents::findOne($id);
            $message = 'Updated';
            $model->updated_at = CommonFunction::currentTimestamp();
            $temp_document_file = isset($model->path) && !empty($model->path) ? $model->path : NULL;
            $deleteFlag = true;
        } else {
            $model = new Documents();
            $message = 'Create';
            $model->scenario = 'create';
            $model->created_at = CommonFunction::currentTimestamp();
            $model->updated_at = CommonFunction::currentTimestamp();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;

            $document_file = UploadedFile::getInstance($model, 'path');

            $folder = CommonFunction::getDocumentBasePath();
            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            $uploadPath = CommonFunction::getDocumentBasePath();

            if ($document_file) {
                $model->path = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $document_file->getExtension();
                $document_upload_flag = $document_file->saveAs($uploadPath . '/' . $model->path);
            }

            if (isset($temp_document_file) && !empty($temp_document_file) && file_exists($folder . "/" . $temp_document_file)) {
                if ($document_upload_flag) {
                    unlink($uploadPath . "/" . $temp_document_file);
                } else {
                    $model->path = $temp_document_file;
                }
            } else {
                if (!$document_upload_flag) {
                    $model->path = NULL;
                }
            }



            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Document " . $message . " successfully.");
                    return json_encode(['error' => 0, 'message' => 'Document ' . $message . ' successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('error', "Document Updated failed.");
                return json_encode(['error' => 0, 'message' => 'Document Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('add-document', [
                    'model' => $model,
                    'deleteFlag' => $deleteFlag
        ]);
    }

    public function actionAddReference() {

        $id = \Yii::$app->request->get('id');
        $message = '';
        if ($id !== null) {
            $model = References::findOne($id);
            $message = 'Updated';
            $model->updated_at = CommonFunction::currentTimestamp();
        } else {
            $model = new References();
            $message = 'Create';
            $model->created_at = CommonFunction::currentTimestamp();
            $model->updated_at = CommonFunction::currentTimestamp();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            $model->user_id = \Yii::$app->user->id;

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Reference Details " . $message . " successfully.");
                    return json_encode(['error' => 0, 'message' => 'Reference Details ' . $message . ' successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('error', "Reference Details Updated failed.");
                return json_encode(['error' => 0, 'message' => 'Reference Details Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('add-reference', [
                    'model' => $model
        ]);
    }

    public function actionDeleteDocument() {
        $id = \Yii::$app->request->get('id');
        $postData = \Yii::$app->request->post();
        $deleteFlag = false;
        $message = '';
        $uploadPath = '';
        $file = '';

        if ($postData['document'] == 'licenses') {
            $model = Licenses::findOne($id);
            $message = 'License';
            $uploadPath = './uploads/user-details/license/';
            $file = $model->document;
        } else if ($postData['document'] == 'certification') {
            $model = Certifications::findOne($id);
            $message = 'Certification';
            $uploadPath = './uploads/user-details/certification/';
            $file = $model->document;
        } else if ($postData['document'] == 'document') {
            $model = Documents::findOne($id);
            $message = 'Document';
            $uploadPath = './uploads/user-details/document/';
            $file = $model->path;
        }

        if (file_exists($uploadPath . $file)) {
            if (unlink($uploadPath . $file)) {
                if ($model->delete()) {
                    Yii::$app->session->setFlash('success', $message . " Deleted failed.");
                    $deleteFlag = true;
                }
            }
        }

        echo $deleteFlag;
    }

    public function actionGetProfilePercentage() {

        $totalPercentage = 100;

        $hasCompletedUserDetails = 0;
        $hasCompletedWE = 0;
        $hasCompletedEducation = 0;
        $hasCompletedLicense = 0;
        $hasCompletedCertification = 0;
        $hasCompletedDocuments = 0;
        $hasCompletedReference = 0;

        $userDetails = UserDetails::findOne(['user_id' => \Yii::$app->user->id]);
        $workExperience = WorkExperience::findOne(['user_id' => \Yii::$app->user->id]);
        $education = Education::findOne(['user_id' => \Yii::$app->user->id]);
        $license = Licenses::findOne(['user_id' => \Yii::$app->user->id]);
        $certification = Certifications::findOne(['user_id' => \Yii::$app->user->id]);
        $documents = Documents::findOne(['user_id' => \Yii::$app->user->id]);
        $reference = References::findOne(['user_id' => \Yii::$app->user->id]);

        if (isset($userDetails) && !empty($userDetails)) {
            $hasCompletedUserDetails = 14;
        }

        if (isset($workExperience) && !empty($workExperience)) {
            $hasCompletedWE = 14;
        }
        if (isset($education) && !empty($education)) {
            $hasCompletedEducation = 14;
        }
        if (isset($license) && !empty($license)) {
            $hasCompletedLicense = 14;
        }
        if (isset($certification) && !empty($certification)) {
            $hasCompletedCertification = 14;
        }
        if (isset($documents) && !empty($documents)) {
            $hasCompletedDocuments = 14;
        }
        if (isset($reference) && !empty($reference)) {
            $hasCompletedReference = 14;
        }

        if (isset($workExperience) && !empty($workExperience) && isset($userDetails) && !empty($userDetails) && isset($education) && !empty($education) && isset($license) && !empty($license) && isset($certification) && !empty($certification) && isset($documents) && !empty($documents) && isset($reference) && !empty($reference)) {
            $percentage = 100;
        } else {
            $percentage = ($hasCompletedUserDetails + $hasCompletedWE + $hasCompletedEducation + $hasCompletedLicense + $hasCompletedCertification + $hasCompletedDocuments + $hasCompletedReference) * $totalPercentage / 100;
        }
        echo round($percentage, 0);
    }

}
