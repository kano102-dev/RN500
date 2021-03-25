<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\Models\PackageMaster */

$this->title = 'Create Package Master';
$this->params['breadcrumbs'][] = ['label' => 'Package Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
