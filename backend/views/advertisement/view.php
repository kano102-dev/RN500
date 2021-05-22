<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */

$location = [0=>'Ahemdabad',1=>'Mumbai'];
$status = [0=>'No',1=>'Yes'];

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Advertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <p class="text-right">
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>

        <div class="row">
            <div class="col-6">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'description:ntext',
                        'link_url:url',
                        'icon',
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
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>
