<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\Models\PackageMaster */

\yii\web\YiiAsset::register($this);
?>
<div class="card card-default color-palette-box">
    <div class="card-body">
        <p class="text-right">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'title',
                [
                    'attribute' => 'status',
                    'value' => function ($data) {
                        return $data->status == 1 ? 'Active' : 'Inactive';
                    }
                ]
            ],
        ])
        ?>
    </div>
</div>
