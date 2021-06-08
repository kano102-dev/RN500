<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use borales\extensions\phoneInput\PhoneInput;
?>
<style>
    .nav-tabs{
        display:inline-flex;
    }
    .nav-tabs li{
        margin-right: 10px;
        list-style-type:none;
    }    
</style>
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <div class="userbtns">
                        <ul class="nav nav-tabs">
                            <li class="<?= (isset($tab) && empty($tab)) ? 'active' : '' ?>"><a data-toggle="tab" href="#candidate">Jobseeker</a></li>
                            <li class="<?= (isset($tab) && !empty($tab) && $tab == 'employer') ? 'active' : '' ?>"><a data-toggle="tab" href="#employer">Employer</a></li>
                            <li class="<?= (isset($tab) && !empty($tab) && $tab == 'recruiter') ? 'active' : '' ?>"><a data-toggle="tab" href="#recruiter">Recruiter</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="candidate" class="formpanel tab-pane fade in <?= isset($tab) && empty($tab) ? 'active' : '' ?>">
                            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'candidate-form']) ?>
                            <?= Html::hiddenInput('type', 'candidate') ?>
                            <div class="formrow">
                                <?php
                                echo $form->field($model, 'first_name', [
                                            'options' => ['class' => 'form-group has-feedback'],
                                            'inputTemplate' => '{input}',
                                            'template' => '{input}{error}',
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => $model->getAttributeLabel('first_name')])
                                ?>
                            </div>
                            <div class="formrow">
                                <?php
                                echo $form->field($model, 'last_name', [
                                            'options' => ['class' => 'form-group has-feedback'],
                                            'inputTemplate' => '{input}',
                                            'template' => '{input}{error}',
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => $model->getAttributeLabel('last_name')])
                                ?>
                            </div>
                            <div class="formrow">
                                <?php
                                echo $form->field($model, 'email', [
                                            'options' => ['class' => 'form-group has-feedback'],
                                            'inputTemplate' => '{input}',
                                            'template' => '{input}{error}',
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => 'Email Id'])
                                ?>
                            </div>
                            <?php echo Html::submitButton('Register', ['class' => 'btn btn-primary btn-block']) ?>
                            <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        </div>
                        <div id="employer" class="formpanel tab-pane fade in <?= isset($tab) && !empty($tab) && $tab == 'employer' ? 'active' : '' ?>">
                            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'employer-form']) ?>
                            <div><h3>Company Details</h3></div>
                            <hr/>
                            <?= Html::hiddenInput('type', 'employer') ?>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'company_name')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('company_name')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'company_email')->textInput(['maxlength' => true, 'placeholder' => 'Email Id'])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?=
                                $form->field($companyMasterModel, 'company_mobile')->widget(PhoneInput::className(), [
                                    'jsOptions' => [
                                        'preferredCountries' => ['us', 'in'],
                                    ]
                                ])->label(false);
                                ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'employer_identification_number')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('employer_identification_number')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'website_link')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('website_link')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'street_no')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('street_no')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'street_address')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('street_address')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'apt')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('apt')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?=
                                $form->field($companyMasterModel, 'state')->widget(Select2::classname(), [
                                    'data' => $states,
                                    'options' => ['placeholder' => 'Select a province'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label(false);
                                ?>
                            </div>
                            <div class="formrow">
                                <?=
                                $form->field($companyMasterModel, 'city')->widget(Select2::classname(), [
                                    'data' => $cities,
                                    'options' => ['placeholder' => 'Select a city'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label(false);
                                ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'zip_code')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('zip_code')])->label(false); ?>
                            </div>
                            <div><h3>Company Owner Details</h3></div>
                            <hr/>
                            <div class="formrow">
                                <?php
                                echo $form->field($employer, 'first_name', [
                                            'options' => ['class' => 'form-group has-feedback'],
                                            'inputTemplate' => '{input}',
                                            'template' => '{input}{error}',
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => $employer->getAttributeLabel('first_name')])
                                ?>
                            </div>
                            <div class="formrow">
                                <?php
                                echo $form->field($employer, 'last_name', [
                                            'options' => ['class' => 'form-group has-feedback'],
                                            'inputTemplate' => '{input}',
                                            'template' => '{input}{error}',
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => $employer->getAttributeLabel('last_name')])
                                ?>
                            </div>
                            <div class="formrow">
                                <?php
                                echo $form->field($employer, 'email', [
                                            'options' => ['class' => 'form-group has-feedback'],
                                            'inputTemplate' => '{input}',
                                            'template' => '{input}{error}',
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => 'Email Id'])
                                ?>
                            </div>
                            <?php echo Html::submitButton('Register', ['class' => 'btn btn-primary btn-block']) ?>
                            <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        </div>
                        <div id="recruiter" class="formpanel tab-pane fade in <?= isset($tab) && !empty($tab) && $tab == 'recruiter' ? 'active' : '' ?>">
                            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'recruiter-form']) ?>
                            <div><h3>Company Details</h3></div>
                            <hr/>
                            <?= Html::hiddenInput('type', 'recruiter') ?>
                            <div class="formrow">
                                <?= $form->field($recruiterCompany, 'company_name')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('company_name')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($recruiterCompany, 'company_email')->textInput(['maxlength' => true, 'placeholder' => 'Email Id'])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?=
                                $form->field($recruiterCompany, 'mobile')->widget(PhoneInput::className(), [
                                    'jsOptions' => [
                                        'preferredCountries' => ['us', 'in'],
                                    ]
                                ])->label(false);
                                ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($recruiterCompany, 'employer_identification_number')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('employer_identification_number')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($recruiterCompany, 'website_link')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('website_link')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($recruiterCompany, 'street_no')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('street_no')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($recruiterCompany, 'street_address')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('street_address')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($recruiterCompany, 'apt')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('apt')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?=
                                $form->field($recruiterCompany, 'state')->widget(Select2::classname(), [
                                    'data' => $states,
                                    'options' => ['placeholder' => 'Select a province'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label(false);
                                ?>
                            </div>
                            <div class="formrow">
                                <?=
                                $form->field($recruiterCompany, 'city')->widget(Select2::classname(), [
                                    'data' => $cities,
                                    'options' => ['placeholder' => 'Select a city'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label(false);
                                ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($recruiterCompany, 'zip_code')->textInput(['maxlength' => true, 'placeholder' => $recruiterCompany->getAttributeLabel('zip_code')])->label(false); ?>
                            </div>
                            <div><h3>Company Owner Details</h3></div>
                            <hr/>
                            <div class="formrow">
                                <?php
                                echo $form->field($recruiter, 'first_name', [
                                            'options' => ['class' => 'form-group has-feedback'],
                                            'inputTemplate' => '{input}',
                                            'template' => '{input}{error}',
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => $recruiter->getAttributeLabel('first_name')])
                                ?>
                            </div>
                            <div class="formrow">
                                <?php
                                echo $form->field($recruiter, 'last_name', [
                                            'options' => ['class' => 'form-group has-feedback'],
                                            'inputTemplate' => '{input}',
                                            'template' => '{input}{error}',
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => $recruiter->getAttributeLabel('last_name')])
                                ?>
                            </div>
                            <div class="formrow">
                                <?php
                                echo $form->field($recruiter, 'email', [
                                            'options' => ['class' => 'form-group has-feedback'],
                                            'inputTemplate' => '{input}',
                                            'template' => '{input}{error}',
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => 'Email Id'])
                                ?>
                            </div>
                            <?php echo Html::submitButton('Register', ['class' => 'btn btn-primary btn-block']) ?>
                            <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        </div>
                    </div>
                    <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> Already a Member? <a href="<?= Yii::$app->urlManagerFrontend->createUrl('auth/login'); ?>">Login Here</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$getCitiesUrl = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['auth/get-cities']);
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
   $(document).on('change','#recruitercompanyform-state',function(){
        var state=$(this).val();
       $.ajax({
                method: 'GET',
                url: '$getCitiesUrl',
                data: {'id':state},
                success: function (response) {
                    $('#recruitercompanyform-city').html(response);
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
