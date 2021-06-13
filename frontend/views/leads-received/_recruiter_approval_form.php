<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\models\LeadRecruiterJobSeekerMapping;
use common\CommonFunction;

$actionUrl = (CommonFunction::isRecruiter()) ? Yii::$app->urlManagerFrontend->createAbsoluteUrl(['leads-received/approval-from-recruiter', 'lrj' => $model->id, 'status' => $status]) : $actionUrl = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['leads-received/approval-from-employer', 'lrj' => $model->id, 'status' => $status]);
?>

<div class="recruiter-approval-form">

    <?php $form = ActiveForm::begin(['id' => 'approval_form', 'options' => ['autocomplete' => 'off'], 'action' => $actionUrl]); ?>

    <?php if (CommonFunction::isRecruiter()) { ?>
        <div class="row">
            <div class="col-md-12 mb-3">
                <?php echo $form->field($model, 'rec_comment')->textarea(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('rec_comment')]) ?>
            </div>
        </div>
        <?php if ($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED) { ?>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <?php
                    echo $form->field($model, 'rec_joining_date')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Select ' . $model->getAttributeLabel('rec_joining_date')],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-M-yyyy'
                        ]
                    ]);
                    ?>

                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if (CommonFunction::isEmployer()) { ?>
        <div class="row">
            <div class="col-md-12 mb-3">
                <?php echo $form->field($model, 'employer_comment')->textarea(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('employer_comment')]) ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-md-12 mb-3">
            <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>                        
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>



<?php
$script_new = <<<JS
        
$(document).ready(function() {
    $(document).off('submit').on('submit','form#approval_form',function(e){
        e.preventDefault();
        e.returnValue = false;
        var form = $(this);
        if (form.find('.has-error').length > 0) { 
            return false;
        } else {
            var ajaxRequest= $.post(form.attr('action'), form.serialize(), function(data) {
            }).always(function() {
                $.pjax.reload({container: '#pjx_pending', timeout:false, async: false});
                $("#commonModal").modal('hide');
                $.pjax.reload({container: '#res-messages', timeout:false, async: false});
            });
        }
    })
})
JS;
$this->registerJS($script_new, 3);
?>