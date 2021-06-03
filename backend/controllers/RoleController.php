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
use yii\helpers\Url;
use common\CommonFunction;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * RoleController implements the CRUD actions for RoleMaster model.
 */
class RoleController extends Controller {

    public $title = "Role";
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
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('role-create', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'update'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('role-update', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('role-view', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
                    ],
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('role-delete', Yii::$app->user->identity->id) ? ['@'] : ['*'] : ['*'],
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
            $this->title => Yii::$app->urlManagerAdmin->createAbsoluteUrl(['role/index']),
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
        $this->activeBreadcrumb = "Detail View";
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        $query = new Query();
        $features = [];
        if (CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
            $features = $query->select(['auth_item.description AS desc', 'auth_item.name', 'auth_item.name AS child', 'auth_item_child.parent', 'auth_assignment.user_id'])
                    ->from('auth_item')
                    ->leftJoin('auth_item_child', 'auth_item.name=auth_item_child.child')
                    ->leftJoin('auth_assignment', 'auth_item.name=auth_assignment.item_name AND auth_assignment.user_id="' . $model->id . '"')
                    ->all();
        } else {
            $features = \Yii::$app->db->createCommand('SELECT `auth_item`.`description` AS `desc`, `auth_item`.`name`, `auth_item`.`name` AS `child`, IF(auth_item.name=auth_item_child.parent, "",auth_item_child.parent) as parent,aa.user_id FROM  auth_assignment
INNER JOIN `auth_item_child` ON auth_assignment.item_name=auth_item_child.child
INNER JOIN `auth_item` ON auth_item.name=auth_item_child.child OR auth_item.name=auth_item_child.parent
LEFT JOIN `auth_assignment` as aa ON auth_item.name=aa.item_name AND aa.user_id=' . $model->id . ' 
where auth_assignment.user_id=' . \Yii::$app->user->identity->role_id . ' group by auth_item.name')->queryAll();
        }
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
        $this->activeBreadcrumb = "Create";
        $auth = Yii::$app->authManager;
        $model = new RoleMaster();
        $query = new Query();
        $features = [];
        if (CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
            $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1])->all(), 'id', 'company_name');
            $features = $query->select(['auth_item.description AS desc', 'auth_item.name', 'auth_item.name AS child', 'auth_item_child.parent'])
                    ->from('auth_item')
                    ->leftJoin('auth_item_child', 'auth_item.name=auth_item_child.child')
                    ->all();
        } else {
            $companyList = [];
            $features = \Yii::$app->db->createCommand('SELECT `auth_item`.`description` AS `desc`, `auth_item`.`name`, `auth_item`.`name` AS `child`, IF(auth_item.name=auth_item_child.parent, "",auth_item_child.parent) as parent FROM  auth_assignment
inner JOIN `auth_item_child` ON auth_assignment.item_name=auth_item_child.child
INNER JOIN `auth_item` ON auth_item.name=auth_item_child.child OR auth_item.name=auth_item_child.parent
where auth_assignment.user_id=' . \Yii::$app->user->identity->role_id . ' group by auth_item.name')->queryAll();
        }
        $tree = $this->parseTree($features, "", "");
//        echo "<pre/>";
//        print_r($tree);
//        exit;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $permissions = explode(',', $_POST['RoleMaster']['permissions']);
                $model->created_at = time();
                $model->updated_at = time();
                if (!CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
                    $model->company_id = \Yii::$app->user->identity->branch->company_id;
                }
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
                    'model' => $model, 'tree' => $tree,
                    'companyList' => $companyList
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
        $this->activeBreadcrumb = "Update";
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        $query = new Query();
        $features = [];
        if (CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
            $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1])->all(), 'id', 'company_name');
            $features = $query->select(['auth_item.description AS desc', 'auth_item.name', 'auth_item.name AS child', 'auth_item_child.parent', 'auth_assignment.user_id'])
                    ->from('auth_item')
                    ->leftJoin('auth_item_child', 'auth_item.name=auth_item_child.child')
                    ->leftJoin('auth_assignment', 'auth_item.name=auth_assignment.item_name AND auth_assignment.user_id="' . $model->id . '"')
                    ->all();
        } else {
            if (\common\CommonFunction::isHoAdmin(Yii::$app->user->identity->id)) {
                $companyList = ArrayHelper::map(\common\models\CompanyMaster::find()->where(['status' => 1, 'id' => Yii::$app->user->identity->branch->company_id])->all(), 'id', 'company_name');
            } else {
                $companyList = [];
            }
            $features = \Yii::$app->db->createCommand('SELECT `auth_item`.`description` AS `desc`, `auth_item`.`name`, `auth_item`.`name` AS `child`, IF(auth_item.name=auth_item_child.parent, "",auth_item_child.parent) as parent,aa.user_id FROM  auth_assignment
INNER JOIN `auth_item_child` ON auth_assignment.item_name=auth_item_child.child
INNER JOIN `auth_item` ON auth_item.name=auth_item_child.child OR auth_item.name=auth_item_child.parent
LEFT JOIN `auth_assignment` as aa ON auth_item.name=aa.item_name AND aa.user_id=' . $model->id . ' 
where auth_assignment.user_id=' . \Yii::$app->user->identity->role_id . ' group by auth_item.name')->queryAll();
        }
        $tree = $this->parseTree($features, "", $model->id);
        if ($model->load(Yii::$app->request->post())) {
            $permissions = explode(',', $_POST['RoleMaster']['permissions']);
            $model->updated_at = time();
            if ($model->save()) {
                $cnt = 0;
                $auth->revokeAll($model->id);
                $error = 1;
                foreach ($permissions as $value) {
                    $access = $auth->getPermission($value);
                    if ($auth->assign($access, $model->id)) {
                        $cnt = $cnt + 1;
                        $error = 1;
                    } else {
                        print_r($value);
                        $error = 0;
                        break;
                    }
                }
                if ($error) {
                    Yii::$app->session->setFlash("success", "Role updated successfully.");
                } else {
                    $auth->revokeAll($model->id);
                    Yii::$app->session->setFlash("warning", "Something went wrong.");
                }
            } else {
                Yii::$app->session->setFlash("warning", "Something went wrong.");
            }
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
                    'model' => $model, 'tree' => $tree,
                    'companyList' => $companyList
        ]);
    }

    public function parseTree($tree, $root, $selected_user, $parent_selected = 0, $disabled = "0") {
        $return = [];
        $i = 0;
//        echo "<pre/>";
//        print_r($tree);
//        exit;
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
