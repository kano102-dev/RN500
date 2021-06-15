<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
?>


<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">

            <!--            <form class="form-inline" >
            
                            <div class="form-group mb-2">
                                <label for="inputPassword2" class="sr-only">Password</label>
                                <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
                            </div>
                            
                            <div class="form-group mx-sm-3 mb-2">
                                <button type="submit" class="btn btn-primary mb-2">Confirm identity</button>
                                <button class="btn btn-primary mb-2" id="btn-export"> Export </button>
                            </div>
                            
                        </form>-->

            <?php // $form = ActiveForm::begin(['id' => 'referral_form', 'options' => ['autocomplete' => 'off'], 'layout' => 'horizontal', 'class' => 'form-horizontal',   ]); ?>



            <!--            <div class="row">
                            <div class="col-md-12 mb-3">
                                            
            <?php // echo $form->field($filterFormModel, 'from_Date')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>-->



            <!--            <div class="row">
                            <div class="col-md-12 mb-3">
            <?php // echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>                        
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>-->

            <?php // ActiveForm::end(); ?>

            <button class="btn btn-primary mb-2 float-right" id="btn-export"> Export </button>

            <div class="table table-responsive pt-3">

                <table class="table table-striped table-bordered" id="tbl_lead_referral">
                    <tr>
                        <th> Sr. No </th>
                        <th> Lead With Reference</th>
                        <th> Sender Name </th>
                        <th> Sender Email </th>
                        <th> Recipient Name </th>
                        <th> Recipient Name </th>
                    </tr>
                    <?php foreach ($models as $sr => $model) { ?>
                        <tr>
                            <td> <?php echo ++$sr ?></td>
                            <td> <?php echo $model->leadTitleWithRef ?></td>
                            <td> <?php echo $model->from_name ?></td>
                            <td> <?php echo $model->from_email ?></td>
                            <td> <?php echo $model->to_name ?></td>
                            <td> <?php echo $model->to_email ?></td>
                        </tr>
                    <?php } ?>
                </table>

            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<?php
$file_name = 'lead_referral_' . date('Y-m-d') . '.xls';
$script_new = <<<JS
        
$("#btn-export").click(function() {
    $("#tbl_lead_referral").table2excel({
        exclude: ".excludeThisClass",
        name: "Worksheet Name",
        filename: "$file_name", // do include extension
        preserveColors: false // set to true if you want background colors and font colors preserved
    })
})
JS;
$this->registerJS($script_new, 3);
?>

