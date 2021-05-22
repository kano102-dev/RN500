<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */
/* @var $form yii\widgets\ActiveForm */
$location = [1 => 'Home Page'];
$status = [0 => 'No', 1 => 'Yes'];
?>

<div class="advertisement-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">

                    <?=
                    $form->field($model, 'vendor_id')->widget(Select2::classname(), [
                        'data' => $vendor,
                        'options' => ['placeholder' => 'Select a Vendor'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-lg-6">

                    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">

                    <?php echo $form->field($model, 'link_url')->label('Website Url'); ?>
                </div>
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'description')->textarea(['rows' => '2']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'active_from')->textInput(["type" => "date"]) ?>
                </div>
                <div class="col-md-6 custom-time-data-picker">
                    <?= $form->field($model, 'active_to')->textInput(["type" => "date"]) ?>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6 custom-time-data-picker">
                    <?php echo $form->field($model, 'location_display')->dropDownList($location, ['prompt' => 'Select Display Location']) ?>
                </div>   
                <div class="col-lg-6">
                    <?php echo $form->field($model, 'is_active')->dropDownList($status, ['prompt' => 'Select Status']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    

                    <?=
                    $form->field($model, 'file_type')->radioList([1 => 'Image', 2 => 'Video Link'], [
                        'item' => function($index, $label, $name, $checked, $value) {

                            return "<label>
                                <input type='radio'
                                       name='{$name}' 
                                       value='{$value}'
                                       id='type_{$value}'>
                                {$label}</label>";
                        }
                    ])
                    ?>
                    <div class="image" style="<?= isset($model->icon) && !empty($model->icon) ? "" : "display: none" ?>">
                        <?php echo $form->field($model, 'icon')->fileInput()->label(false); ?>
                        <?php if (isset($model->icon) && !empty($model->icon)) { ?>
                            <p><?php echo $model->icon; ?></p>
                        <?php } ?> 
                    </div>

                    <div class="video" style="<?= isset($model->video_link) && !empty($model->video_link) ? "" : "display: none" ?>">
                        <?php echo $form->field($model, 'video_link')->label(false); ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
    
   
   var imageFile = '$model->icon';  
   var videoFile = '$model->video_link';
       
   if(imageFile != ""){
       $("#type_1").prop("checked",true);
   }
       
   if(videoFile != ""){
       $("#type_2").prop("checked",true);
   }     
    
   $(document).on('click','#advertisement-file_type input',function(){
        var value = $(this).val();
        var image = $('#advertisement-icon').val();
        var video = $('#advertisement-video_link').val();
        if(value == '1'){
            if(video == ""){
                $('.image').show();
                $('.video').hide();
            } else {
                $("#type_2").attr('checked', 'checked');
                alert('at the time only 1 file selected!');
            }
        } else {
            if(image == ""){
                $('.image').hide();
                $('.video').show();
            } else {
                $("#type_1").prop("checked",true);
                alert('at the time only 1 file selected!');
            }
        }
   });
        
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>        




