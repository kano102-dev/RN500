<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

$frontendDir = yii\helpers\Url::base(true);
?>
<style>
    .mb-15{margin-bottom: 15px;}
</style>
<div class="user-details-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'add-licenses'
    ]);
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'license_name')->dropDownList(Yii::$app->params['LICENSE_TYPE']); ?>
        </div>
    </div>
    <div class="row mb-15">
        <div class="col-sm-12">
            <label class="control-label" for="issuing_state">Issuing State</label>
            <ul class="optionlist">
                <?php
                $url = Url::to(['browse-jobs/get-cities']);
                $location = isset($_GET['location']) ? implode(',', $_GET['location']) : 0;
                echo Select2::widget([
                    'name' => 'issuing_state',
                    'options' => [
                        'id' => 'issuing_state',
                        'placeholder' => 'Select location...',
                        'multiple' => false,
                        'class' => '',
//                        'value' => isset($model->city) ? $model->city : [],
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
            <?= $form->field($model, 'license_number')->textInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'compact_states')->checkbox(); ?>
        </div>
    </div>
    <div class="row mb-15">
        <div class="col-sm-12">
            <?= $form->field($model, 'document')->fileInput() ?>

            <?php if ($deleteFlag) { ?>
            <a href="<?= $frontendDir."/uploads/user-details/document/".$model->document ?>" download><?= $model->document ?></a>
            <?php } ?>

        </div>
    </div>

    <div class="form-group">
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

  $(document).on("beforeSubmit", "#add-licenses", function () {
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