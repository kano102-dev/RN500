<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-details-form">
    <?php
    $form = ActiveForm::begin([
                "id" => "user-details",
    ]);
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'looking_for')->textarea(['row' => 3]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'apt')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'street_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'street_address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'ssn')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'dob')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS
        
$(document).on("beforeSubmit", "#user-details", function () {
   var form = $(this);
        $.ajax({
            url    : form.attr('action'),
            type   : 'post',
            dataType : 'json',
            data   : form.serialize(),
            success: function (response){
                try{
                    if(!response.error){
                        $("#profile-modal").modal('hide');
                        $.pjax.reload({container: "#job-seeker", timeout: 2000});
                        $(document).on("pjax:success", "#job-seeker", function (event) {
                            $.pjax.reload({'container': '#res-messages', timeout: 2000});
                        });
                        getProfilePercentage();
                    }
                }catch(e){
                    $.pjax.reload({'container': '#res-messages', timeout: 2000});
                }
            },
            error  : function () 
            {
                console.log('internal server error');
            }
        });
        return false;
});        
        
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>        