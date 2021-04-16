<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\CommonFunction;

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
            <?php if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('user-create', Yii::$app->user->identity->id)) { ?>
                <?= Html::a('Add Staff', ['create'], ['class' => 'btn btn-primary float-right']) ?>
            <?php } ?>

            <div class="table table-responsive">

                <?php Pjax::begin(['id' => 'pjax_staff', 'timeout' => false]); ?>
                <?php
                $cols = [];
                array_push($cols, ['class' => 'yii\grid\SerialColumn']);
                array_push($cols, [
                    'attribute' => 'company',
                    'label' => 'Company Name',
                    'value' => function ($model) {
                        return !empty($model->companyNames) ? $model->companyNames : '';
                    }
                ]);
                array_push($cols, [
                    'attribute' => 'branch',
                    'label' => 'Branch Name',
                    'value' => function ($model) {
                        return !empty($model->branchName) ? $model->branchName : '';
                    }
                ]);
                array_push($cols, ['attribute' => 'first_name']);
                array_push($cols, ['attribute' => 'last_name']);
                array_push($cols, [
                    'attribute' => 'email',
                    'value' => function ($model) {
                        return $model->user->email;
                    }
                ]);
                array_push($cols, [
                    'attribute' => 'role',
                    'label' => 'Role',
                    'value' => function ($model) {
                        return !empty($model->user->role) ? $model->user->role->role_name : '';
                    }
                ]);
                array_push($cols, [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:5%;'],
                    'header' => 'Actions',
                    'template' => '{view} {update}',
                    'buttons' => [
                        //view button
                        'view' => function ($url, $model) {
                            if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('user-view', Yii::$app->user->identity->id)) {
                                return Html::a('<span class="fa fa-eye"></span>', ['staff/view', 'id' => $model->user_id], [
                                            'data-pjax' => 0,
                                            'title' => Yii::t('app', 'View'),
                                            'class' => 'btn btn-primary btn-xs',
                                ]);
                            } else {
                                return '';
                            }
                        },
                        'update' => function ($url, $model) {
                            if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('user-update', Yii::$app->user->identity->id)) {
                                return Html::a('<span class="fa fa-edit"></span>', ['staff/update', 'id' => $model->user_id], [
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
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $cols
                ]);
                ?>

                <?php Pjax::end(); ?>
            </div>


        </div>
    </div>
    <!-- /.card-body -->
</div>