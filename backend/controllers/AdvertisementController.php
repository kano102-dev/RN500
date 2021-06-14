<?php

namespace backend\controllers;

use Yii;
use common\models\Advertisement;
use common\models\AdvertisementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\CommonFunction;
use yii\helpers\FileHelper;
use common\models\Vendor;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Response;
use common\models\Cities;

/**
 * AdvertisementController implements the CRUD actions for Advertisement model.
 */
class AdvertisementController extends Controller {

    public $title = "Advertisements";
    public $activeBreadcrumb, $breadcrumb;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'get-cities'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'get-cities'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('create-advertisement', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'update', 'get-cities'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('update-advertisement', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('view-advertisement', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('delete-advertisement', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->breadcrumb = [
            'Home' => Url::base(true),
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['advertisement/index']),
        ];
    }

    /**
     * Lists all Advertisement models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdvertisementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advertisement model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->activeBreadcrumb = "Detail View";
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Advertisement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->activeBreadcrumb = "Create";
        $model = new Advertisement();
        $post = Yii::$app->request->post();
        $vendor = ArrayHelper::map(Vendor::find()->asArray()->all(), 'id', 'company_name');

        $model->created_at = CommonFunction::currentTimestamp();
        $model->updated_at = CommonFunction::currentTimestamp();
        $model->created_by = \Yii::$app->user->id;
        if (isset($model->location) && !empty($model->location)) {
            $data = ArrayHelper::map(Cities::find()->where(['id' => $model->location])->all(), 'id', 'city');
        } else {
            $data = [];
        }
        if ($model->load(Yii::$app->request->post())) {


            $model->active_from = date('Y-m-d', strtotime($model->active_from));
            $model->active_to = date('Y-m-d', strtotime($model->active_to));

            $icon = UploadedFile::getInstance($model, 'icon');
            $folder = \Yii::getAlias('@frontend') . "/web/uploads/advertisement/";

            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            if (!empty($icon)) {
                $model->icon = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $icon->getExtension();
                $icon->saveAs($folder . $model->icon);
            } else {
                $model->icon = null;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash("success", "Advertisements created successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
                    'model' => $model,
                    'vendor' => $vendor, 'data' => $data,
        ]);
    }

    /**
     * Updates an existing Advertisement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $this->activeBreadcrumb = "Update";
        $model = $this->findModel($id);
        $vendor = ArrayHelper::map(Vendor::find()->asArray()->all(), 'id', 'company_name');

        $temp_document_file = isset($model->icon) && !empty($model->icon) ? $model->icon : NULL;

        $model->active_from = date("d-m-Y", strtotime($model->active_from));
        $model->active_to = date("d-m-Y", strtotime($model->active_to));

        $model->updated_at = CommonFunction::currentTimestamp();
        $model->updated_by = \Yii::$app->user->id;
        if (isset($model->location) && !empty($model->location)) {
            $data = ArrayHelper::map(Cities::find()->where(['id' => $model->location])->all(), 'id', 'city');
        } else {
            $data = [];
        }
        if ($model->load(Yii::$app->request->post())) {

            $model->active_from = date('Y-m-d', strtotime($model->active_from));
            $model->active_to = date('Y-m-d', strtotime($model->active_to));

            $document_file = UploadedFile::getInstance($model, 'icon');

            $folder = \Yii::getAlias('@frontend') . "/web/uploads/advertisement/";
            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }
            $document_upload_flag = false;
            $uploadPath = \Yii::getAlias('@frontend') . '/web/uploads/advertisement/';
            if (!empty($document_file)) {
                $model->icon = time() . "_" . Yii::$app->security->generateRandomString(10) . "." . $document_file->getExtension();
                $document_upload_flag = $document_file->saveAs($uploadPath . '/' . $model->icon);
            }
            if (isset($temp_document_file) && !empty($temp_document_file) && file_exists($folder . $temp_document_file)) {
                if ($document_upload_flag) {
                    unlink($uploadPath . $temp_document_file);
                } else {
                    $model->icon = $temp_document_file;
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash("success", "Advertisements updated successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('_form', [
                    'model' => $model,
                    'vendor' => $vendor, 'data' => $data
        ]);
    }

    /**
     * Deletes an existing Advertisement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetCities($page, $q = null, $id = null) {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'name' => '']];
        if (!is_null($q) && !empty($q)) {
            $query = new \yii\db\Query;
            $query->select(['cities.id', 'CONCAT(city,"-",cities.state_code) as text'])
                    ->from('cities')
                    ->innerJoin('states', 'states.id=cities.state_id')
                    ->where(['like', 'cities.city', $q])
                    ->offset($offset)
                    ->limit($limit);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            $out['pagination'] = ['more' => !empty($data) ? true : false];
        } elseif ($id > 0) {
            $query = new \yii\db\Query;
            $query->select(['cities.id', 'CONCAT(city,"-",cities.state_code) as name'])
                    ->from('cities')
                    ->innerJoin('states', 'states.id=cities.state_id')
                    ->where(['in', 'cities.id', $id])
                    ->offset($offset)
                    ->limit($limit);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            $out['pagination'] = ['more' => !empty($data) ? true : false];
        }
        return $out;
    }

    /**
     * Finds the Advertisement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advertisement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Advertisement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
