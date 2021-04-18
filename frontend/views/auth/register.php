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
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <div class="userbtns">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#candidate">Candidate</a></li>
                            <li><a data-toggle="tab" href="#employer">Employer</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="candidate" class="formpanel tab-pane fade in active">
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
                                        ->textInput(['placeholder' => $model->getAttributeLabel('email')])
                                ?>
                            </div>
                            <?php echo Html::submitButton('Register', ['class' => 'btn btn-primary btn-block']) ?>
                            <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        </div>
                        <div id="employer" class="formpanel tab-pane fade in">
                            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'employer-form']) ?>
                            <div><h3>Company Details</h3></div>
                            <hr/>
                            <?= Html::hiddenInput('type', 'employer') ?>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'company_name')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('company_name')])->label(false); ?>
                            </div>
                            <div class="formrow">
                                <?= $form->field($companyMasterModel, 'company_email')->textInput(['maxlength' => true, 'placeholder' => $companyMasterModel->getAttributeLabel('company_email')])->label(false); ?>
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
                                    'data' => [],
                                    'options' => ['placeholder' => 'Select a city'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label(false);
                                ?>
                            </div>
                            <div><h3>User Details</h3></div>
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
                                        ->textInput(['placeholder' => $employer->getAttributeLabel('email')])
                                ?>
                            </div>
                            <?php echo Html::submitButton('Register', ['class' => 'btn btn-primary btn-block']) ?>
                            <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        </div>
                    </div>
                    <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> Already a Member? <a href="<?= Yii::$app->urlManager->createUrl('auth/login'); ?>">Login Here</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$getCitiesUrl = Yii::$app->urlManager->createAbsoluteUrl(['auth/get-cities']);
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
