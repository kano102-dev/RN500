<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    label {display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: 700;}
    .mb-100{margin-bottom: 100px;}
    .mt-100{margin-top: 100px;}
    .iti--allow-dropdown{width: 100%;}
</style>

<div class="container mb-100 mt-100">
    <?php
    $form = ActiveForm::begin([
                "id" => "user-details",
                'options' => ['enctype' => 'multipart/form-data']
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
            <?=
            $form->field($model, 'mobile_no')->widget(PhoneInput::className(), [
                'jsOptions' => [
                    'preferredCountries' => ['us', 'in'],
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'value' => Yii::$app->user->identity->email, 'readonly' => true]) ?>
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
                $value = ['city' => $model->city];
                $url = Url::to(['browse-jobs/get-cities']);
                $location = isset($_GET['location']) ? implode(',', $_GET['location']) : 0;
                echo Select2::widget([
                    'name' => 'city',
                    'options' => [
                        'id' => 'city',
                        'value' => $value,
                        'multiple' => false,
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
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'looking_for')->textarea(['row' => 3]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'profile_pic')->fileInput() ?>
            <?php if(isset($model->profile_pic)){ ?>
                <p><?= $model->profile_pic ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>



