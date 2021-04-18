<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */
/* @var $form yii\widgets\ActiveForm */
$location = [1 => 'Home Page'];
$status = [0 => 'No', 1 => 'Yes'];
?>

<div class="advertisement-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6">
                    <div class="col-lg-4">
                        <?php echo $form->field($model, 'icon')->fileInput(); ?>
                        <?php if (isset($model->icon) && !empty($model->icon)) { ?>
                            <p><?php echo $model->icon; ?></p>
                        <?php } ?>    
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'location_name')->textInput(['autocomplete' => 'on', 'placeholder' => 'Search by Location']) ?>
                </div>
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'link_url'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'description')->textarea(['rows' => '3']) ?>
                </div>
                <div class="col-md-6 custom-time-data-picker">
                    <?= $form->field($model, 'active_from')->textInput(["type" => "date"]) ?>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6 custom-time-data-picker">
                    <?= $form->field($model, 'active_to')->textInput(["type" => "date"]) ?>
                </div>   
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'location_display')->dropDownList($location, ['prompt' => 'Select Display Location']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'is_active')->dropDownList($status, ['prompt' => 'Select Status']) ?>
                </div>
                <div class="col-6">
                    <?=
                    $form->field($model, 'vendor_id')->widget(Select2::classname(), [
                        'data' => $vendor,
                        'options' => ['placeholder' => 'Select a Vendor'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
