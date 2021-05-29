<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Emergency */

$this->title = 'Update Emergency: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Emergencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emergency-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
