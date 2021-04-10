<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SpecialitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Specialities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
        <?=Html::a('Create Speciality', ['create'], ['class' => 'btn btn-primary float-right'])?>

        <div class="table table-responsive pt-3">
            <?php Pjax::begin();?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?=GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
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
                    ]);?>

                <?php Pjax::end();?>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
