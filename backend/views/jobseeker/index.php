<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\CommonFunction;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
            <div class="table table-responsive">

                <?php Pjax::begin(['id' => 'pjax_jobseeker', 'timeout' => false]); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'unique_id',
                            'label' => 'Reference No.'
                        ],
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
                            'template' => '{view}',
                            'buttons' => [
                                //view button
                                'view' => function ($url, $model) {
                                    if (isset(Yii::$app->user->identity)) {
                                        return Html::a('<span class="fa fa-eye"></span>', ['jobseeker/view', 'ref' => $model->unique_id], [
                                                    'data-pjax' => 0,
                                                    'title' => Yii::t('app', 'View'),
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