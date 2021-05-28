<?php

namespace backend\controllers;

use Yii;
use common\models\PackageMaster;
use common\models\PackageMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\filters\AccessControl;
use common\CommonFunction;

/**
 * PackageController implements the CRUD actions for PackageMaster model.
 */
class PackageController extends Controller {

    public $title = "Package";
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
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('package-create', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'update'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('package-update', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('package-view', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('package-delete', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
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
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['package/index']),
        ];
    }

    /**
     * Lists all PackageMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PackageMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PackageMaster model.
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
     * Creates a new PackageMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->activeBreadcrumb = "Create";
        $model = new PackageMaster();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = $model->updated_at = CommonFunction::currentTimestamp();
            $model->created_by = $model->updated_by = \Yii::$app->user->identity->id;
            if ($model->save()) {
                Yii::$app->session->setFlash("success", "Package created successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing PackageMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $this->activeBreadcrumb = "Update";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = CommonFunction::currentTimestamp();
            $model->updated_by = \Yii::$app->user->identity->id;
            if ($model->save()) {
                Yii::$app->session->setFlash("success", "Package updated successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PackageMaster model.
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
     * Finds the PackageMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PackageMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PackageMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
