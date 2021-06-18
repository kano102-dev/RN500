<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'payment_form',
                        'options' => ['autocomplete' => 'off'],
                        'class' => 'form-horizontal',
                        'action' => Url::to(['report/payment-load'], true)
            ]);
            ?>

            <div class="row">
                <div class="col-12 col-sm-3">
                    <?php
                    echo $form->field($filterFormModel, 'from_date')->widget(DatePicker::className(), [
                        'attribute' => 'from_date',
                        'model' => $filterFormModel,
                        'readonly' => true,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-M-yyyy',
                            'startDate' => date('d-M-Y', strtotime('-4 months')),
                            'endDate' => date('d-M-Y')
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-12 col-sm-3">
                    <?php
                    echo $form->field($filterFormModel, 'to_date')->widget(DatePicker::className(), [
                        'attribute' => 'to_date',
                        'model' => $filterFormModel,
                        'readonly' => true,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-M-yyyy',
                            'startDate' => date('d-M-Y', strtotime('-4 months')),
                            'endDate' => date('d-M-Y')
                        ]
                    ]);
                    ?>
                </div>

                <div class="col-6 col-sm-2">
                    <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary mt-4']) ?>
                </div>
                <div class="col-6 col-sm-4">
                    <button class="btn btn-secondary mb-2 float-right  mt-4" id="btn-export"> Export </button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <hr/>

            <div class="table table-responsive pt-3 report-result-height" >
                <table class="table table-striped table-bordered" id="tbl_payment" >

                </table>
            </div>
        </div>
    </div>
</div>

<?php
$file_name = 'lead_referral_' . date('Y-m-d') . '.xls';

$script_new = <<<JS
    $("#btn-export").click(function() {
        $("#tbl_payment").table2excel({
            exclude: ".excludeThisClass",
            name: "Worksheet Name",
            filename: "$file_name", // do include extension
            preserveColors: true // set to true if you want background colors and font colors preserved
        })
    })

    $(document).off('submit').on('submit','form#payment_form',function(e){
        e.preventDefault();
        e.returnValue = false;
        var form = $(this);
        if (form.find('.has-error').length > 0) { 
            return false;
        } else {
            $.post(form.attr('action'), form.serialize(), function(data) {
                $('#tbl_payment').html(data);
            }).always(function() {
            });
        }
    })
    $('form#payment_form').submit();
JS;
$this->registerJS($script_new, 3);
?>

