<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetails */
/* @var $form yii\widgets\ActiveForm */
$frontendDir = yii\helpers\Url::base(true);
?>

<div class="user-details-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'add-certification-new'
    ]);
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'certificate_name')->dropDownList(Yii::$app->params['CERTIFICATION_TYPE']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'certification_active')->radioList([1 => 'Yes', 2 => 'No']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 expiry_date" style="display:none;">
            <?php
            echo $form->field($model, 'expiry_date')->widget(DatePicker::classname(), [
                'name' => 'expiry_date',
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
            <?= $form->field($model, 'issue_by')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label" for="city">Issuing State</label>
            <ul class="optionlist">
                <?php
                $url = Url::to(['browse-jobs/get-cities']);
                $location = isset($_GET['location']) ? implode(',', $_GET['location']) : 0;
                echo Select2::widget([
                    'name' => 'issuing_state',
                    'options' => [
                        'id' => 'issuing_state',
                        'placeholder' => 'Select Location...',
                        'multiple' => false,
                        'class' => '',
                        'value' => isset($model->issuing_state) ? $model->issuing_state : [],
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'ajax' => [
                            'url' => $url,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) {return {q:params.term, page:params.page || 1}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(location) { console.log(location);return location.name; }'),
                        'templateSelection' => new JsExpression('function (location) {return location.name; }'),
                    ],
                ]);
                ?>
            </ul>
        </div>
    </div>
    <div class="row">
        
        <div class="col-sm-12">
            <p>&nbsp;</p>
            <?= $form->field($model, 'document')->fileInput() ?>
            <?php if ($deleteFlag) { ?>
                <a href="<?= $frontendDir . "/uploads/user-details/certification/" . $model->document ?>" download><?= $model->document ?></a>
                <p>&nbsp;</p>
            <?php } ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
  var is_active = '$model->certification_active';

  if(is_active == '1'){
      $('.expiry_date').show();
  } 
        
  var click = 0;      
  $(document).on("beforeSubmit", "#add-certification-new", function () {
    if(click == 0){
        ++click;    
        var form = $(this);
        var formData = new FormData(form[0]);    
         $.ajax({
             url    : form.attr('action'),
             type   : 'post',
             dataType : 'json',
             data   : formData,
             processData: false,
             contentType: false,
             success: function (response){
//                console.log(response);
                 try{
                     if(!response.error){
                         $("#commonModal").modal('hide');
                         $.pjax.reload({container: "#job-seeker", timeout: false});
                         $(document).on("pjax:success", "#job-seeker", function (event) {
                             $.pjax.reload({'container': '#res-messages', timeout: false});
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
        
   $(document).on('click','#certifications-certification_active input',function(){
//       console.log($(this).val());
        var value = $(this).val();
        
        if(value == '1'){
            $('.expiry_date').show();
        } else {
             $('.expiry_date').hide();
        }
   });     
      
        
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>
