<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Emergency */

$this->title = 'Create Emergency';
$this->params['breadcrumbs'][] = ['label' => 'Emergencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emergency-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
