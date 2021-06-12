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
use yii\filters\AccessControl;

/**
 * SpecialityController implements the CRUD actions for Speciality model.
 */
class SpecialityController extends Controller
{
    public $title = "Specialty";
    public $activeBreadcrumb, $breadcrumb;

 /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('specialty-create', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'update'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('specialty-update', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('specialty-view', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('specialty-delete', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
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
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['speciality/index']),
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
        $model->created_by = \Yii::$app->user->id;
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
        $model->updated_by = \Yii::$app->user->id;
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
