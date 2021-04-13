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
            $this->title => Yii::$app->urlManager->createAbsoluteUrl(['advertisements/']),
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
        if ($model->load(Yii::$app->request->post())) {

            $icon = \yii\web\UploadedFile::getInstance($model, 'icon');
            $folder = \Yii::$app->basePath . "/storage/web/source/advertisement/";

            if (!file_exists($folder)) {
                FileHelper::createDirectory($folder, 0777);
            }

            if (!empty($icon)) {
                $model->icon = $icon->name;
                $icon->saveAs($folder . $icon);
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

        return $this->render('create', [
                    'model' => $model,
                    'vendor' => $vendor
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

        $file = $model->icon;

        $model->active_from = date("Y-m-d", strtotime($model->active_from));
        $model->active_to = date("Y-m-d", strtotime($model->active_to));
        
        $model->updated_at = CommonFunction::currentTimestamp();
        $model->updated_by = \Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {

            $folder = \Yii::$app->basePath . "/storage/web/source/advertisement/";

            $icon = \yii\web\UploadedFile::getInstance($model, 'icon');
            if (!empty($icon)) {
                $model->icon = $icon->name;
                $icon->saveAs($folder . $icon);
            } else {
                $model->icon = $file;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash("success", "Advertisements updated successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
                    'vendor' => $vendor
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
