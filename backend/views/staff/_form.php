<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use borales\extensions\phoneInput\PhoneInput;

$this->title = 'Staff';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $userDetailModel->isNewRecord ? "Create" : "Update";
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <?php $form = ActiveForm::begin(['id' => 'form_staff_signup', 'options' => []]); ?>


        <div class="col-md-12 col-sm-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">User</h3>
                </div>

                <div class="card-body">
                    <?php if (\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id) || \common\CommonFunction::isHoAdmin(Yii::$app->user->identity->id)) { ?>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <?=
                                $form->field($userDetailModel, 'company_id')->widget(Select2::classname(), [
                                    'data' => $companyList,
                                    'options' => ['placeholder' => 'Select a Company'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <?=
                                $form->field($userDetailModel, 'branch_id')->widget(Select2::classname(), [
                                    'data' => $branchList,
                                    'options' => ['placeholder' => 'Select a Branch'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <?= $form->field($userDetailModel, 'first_name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <?= $form->field($userDetailModel, 'last_name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6 col-sm-12">
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
                        <div class="col-md-6 col-sm-12">
                            <?= $form->field($userDetailModel, 'street_no')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <?= $form->field($userDetailModel, 'street_address')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <?= $form->field($userDetailModel, 'apt')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6 col-sm-12">
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

                        <div class="col-md-6 col-sm-12">
                            <?=
                            $form->field($userDetailModel, 'city')->widget(Select2::classname(), [
                                'data' => $city,
                                'options' => ['placeholder' => 'Select a city'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <?= $form->field($userDetailModel, 'zip_code')->textInput(['maxlength' => 5]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <?php if (\common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) { ?>
                            <div class="col-6">
                                <?=
                                $form->field($userDetailModel, 'role_id')->widget(Select2::classname(), [
                                    'data' => $roles,
                                    'options' => ['placeholder' => 'Select a Role'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-6">
                                <?=
                                $form->field($userDetailModel, 'role_id')->widget(Select2::classname(), [
                                    'data' => $roles,
                                    'options' => ['placeholder' => 'Select a Role'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                        <?php } ?>
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
$getCitiesUrl = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['staff/get-cities']);
$getBranchUrl = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['staff/get-branches']);
$getRolesUrl = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['company-branch/get-roles']);
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
   $(document).on('change','#userdetails-company_id',function(){
        var company=$(this).val();
       $.ajax({
                method: 'GET',
                url: '$getBranchUrl',
                data: {'id':company},
                success: function (response) {
                    $('#userdetails-branch_id').html(response);
                }
        });
   });
        $(document).on('change','#userdetails-company_id',function(){
        var cid=$(this).val();
        if(cid){
            $.ajax({
                method: 'GET',
                url: '$getRolesUrl',
                data: {'id':cid},
                success: function (response) {
                    $('#userdetails-role_id').html(response);
                }
            });
        }else{
            $('#userdetails-role_id').html("");
            $('#userdetails-role_id').val("");
        }
    });
JS;
$this->registerJs($script);
