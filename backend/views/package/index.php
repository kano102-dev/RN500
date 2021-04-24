<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\CommonFunction;

$this->title = 'Package';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
            <?php if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('package-create', Yii::$app->user->identity->id)) { ?>
                <?= Html::a('Create Package', ['create'], ['class' => 'btn btn-primary float-right']) ?>
            <?php } ?>

            <div class="table table-responsive">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'title',
                        'price',
                        [
                            'attribute' => 'status',
                            'value' => function ($data) {
                                return $data->status == 1 ? 'Active' : 'Inactive';
                            },
                            'format' => 'raw',
                            'options' => ['width' => '200'],
                            'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'status', ['1' => 'Active', '2' => 'Inactive'], ['class' => 'form-control','prompt'=>'Select'])
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
                                    if ($model->id != 1) {
                                        return Html::a('<span class="fa fa-edit"></span>', $url, [
                                                    'data-pjax' => 0,
                                                    'title' => Yii::t('app', 'Update'),
                                                    'class' => 'btn btn-primary btn-xs',
                                        ]);
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