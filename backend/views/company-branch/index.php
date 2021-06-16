<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\CommonFunction;

$this->title = 'Branch';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <div class="col-md-12 col-sm-12">
            <?php if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('branch-create', Yii::$app->user->identity->id)) { ?>
                <?= Html::a('Create Branch', ['create'], ['class' => 'btn btn-primary float-right']) ?>
            <?php } ?>
            <div class="table table-responsive">

                <?php
                Pjax::begin();
                $cols = [];
                array_push($cols, ['class' => 'yii\grid\SerialColumn']);
                if (CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
                    array_push($cols, [
                        'attribute' => 'company_id',
                        'value' => function ($model) {
                            return $model->company->company_name;
                        }
                    ]);
                }
                array_push($cols, ['attribute' => 'branch_name']);
                array_push($cols, [
                    'attribute' => 'city',
                    'value' => function($model) {
                        return !empty($model->cityRef->city) ? $model->cityRef->city : '';
                    }
                ]);
                array_push($cols, [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:10%;'],
                    'header' => 'Actions',
                    'template' => '{view} {update}',
                    'buttons' => [
                        //view button
                        'view' => function ($url, $model) {
                            if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('branch-view', Yii::$app->user->identity->id)) {
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
                            if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('branch-update', Yii::$app->user->identity->id)) {
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