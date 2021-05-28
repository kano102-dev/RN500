<?php

namespace backend\controllers;

use Yii;
use common\models\Vendor;
use common\models\VendorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\CommonFunction;
use common\models\Cities;

/**
 * VendorController implements the CRUD actions for Vendor model.
 */
class VendorController extends Controller {

    public $title = "Vendor";
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
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['vendor/index']),
        ];
    }

    /**
     * Lists all Vendor models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VendorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vendor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        
        $cities = ArrayHelper::map(Cities::find()->all(), 'id', 'city');
        
        return $this->render('view', [
                    'model' => $model,
                    'cities' => $cities
        ]);
    }

    /**
     * Creates a new Vendor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Vendor();
        $this->activeBreadcrumb = "Create";

        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');

        $model->created_at = CommonFunction::currentTimestamp();
        $model->created_by = \Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash("success", "Vendor created successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
                    'model' => $model,
                    'states' => $states
        ]);
    }

    /**
     * Updates an existing Vendor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $this->activeBreadcrumb = "Update";
        
        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');
        $cities = ArrayHelper::map(Cities::find()->all(), 'id', 'city');
        
        $model = $this->findModel($id);
        
        $model->updated_at = CommonFunction::currentTimestamp();
        $model->updated_by = \Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash("success", "Vendor updated successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
                    'states' => $states
        ]);
    }

    /**
     * Deletes an existing Vendor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
     * Finds the Vendor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vendor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Vendor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
