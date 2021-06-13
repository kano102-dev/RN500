<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\CommonFunction;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RoleMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-md-12 col-sm-12">
            <?php if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('role-create', Yii::$app->user->identity->id)) { ?>
                <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-primary float-right']) ?>  
            <?php } ?>

            <div class="table table-responsive">

                <?php Pjax::begin(['id' => 'pjax_role', 'timeout' => false]); ?>
                <?php
                $cols = [];
                array_push($cols, ['class' => 'yii\grid\SerialColumn']);
                array_push($cols, ['attribute' => 'role_name']);
                if (CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
                    array_push($cols, ['attribute' => 'company_id',
                        'value' => function ($model) {
                            return $model->company->company_name;
                        }
                    ]);
                }
                array_push($cols, [
                    'attribute' => 'created_at',
                    'value' => function($model) {
                        return date('m-d-Y', $model->created_at);
                    },
                    'format' => 'raw',
                    'options' => ['width' => '200'],
                    'filter' => DatePicker::widget([
                        'attribute' => 'created_at',
                        'model' => $searchModel,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'mm-dd-yyyy',
                            'endDate' => date('m-d-Y'),
                            'clearBtn' => true,
                        ]
                    ]),
                ]);
                array_push($cols, [
                    'attribute' => 'updated_at',
                    'value' => function($model) {
                        return date('m-d-Y', $model->updated_at);
                    },
                    'format' => 'raw',
                    'options' => ['width' => '200'],
                    'filter' => DatePicker::widget([
                        'attribute' => 'updated_at',
                        'model' => $searchModel,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'mm-dd-yyyy',
                            'endDate' => date('m-d-Y'),
                            'clearBtn' => true,
                        ]
                    ]),
                ]);
                array_push($cols, [
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
                ]);
                ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $cols,
                ]);
                ?>

                <?php Pjax::end(); ?>
            </div>


        </div>
    </div>
    <!-- /.card-body -->
</div>