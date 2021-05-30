<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
?>

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
                <div class="wp_cont_right">
                    <h3>RN 500</h3>
                    <p>3100, North Ocean Dr, Fort Lauderdale, FL 33308. USA. </p>
                    <p>Phone: +1 123 – 456 – 7890</p>
                    <p>Email : <a href="mailto:info@RN500.com">info@RN500.com</a></p>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3345.2557187294674!2d-96.71805198481168!3d33.02339278089834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x864c18fac042213b%3A0x5f0bc25bf162dadc!2s1700%20Alma%20Dr%20%23200%2C%20Plano%2C%20TX%2075075!5e0!3m2!1sen!2sus!4v1608812203114!5m2!1sen!2sus" width="100%" class="wp_cont_map" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </div>
</div>