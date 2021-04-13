<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdvertisementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$location = [0=>'Ahemdabad',1=>'Mumbai'];
$status = [0=>'No',1=>'Yes'];

$this->title = 'Advertisements';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
            <?= Html::a('Create Advertisement', ['create'], ['class' => 'btn btn-primary float-right']) ?>

            <div class="table table-responsive pt-3">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',
                        'description:ntext',
                        'link_url:url',
                        'location_name',
                        [
                            'attribute' => 'is_active',
                            'value' => function ($model) use ($status) {
                                return $status[$model->is_active];
                            },
                        ],
                        [
                            'attribute' => 'location_display',
                            'value' => function ($model) use ($location) {
                                return $location[$model->location_display];
                            },
                        ],
                        [
                            'attribute' => 'active_from',
                            'value' => function ($model) {
                                return date("d/m/Y", strtotime($model->active_to));
                            },
                        ],
                        [
                            'attribute' => 'active_to',
                            'value' => function ($model) {
                                return date("d/m/Y", strtotime($model->active_to));
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'contentOptions' => ['style' => 'width:5%;'],
                            'header' => 'Actions',
                            'template' => '{view} {update}',
                            'buttons' => [
                                //view button
                                'view' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-eye"></span>', $url, [
                                                'data-pjax' => 0,
                                                'title' => Yii::t('app', 'View'),
                                                'class' => 'btn btn-primary btn-xs',
                                    ]);
                                },
                                'update' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-edit"></span>', $url, [
                                                'data-pjax' => 0,
                                                'title' => Yii::t('app', 'Update'),
                                                'class' => 'btn btn-primary btn-xs',
                                    ]);
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
