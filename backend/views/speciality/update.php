<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Speciality */

// $this->title = 'Update Speciality: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Specialities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="speciality-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
