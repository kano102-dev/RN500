<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use borales\extensions\phoneInput\PhoneInput;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .field-userdetails-street_address{margin-bottom: 5px;}
    .iti--allow-dropdown{width: 100%;}
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
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'value' => Yii::$app->user->identity->email, 'readonly' => true]) ?>
        </div>
        <div class="col-sm-6">
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
            <?= $form->field($model, 'looking_for')->textarea(['row' => 3]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'apt')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'street_no')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'street_address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <label class="control-label" for="city">City</label>
            <ul class="optionlist">
                <?php
                $url = Url::to(['browse-jobs/get-cities']);
                echo Select2::widget([
                    'name' => 'city',
                    'value' => isset($model->city) && !empty($model->city) ? $model->city : '',
                    'data' => $selectedLocations,
                    'options' => [
                        'id' => 'city',
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
                            'data' => new JsExpression('function(params) {return {q:params.term, page:params.page || 1}; }'),
                            'cache' => true,
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(location) { console.log(location);return location.name; }'),
                        'templateSelection' => new JsExpression('function (location) {
                                if(location.selected==true){
                                    return location.text; 
                                }else{
                                    return location.name;
                                }
                            }'),
                    ],
                ]);
                ?>
            </ul>
        </div>
    </div>
    <div class="row">
        <?php if (isset(Yii::$app->user->id) && !empty(Yii::$app->user->id)) { ?>
            <?php if (Yii::$app->user->identity->type == User::TYPE_JOB_SEEKER) { ?>
                <div class="col-sm-6">
                    <?= $form->field($model, 'ssn')->textInput(['maxlength' => 4]) ?>
                </div>
            <?php } ?>
        <?php } ?>
        <div class="col-sm-6">

            <?php
            echo $form->field($model, 'dob')->widget(DatePicker::classname(), [
                'name' => 'dob',
//                'value' => date('d-m-Y'),
//                'options' => ['placeholder' => 'Enter DOB..'],
                'pluginOptions' => [
                    'format' => 'M-d-yyyy',
                    'todayHighlight' => true,
                    'autoclose' => true,
                    'endDate' => "-0d"
//                    'startDate' => date('d-m-Y'),
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'profile_pic')->fileInput() ?>

            <?php if (isset($model->profile_pic)) { ?>
                <p><?= $model->profile_pic ?></p>
            <?php } ?>
        </div>

        <?php if (Yii::$app->user->identity->type == User::TYPE_JOB_SEEKER) { ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'interest_level')->dropDownList(Yii::$app->params['INTERESTS_LEVEL']) ?>
            </div>
        <?php } ?>
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
        var formData = new FormData(form[0]); 
        $.ajax({
            url    : form.attr('action'),
            type   : 'post',
            dataType : 'json',
            data   : formData,
            processData: false,
            contentType: false,
            success: function (response){
                try{
                    if(!response.error){
                        $("#commonModal").modal('hide');
        
                        $.pjax.reload({container: "#job-seeker", timeout: false, async:false});
                        $.pjax.reload({'container': '#res-messages', timeout: false, async:false});    
//                        $.pjax.reload({container: "#job-seeker", timeout: 2000});
//                        $(document).on("pjax:success", "#job-seeker", function (event) {
//                            $.pjax.reload({'container': '#res-messages', timeout: false});
//                        });
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