<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\JsExpression;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .iti--allow-dropdown{width: 100%;}
</style>
<div class="user-details-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'add-reference'
    ]);
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'first_name')->textInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'last_name')->textInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'email')->textInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?=
            $form->field($model, 'mobile_no')->widget(PhoneInput::className(), [
                'jsOptions' => [
                    'preferredCountries' => ['us', 'in'],
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title')->dropDownList(Yii::$app->params['REFERENCE_TYPE']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS

$(document).on("beforeSubmit", "#add-reference", function () {
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
