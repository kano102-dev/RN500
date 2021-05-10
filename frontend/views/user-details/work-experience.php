<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-details-form">
    <?php $form = ActiveForm::begin([
        "id" => "work-experience",
    ]); ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'discipline_id')->dropDownList($discipline); ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'specialty')->dropDownList($speciality); ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'employment_type')->dropDownList(Yii::$app->params['EMPLOYEMENT_TYPE']); ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'currently_working')->checkbox(['id' => 'currently_working']); ?>
        </div>
        <div class="col-sm-12">
            <?php
            echo $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                'name' => 'start_date',
                'value' => date('d-M-Y'),
                'options' => ['placeholder' => 'Enter Start Date'],
                'pluginOptions' => [
                    'format' => 'mm-yyyy',
                    'todayHighlight' => true,
                    'autoclose' => true,
//                            'startDate' => date('d-m-Y'),
                    'minViewMode' => 'months',
                    'startView' => 'year',
                ],
                'pluginEvents' => [
                    "changeDate" => "function(e) {

                            }"
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-12">
            <?php
            echo $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                'name' => 'end_date',
                'value' => date('d-M-Y'),
                'options' => ['placeholder' => 'Enter End Date'],
                'pluginOptions' => [
                    'format' => 'mm-yyyy',
                    'todayHighlight' => true,
                    'autoclose' => true,
                    'startDate' => date('d-m-Y'),
                    'minViewMode' => 'months',
                    'startView' => 'year',
                ],
                'pluginEvents' => [
                    "changeDate" => "function(e) {

                            }"
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'facility_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
        
  $('.field-currently_working input').change(function() {
        if($(this).is(":checked")) {
            $('#workexperience-end_date').attr('disabled',true);
        } else {
            $('#workexperience-end_date').attr('disabled',false);
        }        
    });
        
  $(document).on("beforeSubmit", "#work-experience", function () {
    var form = $(this);
         $.ajax({
             url    : form.attr('action'),
             type   : 'post',
             dataType : 'json',
             data   : form.serialize(),
             success: function (response){
                 try{
                     if(!response.error){
                         $("#profile-modal").modal('hide');
                         $.pjax.reload({container: "#job-seeker", timeout: 2000});
                         $(document).on("pjax:success", "#job-seeker", function (event) {
                             $.pjax.reload({'container': '#res-messages', timeout: 2000});
                         });
                     }
                 }catch(e){
                     $.pjax.reload({'container': '#res-messages', timeout: 2000});
                 }
             },
             error  : function () 
             {
                 console.log('internal server error');
             }
         });
         return false;
 });      
        
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>        




