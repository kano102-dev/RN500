<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

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
        <div class="col-sm-12">
            <?= $form->field($model, 'document')->fileInput() ?>
            <?php if ($deleteFlag) { ?>
                <a href="<?= $frontendDir."/uploads/user-details/certification/".$model->document ?>" download><?= $model->document ?></a>
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
                         $("#profile-modal").modal('hide');
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
