<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\Models\PackageMaster */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card card-default color-palette-box">
    
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-12">

<div class="card card-primary">

    <div class="card-body">

        <div class="row">
            <div class="col-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        </div>
        <div class="form-group text text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>

