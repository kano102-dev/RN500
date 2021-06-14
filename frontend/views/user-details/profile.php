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

<div class="listpgWraper">
    <div class="container">
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
                <?=
                $form->field($model, 'state')->widget(Select2::classname(), [
                    'data' => $states,
                    'options' => ['placeholder' => 'Select a province'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?=
                $form->field($model, 'city')->widget(Select2::classname(), [
                    'data' => $city,
                    'options' => ['placeholder' => 'Select a city'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
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
                <?= $form->field($model, 'profile_pic')->fileInput() ?>

                <?php if (file_exists(CommonFunction::getProfilePictureBasePath() . "/" . $model->profile_pic)) { ?>
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
</div>
</div>
<?php
$getCitiesUrl = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['user-details/get-cities']);
$script = <<< JS
   $(document).on('change','#userdetails-state',function(){
        var state=$(this).val();
       $.ajax({
                method: 'GET',
                url: '$getCitiesUrl',
                data: {'id':state},
                success: function (response) {
                    $('#userdetails-city').html(response);
                }
            });
   });
JS;
$this->registerJs($script);
