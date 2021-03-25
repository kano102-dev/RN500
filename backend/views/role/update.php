<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RoleMaster */

$this->title = 'Update Role Master: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Role Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="role-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
