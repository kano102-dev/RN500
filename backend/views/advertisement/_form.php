<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */
/* @var $form yii\widgets\ActiveForm */
$status = [1 => 'Yes', 2 => 'No'];
$url = Url::to(['advertisement/get-cities']);
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

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
                        <?php
                        echo $form->field($model, 'active_from')->widget(DatePicker::classname(), [
                            'name' => 'active_from',
                            'value' => date('d-M-Y'),
                            'options' => ['placeholder' => 'Enter Start Date'],
                            'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'startDate' => date('d-m-Y'),
                                'minDate' => "0"
                            ],
                            'pluginEvents' => [
                                "changeDate" => "function(e) {
                                $('#advertisement-active_to').kvDatepicker({
                                                    autoclose : true,
                                                    format : 'dd-mm-yyyy'
                                                });
                                                $('#advertisement-active_to').kvDatepicker('setStartDate', e.date);
                            }"
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-6 custom-time-data-picker">
                        <?php
                        echo $form->field($model, 'active_to')->widget(DatePicker::classname(), [
                            'name' => 'active_to',
                            'value' => date('d-M-Y'),
                            'options' => ['placeholder' => 'Enter End Date'],
                            'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'minDate' => "0"
                            ],
                            'pluginEvents' => [
                                "changeDate" => "function(e) {
                                
                                $('#advertisement-active_from').kvDatepicker({
                                                    autoclose : true,
                                                    format : 'dd-mm-yyyy',
                                                    minDate : '0'
                                                });
                                                $('#advertisement-active_from').kvDatepicker('setEndDate', e.date);
                            }"
                            ]
                        ]);
                        ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <?php echo $form->field($model, 'is_active')->dropDownList($status) ?>
                    </div>
                    <div class="col-lg-6">
                        <?php
                        echo $form->field($model, 'location')->widget(Select2::classname(), [
                            'data' => $data,
                            'options' => ['multiple' => false, 'placeholder' => 'Search for a city ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 3,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $url,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) {return {q:params.term, page:params.page || 1}; }'),
                                    'cache' => true,
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) {return markup; }'),
                                'templateResult' => new JsExpression('function(location) {return "<b>"+location.text+"</b>"; }'),
                                'templateSelection' => new JsExpression('function (location) {return location.text; }'),
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">


                        <?=
                        $form->field($model, 'file_type')->radioList([1 => 'Image', 2 => 'Youtube Url'], [
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
                            <?php
                            echo $form->field($model, 'icon')->fileInput()->label(false);
                            echo "<input type='hidden' id='image' name='image' value='" .$model->icon . "'>";
                            ?>
                            <?php if (isset($model->icon) && !empty($model->icon)) { ?>
                                <p><?php echo $model->icon; ?></p>
                            <?php } ?>
                            <a href="#" style="display:none" class="image_file">Remove file</a>   
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
                swal("at the time only 1 file selected!");
            }
        } else {
            if(image == ""){
                $('.image').hide();
                $('.video').show();
            } else {
                $("#type_1").prop("checked",true);
                swal("at the time only 1 file selected!");
            }
        }
   });
        
        $(document).on('change','#advertisement-icon',function(){
            var value = $(this).val();
        
            if(value != ""){
                $('.image_file').show();
            }
        });
        
        $(document).on('click','.image_file',function(){
            $('#advertisement-icon').val('');
            $('.image_file').hide();
        });
        
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>        




