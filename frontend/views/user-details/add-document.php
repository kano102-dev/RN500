<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-details-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'add-document'
    ]);
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'document_type')->dropDownList([0 => 'Resume', 1 => 'Other']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'path')->fileInput()->label('document') ?>
            <?php if ($deleteFlag) { ?>
                <p><?= $model->path ?></p>
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

  $(document).on("beforeSubmit", "#add-document", function () {
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
 });
     
 
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>
