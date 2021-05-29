
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model common\models\Vendor */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Emergency';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? "Create" : "Update";
?>


<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="form-group text">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

