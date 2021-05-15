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
    .field-userdetails-street_address{margin-bottom: 5px;}
</style>
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
            <label class="control-label" for="city">City</label>
            <ul class="optionlist">
                <?php
                $url = Url::to(['browse-jobs/get-cities']);
                $location = isset($_GET['location']) ? implode(',', $_GET['location']) : 0;
                echo Select2::widget([
                    'name' => 'city',
                    'options' => [
                        'id' => 'city',
                        'placeholder' => 'Select Location...',
                        'multiple' => false,
                        'class' => '',
                        'value' => isset($model->city) ? $model->city : [],
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
        <div class="col-sm-6">
            <?= $form->field($model, 'ssn')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">

            <?php
            echo $form->field($model, 'dob')->widget(DatePicker::classname(), [
                'name' => 'dob',
                'value' => date('d-M-Y'),
                'options' => ['placeholder' => 'Enter DOB..'],
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'autoclose' => true,
//                    'startDate' => date('d-m-Y'),
                ],
                'pluginEvents' => [
                    "changeDate" => "function(e) {

                            }"
                ]
            ]);
            ?>
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