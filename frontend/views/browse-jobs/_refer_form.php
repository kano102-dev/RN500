<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

$actionUrl = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/refer-to-friend-post', 'lead_id' => $model->lead_id]);
?>

<div class="referral-form">

    <div class="row">
        <div class="col-md-12 mb-3">
            <?php $form = ActiveForm::begin(['id' => 'referral_form', 'options' => ['autocomplete' => 'off'], 'action' => $actionUrl]); ?>
            <?php echo $form->field($model, 'lead_id')->hiddenInput()->label(false) ?>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <?php echo $form->field($model, 'from_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('from_name')]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <?php echo $form->field($model, 'from_email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('from_email')]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <?php echo $form->field($model, 'to_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('to_name')]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <?php echo $form->field($model, 'to_email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('to_email')]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <?php echo $form->field($model, 'description')->textarea(['rows' => 4, 'maxlength' => true, 'placeholder' => $model->getAttributeLabel('description')]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>                        
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>



<?php
$script_new = <<<JS
        
$(document).ready(function() {
    $(document).off('submit').on('submit','form#referral_form',function(e){
        e.preventDefault();
        e.returnValue = false;
        var form = $(this);
        if (form.find('.has-error').length > 0) { 
            return false;
        } else {
            var ajaxRequest= $.post(form.attr('action'), form.serialize(), function(data) {
            console.log('****data***',data);
            }).always(function() {
                $("#commonModal").modal('hide');
                $.pjax.reload({container: '#res-messages', timeout:false, async: false});
            });
        }
    })
})
JS;
$this->registerJS($script_new, 3);
?>