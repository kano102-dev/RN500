<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
?>
<style>
    @media (max-width:767px){
        .mt-10{margin-top: 10px;}
    }
</style>
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="wp_signup_right">
                    <h4>Contact Us</h4>

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name'])->label(false) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <?php echo $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email'])->label(false) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <?php echo $form->field($model, 'subject')->textInput(['maxlength' => true, 'placeholder' => 'Subject'])->label(false) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <?php echo $form->field($model, 'message')->textInput(['maxlength' => true, 'placeholder' => 'Message'])->label(false) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>                        
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="wp_cont_right mt-10">
                    <h3>RN500</h3>
                    <p>3100, North Ocean Dr, Fort Lauderdale, FL 33308. USA. </p>
                    <p>Phone: +1 123 – 456 – 7890</p>
                    <p>Email : <a href="mailto:info@RN500.com">info@RN500.com</a></p><br/>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3580.8662982361125!2d-80.10120853501806!3d26.168483483453706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d901fe31a55947%3A0x86cafcd957a8660e!2s3100%20N%20Ocean%20Blvd%2C%20Fort%20Lauderdale%2C%20FL%2033308%2C%20USA!5e0!3m2!1sen!2sin!4v1623780628609!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>