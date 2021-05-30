<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model common\models\Vendor */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Vendor';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? "Create" : "Update";
?>


<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="card ">

            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">
                        <?=
                        $form->field($model, 'phone')->widget(PhoneInput::className(), [
                            'jsOptions' => [
                                'preferredCountries' => ['us', 'in'],
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'street_no')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">
                        <?= $form->field($model, 'street_address')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'apt')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
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
                    <div class="col-6">
                        <?=
                        $form->field($model, 'city')->widget(Select2::classname(), [
                            'data' => [],
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
                        <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="form-group text">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$getCitiesUrl = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['vendor/get-cities']);
$script = <<< JS
   $(document).on('change','#vendor-state',function(){
        var state=$(this).val();
       $.ajax({
                method: 'GET',
                url: '$getCitiesUrl',
                data: {'id':state},
                success: function (response) {
                    $('#vendor-city').html(response);
                }
            });
   });
  
JS;
$this->registerJs($script);
