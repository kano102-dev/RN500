<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Speciality */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Speciality';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? "Create" : "Update";
?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php $form = ActiveForm::begin();?>

        <div class="row">
            <div class="col-md-6 col-sm-12">
            <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>
            </div>
        </div>
        <div class="form-group">
            <?=Html::submitButton('Save', ['class' => 'btn btn-primary'])?>
        </div>

        <?php ActiveForm::end();?>
    </div>
</div>
