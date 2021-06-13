<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\CommonFunction;

$this->title = 'Recruiter';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-md-12 col-sm-12">
            <?php if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('recruiter-create', Yii::$app->user->identity->id)) { ?>
                <?= Html::a('Add Recruiter Company', ['create'], ['class' => 'btn btn-primary float-right mb-4']) ?>
            <?php } ?>

            
            <div class="table table-responsive">
                <?php Pjax::begin(['id' => 'pjax_recruiter', 'timeout' => false]); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
//                      
                        [
                            'attribute' => 'companyNames',
                        ],
                        'branchName',
                        'first_name',
                        'last_name',
                        [
                            'attribute' => 'email',
                            'value' => function ($model) {
                                return $model->user->email;
                            }
                        ],
                        [
                            'attribute' => 'city',
                            'value' => function ($model) {
                                return !empty($model->cityRef->city) ? $model->cityRef->city : '';
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
                                    if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('recruiter-view', Yii::$app->user->identity->id)) {
                                        return Html::a('<span class="fa fa-eye"></span>', ['recruiter/view', 'id' => $model->user_id], [
                                                    'data-pjax' => 0,
                                                    'title' => Yii::t('app', 'View'),
                                                    'class' => 'btn btn-primary btn-xs',
                                        ]);
                                    } else {
                                        return '';
                                    }
                                },
                                'update' => function ($url, $model) {
                                    if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('recruiter-update', Yii::$app->user->identity->id)) {
                                        return Html::a('<span class="fa fa-edit"></span>', ['recruiter/update', 'id' => $model->user_id], [
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