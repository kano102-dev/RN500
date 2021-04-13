<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */

//$this->title = 'Update Advertisement: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Advertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="advertisement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'vendor' => $vendor
    ]) ?>

</div>
