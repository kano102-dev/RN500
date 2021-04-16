<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\CommonFunction;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RoleMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
            <?php if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('role-create', Yii::$app->user->identity->id)) { ?>
                <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-primary float-right']) ?>  
            <?php } ?>

            <div class="table table-responsive">

                <?php Pjax::begin(['id' => 'pjax_role', 'timeout' => false]); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'role_name',
                        [
                            'attribute' => 'create_at',
                            'value' => function($model) {
                                return date('d-m-Y', $model->created_at);
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'contentOptions' => ['style' => 'width:5%;'],
                            'header' => 'Actions',
                            'template' => '{view} {update}',
                            'buttons' => [
                                //view button
                                'view' => function ($url, $model) {
                                    if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('role-view', Yii::$app->user->identity->id)) {
                                        return Html::a('<span class="fa fa-eye"></span>', $url, [
                                                    'data-pjax' => 0,
                                                    'title' => Yii::t('app', 'View'),
                                                    'class' => 'btn btn-primary btn-xs',
                                        ]);
                                    } else {
                                        return '';
                                    }
                                },
                                'update' => function ($url, $model) {
                                    if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('role-update', Yii::$app->user->identity->id)) {
                                        return Html::a('<span class="fa fa-edit"></span>', $url, [
                                                    'data-pjax' => 0,
                                                    'title' => Yii::t('app', 'Update'),
                                                    'class' => 'btn btn-primary btn-xs',
                                        ]);
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                        ],
                    ],
                ]);
                ?>

                <?php Pjax::end(); ?>
            </div>


        </div>
    </div>
    <!-- /.card-body -->
</div>