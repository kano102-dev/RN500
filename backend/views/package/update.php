<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\Models\PackageMaster */

$this->title = 'Update Package Master: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Package Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="package-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
