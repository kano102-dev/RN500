<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
                            <?= $form->field($companyMasterModel, 'company_mobile')->textInput(['maxlength' => true]) ?>
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
                            <?= $form->field($companyMasterModel, 'city')->dropDownList($cities, ['prompt' => 'Select', 'class'=>'form-control']) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($companyMasterModel, 'zip_code')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>



            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">User</h3>
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
                            <?= $form->field($userDetailModel, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($userDetailModel, 'mobile_no')->textInput(['maxlength' => true]) ?>
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
                            <?= $form->field($userDetailModel, 'city')->dropDownList($cities, ['prompt' => 'Select', 'class'=>'form-control']) ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($userDetailModel, 'zip_code')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
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
