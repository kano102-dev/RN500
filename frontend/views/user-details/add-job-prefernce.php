<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .field-jobpreference-shift{margin-top: 15px;}
</style>
<div class="user-details-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'add-job-preference'
    ]);
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'job_preference')->textInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label" for="city">location</label>
            <ul class="optionlist">
                <?php
                $url = Url::to(['browse-jobs/get-cities']);
                echo Select2::widget([
                    'name' => 'location',
                    'options' => [
                        'id' => 'location',
                        'placeholder' => 'Select Location...',
                        'multiple' => false,
                        'class' => '',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'ajax' => [
                            'url' => $url,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) {return {q:params.term, page:params.page || 1}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(location) { console.log(location);return location.name; }'),
                        'templateSelection' => new JsExpression('function (location) {return location.name; }'),
                    ],
                ]);
                ?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'shift')->textInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'pay')->textInput(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
var click = 0;
$(document).on("beforeSubmit", "#add-job-preference", function () {
   if(click == 0){  
        ++click;   
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
                         $.pjax.reload({container: "#job-seeker", timeout: false, async:false});
                         $.pjax.reload({'container': '#res-messages', timeout: false, async:false});
        
//                         $.pjax.reload({container: "#job-seeker", timeout: 2000});
//                         $(document).on("pjax:success", "#job-seeker", function (event) {
//                             $.pjax.reload({'container': '#res-messages', timeout: 2000});
//                         });
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
    }
});  
        
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>
