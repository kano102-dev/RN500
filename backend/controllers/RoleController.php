<?php

namespace backend\controllers;

use Yii;
use common\models\RoleMaster;
use common\models\RoleMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\db\Query;

/**
 * RoleController implements the CRUD actions for RoleMaster model.
 */
class RoleController extends Controller {

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
     * Lists all RoleMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new RoleMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RoleMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        $query = new Query();
        $features = $query->select(['auth_item.description AS desc', 'auth_item.name', 'auth_item.name AS child', 'auth_item_child.parent', 'auth_assignment.user_id'])
                ->from('auth_item')
                ->leftJoin('auth_item_child', 'auth_item.name=auth_item_child.child')
                ->leftJoin('auth_assignment', 'auth_item.name=auth_assignment.item_name AND auth_assignment.user_id="' . $model->id . '"')
                ->all();
        $tree = $this->parseTree($features, "", $model->id, 0, "1");
        return $this->render('view', [
                    'model' => $model, 'tree' => $tree
        ]);
    }

    /**
     * Creates a new RoleMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $auth = Yii::$app->authManager;
        $model = new RoleMaster();
        $query = new Query();
        $features = $query->select(['auth_item.description AS desc', 'auth_item.name', 'auth_item.name AS child', 'auth_item_child.parent'])
                ->from('auth_item')
                ->leftJoin('auth_item_child', 'auth_item.name=auth_item_child.child')
                ->all();
        $tree = $this->parseTree($features, "", "");
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $permissions = explode(',', $_POST['RoleMaster']['permissions']);
                $model->created_at = time();
                $model->updated_at = time();
                if ($model->save()) {
                    $error = 1;
                    foreach ($permissions as $value) {
                        $access = $auth->getPermission($value);
                        if ($auth->assign($access, $model->id)) {
                            $error = 1;
                        } else {
                            $error = 0;
                            break;
                        }
                    }
                    if ($error) {
                        $transaction->commit();
                        Yii::$app->session->setFlash("success", "Role created successfully.");
                    } else {
                        $auth->revokeAll($model->id);
                        $transaction->rollBack();
                        Yii::$app->session->setFlash("warning", "Something went wrong.");
                    }
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash("warning", "Something went wrong.");
                }
            } catch (\Exception $ex) {
                $transaction->rollBack();
            } finally {
                return $this->redirect(['index']);
            }
        }

        return $this->render('_form', [
                    'model' => $model, 'tree' => $tree
        ]);
    }

    /**
     * Updates an existing RoleMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        $query = new Query();
        $features = $query->select(['auth_item.description AS desc', 'auth_item.name', 'auth_item.name AS child', 'auth_item_child.parent', 'auth_assignment.user_id'])
                ->from('auth_item')
                ->leftJoin('auth_item_child', 'auth_item.name=auth_item_child.child')
                ->leftJoin('auth_assignment', 'auth_item.name=auth_assignment.item_name AND auth_assignment.user_id="' . $model->id . '"')
                ->all();
        $tree = $this->parseTree($features, "", $model->id);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $permissions = explode(',', $_POST['RoleMaster']['permissions']);
                $model->created_at = time();
                $model->updated_at = time();
                if ($model->save()) {
                    $auth->revokeAll($model->id);
                    $error = 1;
                    foreach ($permissions as $value) {
                        $access = $auth->getPermission($value);
                        if ($auth->assign($access, $model->id)) {
                            $error = 1;
                        } else {
                            $error = 0;
                            break;
                        }
                    }
                    if ($error) {
                        $transaction->commit();
                        Yii::$app->session->setFlash("success", "Role updated successfully.");
                    } else {
                        $auth->revokeAll($model->id);
                        $transaction->rollBack();
                        Yii::$app->session->setFlash("warning", "Something went wrong.");
                    }
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash("warning", "Something went wrong.");
                }
            } catch (\Exception $ex) {
                $transaction->rollBack();
            } finally {
                return $this->redirect(['index']);
            }
        }

        return $this->render('_form', [
                    'model' => $model, 'tree' => $tree
        ]);
    }

    public function parseTree($tree, $root, $selected_user, $parent_selected = 0, $disabled = "0") {
        $return = [];
        $i = 0;
        foreach ($tree as $branch) {
            extract($branch);
            if ($parent == $root) {
                unset($tree[$i]);

                $is_selected = ((isset($user_id) && $user_id != "") || $parent_selected == 1) ? true : false;
                $disable = ($disabled == "1" ? true : false);
                $return[] = [
                    'title' => $desc,
                    'key' => $name,
                    'selected' => $is_selected,
                    'unselectable' => $disable,
                    'expanded' => $is_selected,
                    'children' => $this->parseTree($tree, $child, $selected_user, $is_selected, $disabled)
                ];
            }
            $i++;
            $is_selected = 0;
        }

        return empty($return) ? null : $return;
    }

    /**
     * Deletes an existing RoleMaster model.
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
     * Finds the RoleMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RoleMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RoleMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
