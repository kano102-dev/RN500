<?php

namespace backend\controllers;

use Yii;
use common\models\Benefits;
use common\models\BenefitsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\CommonFunction;
use yii\helpers\Url;

/**
 * BenefitsController implements the CRUD actions for Benefits model.
 */
class BenefitsController extends Controller
{

    public $title = "Benefits";
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
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['benefits/index']),
        ];
    }

    /**
     * Lists all Benefits models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BenefitsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Benefits model.
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
     * Creates a new Benefits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->activeBreadcrumb = "Create";
        $model = new Benefits();

        $model->created_at = CommonFunction::currentTimestamp();
        $model->updated_at = CommonFunction::currentTimestamp();
        $model->created_by = \Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
                Yii::$app->session->setFlash("success", "Benefit created successfully.");
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
     * Updates an existing Benefits model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->activeBreadcrumb = "Update";
        $model = $this->findModel($id);

        $model->updated_at = CommonFunction::currentTimestamp();
        $model->updated_by = \Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->session->setFlash("success", "Benefit updated successfully.");
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
     * Deletes an existing Benefits model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->delete()){
            Yii::$app->session->setFlash("success", "Benefit deleted successfully.");
        } else {
            Yii::$app->session->setFlash("success", "Benefit updated successfully.");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Benefits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Benefits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Benefits::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
