<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use borales\extensions\phoneInput\PhoneInput;

$this->title = 'Recruiter';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $companyMasterModel->isNewRecord ? "Create" : "Update";
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <?php $form = ActiveForm::begin(['id' => 'form_recruiter_signup', 'options' => []]); ?>


        <div class="col-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Company</h3>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($companyMasterModel, 'company_name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($companyMasterModel, 'company_email')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <?=
                            $form->field($companyMasterModel, 'company_mobile')->widget(PhoneInput::className(), [
                                'jsOptions' => [
                                    'preferredCountries' => ['us', 'in'],
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($companyMasterModel, 'street_no')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($companyMasterModel, 'street_address')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($companyMasterModel, 'apt')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?=
                            $form->field($companyMasterModel, 'state')->widget(Select2::classname(), [
                                'data' => $states,
                                'options' => ['placeholder' => 'Select a province'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-6">
                            <?=
                            $form->field($companyMasterModel, 'city')->widget(Select2::classname(), [
                                'data' => $companyMasterModel->isNewRecord ? [] : $CompanyCity,
                                'options' => ['placeholder' => 'Select a city'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($companyMasterModel, 'zip_code')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($companyMasterModel, 'employer_identification_number')->textInput(['maxlength' => true]); ?>
                        </div>
                    </div>
                </div>
            </div>



            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Company Owner Details</h3>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($userDetailModel, 'first_name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($userDetailModel, 'last_name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?=
                            $form->field($userDetailModel, 'mobile_no')->widget(PhoneInput::className(), [
                                'jsOptions' => [
                                    'preferredCountries' => ['us', 'in'],
                                ]
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($userDetailModel, 'street_no')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($userDetailModel, 'street_address')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($userDetailModel, 'apt')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?=
                            $form->field($userDetailModel, 'state')->widget(Select2::classname(), [
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

                        <div class="col-6">
                            <?=
                            $form->field($userDetailModel, 'city')->widget(Select2::classname(), [
                                'data' => $userDetailModel->isNewRecord ? [] : $city,
                                'options' => ['placeholder' => 'Select a city'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($userDetailModel, 'zip_code')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <div class="form-group text text-center">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>



    </div>
</div>
<?php
$getCitiesUrl = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['recruiter/get-cities']);
$script = <<< JS
   $(document).on('change','#companymaster-state',function(){
        var state=$(this).val();
       $.ajax({
                method: 'GET',
                url: '$getCitiesUrl',
                data: {'id':state},
                success: function (response) {
                    $('#companymaster-city').html(response);
                }
            });
   });
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
