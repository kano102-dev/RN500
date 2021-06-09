<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\models\LeadRecruiterJobSeekerMapping;
$actionUrl = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => $status]);
?>
<style>
    label {display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: 700;}
</style>
<div class="recruiter-approval-form">
    <?php
    $form = ActiveForm::begin(['id' => 'recruiter_approval_form',
                'options' => ['autocomplete' => 'off'],
                'action'=> $actionUrl
                
    ]);
    ?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <?php echo $form->field($model, 'rec_comment')->textarea(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('rec_comment')]) ?>
        </div>
    </div>
    <?php if($status == LeadRecruiterJobSeekerMapping::STATUS_APPROVED){ ?>
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

    <div class="row">
        <div class="col-md-12 mb-3">
            <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>                        
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>