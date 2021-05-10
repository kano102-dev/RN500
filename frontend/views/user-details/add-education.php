<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>

<div class="user-details-form">
<?php $form = ActiveForm::begin([
    'id' => 'add-education'
]); ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'institution')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>
        </div>
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
            <?= $form->field($model, 'degree_name')->dropDownList(Yii::$app->params['DEGREE_TYPE']) ?>
        </div>        
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS

  $(document).on("beforeSubmit", "#add-education", function () {
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