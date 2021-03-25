<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RoleMaster */

$this->title = 'Create Role Master';
$this->params['breadcrumbs'][] = ['label' => 'Role Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
