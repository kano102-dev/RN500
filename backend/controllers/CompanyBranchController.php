<?php

namespace backend\controllers;

use Yii;
use common\models\CompanyBranch;
use common\models\CompanyBranchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Cities;
use yii\helpers\ArrayHelper;
use common\models\UserDetails;
use common\CommonFunction;
use common\models\User;
use common\models\RoleMaster;
use common\models\PasswordResetRequestForm;

/**
 * CompanyBranchController implements the CRUD actions for CompanyBranch model.
 */
class CompanyBranchController extends Controller {

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

    /**
     * Lists all CompanyBranch models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CompanyBranchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyBranch model.
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
     * Creates a new CompanyBranch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $companyBranchModel = new CompanyBranch();
        $userDetailModel = new UserDetails();
        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');

        if ($companyBranchModel->load(Yii::$app->request->post()) && $userDetailModel->load(Yii::$app->request->post())) {
            $is_success = false;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $companyBranchModel->company_id = Yii::$app->user->identity->branch->company_id;
                $companyBranchModel->is_default = CompanyBranch::IS_DEFAULT_YES;
                $companyBranchModel->created_at = $companyBranchModel->updated_at = CommonFunction::currentTimestamp();
                $userDetailModel->created_at = $userDetailModel->updated_at = CommonFunction::currentTimestamp();
                if ($companyBranchModel->save()) {

                    $user = new User();
                    $user->email = $userDetailModel->email;
                    $user->type = User::TYPE_RECRUITER;
                    $user->status = User::STATUS_INACTIVE;
                    $user->branch_id = $companyBranchModel->id;
                    $user->role_id = RoleMaster::RECRUITER_OWNER;
                    $user->is_owner = User::OWNER_YES;
                    if ($user->save()) {
                        $userDetailModel->user_id = $user->id;
                        if ($userDetailModel->save()) {
                            $is_success = true;
                            $resetPasswordModel = new PasswordResetRequestForm();
                            $resetPasswordModel->email = $user->email;
                            if ($resetPasswordModel->sendEmail($is_welcome_mail = 1)) {
                                $is_success = true;
                            }
                        }
                    }
                }

                if ($is_success) {
                    $transaction->commit();
                    Yii::$app->session->setFlash("success", "Branch was added successfully.");
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash("warning", "Something went wrong.");
                }
            } catch (\Exception $ex) {
                echo "<pre/>";
                print_r($ex);
                exit;
                $transaction->rollBack();
            } finally {
                return $this->redirect(['index']);
            }
        }

        return $this->render('_form', [
                    'companyBranchModel' => $companyBranchModel,
                    'states' => $states,
                    'userDetailModel' => $userDetailModel
        ]);
    }

    /**
     * Updates an existing CompanyBranch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $states = ArrayHelper::map(\common\models\States::find()->where(['country_id' => 226])->all(), 'id', 'state');

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = time();
            if ($model->save()) {
                Yii::$app->session->setFlash("success", "Branch was updated successfully.");
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
                    'model' => $model, 'states' => $states
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
     * Deletes an existing CompanyBranch model.
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
     * Finds the CompanyBranch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyBranch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = CompanyBranch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
