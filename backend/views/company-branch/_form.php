<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var companyBranchModel backend\models\CompanyBranch */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Branch';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $companyBranchModel->isNewRecord ? "Create" : "Update";
?>
<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Branch Detail</h3>
                </div>
                <div class="card-body">
                    <?php if (\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) { ?>
                        <div class="row">
                            <div class="col-12">
                                <?=
                                $form->field($companyBranchModel, 'company_id')->widget(Select2::classname(), [
                                    'data' => $companyList,
                                    'options' => ['placeholder' => 'Select a Company'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($companyBranchModel, 'branch_name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($companyBranchModel, 'street_no')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($companyBranchModel, 'street_address')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($companyBranchModel, 'apt')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?=
                            $form->field($companyBranchModel, 'state')->widget(Select2::classname(), [
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
                            $form->field($companyBranchModel, 'city')->widget(Select2::classname(), [
                                'data' => $branch_cities,
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
                            <?= $form->field($companyBranchModel, 'zip_code')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Branch Owner Details</h3>
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
                                'data' => $owner_cities,
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
            <div class="form-group text text-center">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$getCitiesUrl = Yii::$app->urlManager->createAbsoluteUrl(['company-branch/get-cities']);
$script = <<< JS
    $(document).on('change','#companybranch-state',function(){
        var state=$(this).val();
        if(state){
            $.ajax({
                method: 'GET',
                url: '$getCitiesUrl',
                data: {'id':state},
                success: function (response) {
                    $('#companybranch-city').html(response);
                }
            });
        }else{
            $('#companybranch-city').html("");
            $('#companybranch-city').val("");
        }
    });
        
    $(document).on('change','#userdetails-state',function(){
        var state=$(this).val();
        if(state){
            $.ajax({
                method: 'GET',
                url: '$getCitiesUrl',
                data: {'id':state},
                success: function (response) {
                    $('#userdetails-city').html(response);
                }
            });
        }else{
            $('#userdetails-city').html("");
            $('#userdetails-city').val("");
        }
    });
JS;
$this->registerJs($script);
