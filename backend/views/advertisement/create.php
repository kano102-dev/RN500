<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */

$this->title = 'Create Advertisement';
$this->params['breadcrumbs'][] = ['label' => 'Advertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'vendor' => $vendor
    ]) ?>

</div>
