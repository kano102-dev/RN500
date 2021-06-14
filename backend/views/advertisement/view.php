<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */
$status = [0=>'No',1=>'Yes'];
\yii\web\YiiAsset::register($this);
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <p class="text-right">
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'description:ntext',
                        'link_url:url',
                        [
                            'attribute' => 'video_link',
                            'value' => function ($model) {
                                return (isset($model->video_link) && !empty($model->video_link)) ? $model->video_link : "-";
                            },
                        ],
                        [
                            'attribute' => 'icon',
                            'value' => function ($model) {
                                return (isset($model->icon) && !empty($model->icon)) ? $model->icon : "-";
                            },
                        ],
                        [
                            'attribute' => 'is_active',
                            'value' => function ($model) use ($status) {
                                return $status[$model->is_active];
                            },
                        ],
                        [
                            'attribute' => 'active_from',
                            'value' => function ($model) {
                                return date("m/d/Y", strtotime($model->active_from));
                            },
                        ],
                        [
                            'attribute' => 'active_to',
                            'value' => function ($model) {
                                return date("m/d/Y", strtotime($model->active_to));
                            },
                        ],
                        [
                            'attribute' => 'location',
                            'value' => function ($model) {
                                return $model->city->city;
                            },
                        ],
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>
