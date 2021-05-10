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
        <div class="col-sm-12">
            <?= $form->field($model, 'path')->fileInput()->label('document') ?>
            <?php if ($deleteFlag) { ?>
                <p><?= $model->path ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="form-group">
        <?php if ($deleteFlag) { ?>
            <a href="#" class="delete-documents" data-document="document" style="color: red;font-weight: bold;float: right;text-decoration: none">Delete Documents</a>
        <?php } ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$DeleteUrl = '';

if ($deleteFlag) {
    $DeleteUrl = Yii::$app->urlManager->createUrl(['user-details/delete-document?id='. $model->id]);
}

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
     
  $(document).on('click','.delete-documents',function(){
      var document = $(this).data('document');  
        
      swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete this Document !",
            icon: "warning",
            buttons: [
              'No, cancel it!',
              'Yes, I am sure!'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
              $.post("$DeleteUrl", {document: document}, function(result){
                    if(result){
                         $("#profile-modal").modal('hide');
                         $.pjax.reload({container: "#job-seeker", timeout: 2000});
                         $(document).on("pjax:success", "#job-seeker", function (event) {
                             $.pjax.reload({'container': '#res-messages', timeout: 2000});
                         });
                    }
                }); 
            }
          })
  });       
        
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>
