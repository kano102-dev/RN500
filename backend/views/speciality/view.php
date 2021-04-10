<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Speciality */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Specialities', 'url' => ['index']];
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
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>
