<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use borales\extensions\phoneInput\PhoneInput;
use common\models\User;
use yii\widgets\DetailView;
use common\CommonFunction;

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
        <?php if (isset(Yii::$app->user->id) && !empty(Yii::$app->user->id)) { ?>
            <?php if (Yii::$app->user->identity->type == User::TYPE_JOB_SEEKER) { ?>
                <div class="col-sm-6">
                    <?= $form->field($model, 'ssn')->textInput(['maxlength' => true]) ?>
                </div>
            <?php } ?>
        <?php } ?>
        <div class="col-sm-6">

            <?php
            echo $form->field($model, 'dob')->widget(DatePicker::classname(), [
                'name' => 'dob',
//                'value' => date('d-M-Y'),
                'options' => ['placeholder' => 'Enter DOB..'],
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'autoclose' => true,
                    'endDate' => "-0d"
//                    'startDate' => date('d-m-Y'),
                ],
                'pluginEvents' => [
                    "changeDate" => "function(e) {

                            }"
                ]
            ]);
            ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'profile_pic')->fileInput() ?>
            
            <?php if(file_exists(CommonFunction::getProfilePictureBasePath()."/".$model->profile_pic)){ ?>
                <?php if (isset($model->profile_pic)) { ?>
                    <p><?= $model->profile_pic ?></p>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <?php if (isset($comppanyDetail) && !empty($comppanyDetail)) { ?>
        <p>&nbsp;</p>
        <h3>Company Details</h3>
        <?php
        echo DetailView::widget([
            'model' => $companyDetail,
            'attributes' => [
                'company_name',
                'reference_no',
                'company_email',
                'company_mobile',
            ],
        ]);
    }
    ?>
    <?php if (isset($branch) && !empty($branch)) { ?>
        <p>&nbsp;</p>
        <h3>Company Branch Details</h3>
        <?php
        echo DetailView::widget([
            'model' => $branch,
            'attributes' => [
                'branch_name',
                [
                    'label' => 'Company Name',
                    'value' => (isset($branch->company_id) && !empty($branch->company_id)) ? $branch->company->company_name : '',
                ],
                'street_no',
                'street_address',
                'apt',
                [
                    'label' => 'city',
                    'value' => (isset($model->city) && !empty($model->city)) ? $model->cityRef->city : "",
                ],
                'zip_code',
            ],
        ]);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>



