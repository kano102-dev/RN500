<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
?>
<style>
    .mb-15{margin-bottom: 15px;}
</style>
<div class="user-details-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'add-education-new'
    ]);
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'institution')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row mb-15">
        <div class="col-sm-12">
            <label class="control-label" for="city">Location</label>
            <ul class="optionlist">
                <?php
                $url = Url::to(['browse-jobs/get-cities']);
                echo Select2::widget([
                    'name' => 'location',
                    'value' => isset($model->location) && !empty($model->location) ? $model->location : '',
                    'data' => $selectedLocations,
                    'options' => [
                        'id' => 'select_city',
                        'placeholder' => 'Select City...',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'ajax' => [
                            'url' => $url,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) {return {q:params.term, page:params.page || 1}; }'),
                            'cache' => true,
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) {return markup; }'),
                        'templateResult' => new JsExpression('function(location) {return "<b>"+location.name+"</b>"; }'),
                        'templateSelection' => new JsExpression('function (location) {
                                if(location.selected==true){
                                    return location.text; 
                                }else{
                                    return location.name;
                                }
                            }'),
                    ],
                ]);
                ?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
            echo $form->field($model, 'year_complete')->widget(DatePicker::classname(), [
                'name' => 'year_complete',
                'value' => date('d-M-Y'),
                'options' => ['placeholder' => 'Enter Year..'],
                'pluginOptions' => [
                    'format' => 'mm-yyyy',
                    'todayHighlight' => true,
                    'autoclose' => true,
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
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'degree_name')->dropDownList(Yii::$app->params['DEGREE_TYPE'], ['prompt' => 'Select Degree']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
  var click=0;      
  $(document).on("beforeSubmit", "#add-education-new", function () {
    if(click==0){
        ++click;
        var form = $(this);
             $.ajax({
                 url    : form.attr('action'),
                 type   : 'post',
                 dataType : 'json',
                 data   : form.serialize(),
                 success: function (response){
                    console.log(response);
                     try{
                         if(!response.error){
                             $("#commonModal").modal('hide');
                             $.pjax.reload({container: "#job-seeker", timeout: 2000});
                             $(document).on("pjax:success", "#job-seeker", function (event) {
                                 $.pjax.reload({'container': '#res-messages', timeout: 2000});
                             });
                             getProfilePercentage();
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
      }
 });      
        
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>