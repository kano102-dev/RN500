<?php

namespace backend\controllers;

use Yii;
use common\models\Speciality;
use common\models\SpecialitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\CommonFunction;
use yii\helpers\Url;

/**
 * SpecialityController implements the CRUD actions for Speciality model.
 */
class SpecialityController extends Controller
{
    public $title = "Speciality";
    public $activeBreadcrumb, $breadcrumb;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
            $this->title => Yii::$app->urlManager->createAbsoluteUrl(['speciality/index']),
        ];
    }

    /**
     * Lists all Speciality models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpecialitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Speciality model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Speciality model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->activeBreadcrumb = "Create";

        $model = new Speciality();

        $model->created_at = CommonFunction::currentTimestamp();
        $model->updated_at = CommonFunction::currentTimestamp();

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
                Yii::$app->session->setFlash("success", "Speciality created successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Speciality model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->updated_at = CommonFunction::currentTimestamp();

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
                Yii::$app->session->setFlash("success", "Speciality updated successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Speciality model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Speciality model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Speciality the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Speciality::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
