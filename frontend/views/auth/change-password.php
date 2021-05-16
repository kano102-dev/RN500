<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;
?>
<style>
    .field_icon{
        float: right;
        margin-top: -24px;
    }
</style>
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="userccount">
                    <div class="formpanel"> 
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div  class="col-sm-12">
                                <?=
                                        $form->field($model, 'password', [
                                            'options' => ['class' => 'form-group has-feedback'],
//                                        'inputTemplate' => '{input}',
                                            'template' => '{input}<span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password" id="p1"></span>{error}',
                                        ])
                                        ->label(false)
                                        ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div  class="col-sm-12">
                                <?=
                                        $form->field($model, 'new_password', [
                                            'options' => ['class' => 'form-group has-feedback'],
//                                        'inputTemplate' => '{input}',
                                            'template' => '{input}<span toggle="#password-field" id="p2" class="fa fa-fw fa-eye field_icon toggle-password"></span>{error}',
                                        ])
                                        ->label(false)
                                        ->passwordInput(['placeholder' => $model->getAttributeLabel('new_password')])
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div  class="col-sm-12">
                                <?=
                                        $form->field($model, 'confirm_password', [
                                            'options' => ['class' => 'form-group has-feedback'],
//                                        'inputTemplate' => '{input}',
                                            'template' => '{input}<span toggle="#password-field" id="p3" class="fa fa-fw fa-eye field_icon toggle-password"></span>{error}',
                                        ])
                                        ->label(false)
                                        ->passwordInput(['placeholder' => $model->getAttributeLabel('confirm_password')])
                                ?>
                            </div>
                        </div>
                        <div class = "form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success'])
                            ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
        $(document).on('click', '#p1', function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    
    var input = $("#changepasswordform-password");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
        $(document).on('click', '#p2', function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    
    var input = $("#changepasswordform-new_password");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
        $(document).on('click', '#p3', function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    
    var input = $("#changepasswordform-confirm_password");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
JS;
$this->registerJs($script);
