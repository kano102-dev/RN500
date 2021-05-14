<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UserDetails;
use frontend\models\UserDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\WorkExperience;
use yii\helpers\ArrayHelper;
use common\models\Speciality;
use common\models\Discipline;
use frontend\models\Education;
use frontend\models\Licenses;
use frontend\models\Certifications;
use frontend\models\Documents;
use frontend\models\References;
use frontend\models\JobPreference;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

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
        $model = UserDetails::findOne(['user_id' => $id]);
        $model->updated_at = time();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
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
                    'model' => $model,
        ]);
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

    public function actionAddJobPrefernce() {
        $id = \Yii::$app->request->get('id');

        if ($id !== null) {
            $model = JobPreference::findOne($id);
        } else {
            $model = new JobPreference();
        }
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            $model->user_id = \Yii::$app->user->id;

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Job Prefernce Updated successfully.");
                    return json_encode(['error' => 0, 'message' => 'Job Prefernce Updated successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('success', "Job Prefernce Updated failed.");
                return json_encode(['error' => 0, 'message' => 'Work Experience Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('add-job-prefernce', [
                    'model' => $model
        ]);
    }

    public function actionWorkExperience() {

        $id = \Yii::$app->request->get('id');

        if ($id !== null) {
            $model = WorkExperience::findOne($id);

            $model->start_date = date('m-Y', strtotime($model->start_date));
            $model->end_date = date('m-Y', strtotime($model->end_date));
        } else {
            $model = new WorkExperience();
        }

        $speciality = ArrayHelper::map(Speciality::find()->all(), 'id', 'name');
        $discipline = ArrayHelper::map(Discipline::find()->all(), 'id', 'name');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            $model->user_id = \Yii::$app->user->id;
            $model->start_date = date('Y-m-d', strtotime("01-" . $model->start_date));
            $model->end_date = date('Y-m-d', strtotime("01-" . $model->end_date));

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Work Experience Updated successfully.");
                    return json_encode(['error' => 0, 'message' => 'Work Experience Updated successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('success', "Work Experience Updated failed.");
                return json_encode(['error' => 0, 'message' => 'Work Experience Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('work-experience', [
                    'model' => $model,
                    'discipline' => $discipline,
                    'speciality' => $speciality,
        ]);
    }

    public function actionAddEducation() {

        $id = \Yii::$app->request->get('id');

        if ($id !== null) {
            $model = Education::findOne($id);
            $model->year_complete = date('m-Y', strtotime($model->year_complete));
        } else {
            $model = new Education();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->year_complete = date('Y-m-d', strtotime("01-" . $model->year_complete));

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Education Details Updated successfully.");
                    return json_encode(['error' => 0, 'message' => 'Education Details Updated successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('success', "Education Details Updated failed.");
                return json_encode(['error' => 0, 'message' => 'Education Details Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('add-education', [
                    'model' => $model
        ]);
    }

    public function actionAddLicence() {
        $id = \Yii::$app->request->get('id');
        $deleteFlag = false;
        $document_upload_flag = '';

        if ($id !== null) {
            $model = Licenses::findOne($id);
            $model->expiry_date = date('m-Y', strtotime($model->expiry_date));
            $temp_document_file = isset($model->document) && !empty($model->document) ? $model->document : NULL;
            $deleteFlag = true;
        } else {
            $model = new Licenses();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->expiry_date = date('Y-m-d', strtotime("01-" . $model->expiry_date));

            $document_file = UploadedFile::getInstance($model, 'document');

            $folder = \Yii::$app->basePath . "/web/uploads/user-details/license/";
            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            $uploadPath = './uploads/user-details/license/';

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
                    Yii::$app->session->setFlash('success', "License Details Updated successfully.");
                    return json_encode(['error' => 0, 'message' => 'License Details Updated successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('success', "License Details Updated failed.");
                return json_encode(['error' => 0, 'message' => 'License Details Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('add-licence', [
                    'model' => $model,
                    'deleteFlag' => $deleteFlag
        ]);
    }

    public function actionAddCertification() {

        $id = \Yii::$app->request->get('id');
        $deleteFlag = false;
        $document_upload_flag = '';

        if ($id !== null) {
            $model = Certifications::findOne($id);
            $model->expiry_date = date('m-Y', strtotime($model->expiry_date));
            $temp_document_file = isset($model->document) && !empty($model->document) ? $model->document : NULL;
            $deleteFlag = true;
        } else {
            $model = new Certifications();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->expiry_date = date('Y-m-d', strtotime("01-" . $model->expiry_date));

            $document_file = UploadedFile::getInstance($model, 'document');

            $folder = \Yii::$app->basePath . "/web/uploads/user-details/certification/";
            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            $uploadPath = './uploads/user-details/certification/';

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
                    Yii::$app->session->setFlash('success', "Certification Details Updated successfully.");
                    return json_encode(['error' => 0, 'message' => 'Certification Details Updated successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('success', "Certification Details Updated failed.");
                return json_encode(['error' => 0, 'message' => 'Certification Details Updated failed.', 'data' => $model->getErrors()]);
            }
        }

        return $this->renderAjax('add-certification', [
                    'model' => $model,
                    'deleteFlag' => $deleteFlag
        ]);
    }

    public function actionAddDocument() {

        $id = \Yii::$app->request->get('id');
        $deleteFlag = false;
        $document_upload_flag = '';

        if ($id !== null) {
            $model = Documents::findOne($id);
            $temp_document_file = isset($model->path) && !empty($model->path) ? $model->path : NULL;
            $deleteFlag = true;
        } else {
            $model = new Documents();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;

            $document_file = UploadedFile::getInstance($model, 'path');

            $folder = \Yii::$app->basePath . "/web/uploads/user-details/document/";
            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            $uploadPath = './uploads/user-details/document/';

            if ($document_file) {
                $model->path = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $document_file->getExtension();
                $document_upload_flag = $document_file->saveAs($uploadPath . '/' . $model->path);
            }

            if (isset($temp_document_file) && !empty($temp_document_file) && file_exists($folder . $temp_document_file)) {
                if ($document_upload_flag) {
                    unlink($uploadPath . $temp_document_file);
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
                    Yii::$app->session->setFlash('success', "Document Updated successfully.");
                    return json_encode(['error' => 0, 'message' => 'Document Updated successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('success', "Document Updated failed.");
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

        if ($id !== null) {
            $model = References::findOne($id);
        } else {
            $model = new References();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Reference Details Updated successfully.");
                    return json_encode(['error' => 0, 'message' => 'Reference Details Updated successfully.']);
                }
            } else {
                Yii::$app->session->setFlash('success', "Reference Details Updated failed.");
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

        if (unlink($uploadPath . $file)) {
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', $message . " Updated failed.");
                $deleteFlag = true;
            }
        }

        echo $deleteFlag;
    }

    public function actionGetProfilePercentage() {

        $totalPercentage = 100;

        $hasCompletedUserDetails = 0;
        $hasCompletedJobPrefernce = 0;
        $hasCompletedWE = 0;
        $hasCompletedEducation = 0;
        $hasCompletedLicense = 0;
        $hasCompletedCertification = 0;
        $hasCompletedDocuments = 0;
        $hasCompletedReference = 0;

        $userDetails = UserDetails::findOne(['user_id' => \Yii::$app->user->id]);
        $workExperience = WorkExperience::findOne(['user_id' => \Yii::$app->user->id]);
        $jobPreference = JobPreference::findOne(['user_id' => \Yii::$app->user->id]);
        $education = Education::findOne(['user_id' => \Yii::$app->user->id]);
        $license = Licenses::findOne(['user_id' => \Yii::$app->user->id]);
        $certification = Certifications::findOne(['user_id' => \Yii::$app->user->id]);
        $documents = Documents::findOne(['user_id' => \Yii::$app->user->id]);
        $reference = References::findOne(['user_id' => \Yii::$app->user->id]);

        if (isset($userDetails) && !empty($userDetails)) {
            $hasCompletedUserDetails = 12.5;
        }
        if (isset($jobPreference) && !empty($jobPreference)) {
            $hasCompletedJobPrefernce = 12.5;
        }
        if (isset($workExperience) && !empty($workExperience)) {
            $hasCompletedWE = 12.5;
        }
        if (isset($education) && !empty($education)) {
            $hasCompletedEducation = 12.5;
        }
        if (isset($license) && !empty($license)) {
            $hasCompletedLicense = 12.5;
        }
        if (isset($certification) && !empty($certification)) {
            $hasCompletedCertification = 12.5;
        }
        if (isset($documents) && !empty($documents)) {
            $hasCompletedDocuments = 12.5;
        }
        if (isset($reference) && !empty($reference)) {
            $hasCompletedReference = 12.5;
        }

        $percentage = ($hasCompletedUserDetails + $hasCompletedJobPrefernce + $hasCompletedWE + $hasCompletedEducation + $hasCompletedLicense + $hasCompletedCertification + $hasCompletedDocuments + $hasCompletedReference) * $totalPercentage / 100;

        echo $percentage;
    }

}
