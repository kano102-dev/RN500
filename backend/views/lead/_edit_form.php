<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;

$form = ActiveForm::begin(['id' => 'edit-lead-form',
            'options' => ['autocomplete' => 'off']
        ]);
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="formrow">
            <?php
            echo $form->field($model, 'title', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}',
                        'template' => '{input}{error}',
                    ])
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('title'), 'maxlength' => true]);
            ?>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="formrow">
            <?php
            echo $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => $model->getAttributeLabel('start_date')],
                'pluginOptions' => [
                    'autoclose' => true,
                       'format' => Yii::$app->params['date.format.datepicker.js'],
                ]
            ])->label(false);
            ?>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="formrow">
            <?php
            echo $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => $model->getAttributeLabel('end_date')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => Yii::$app->params['date.format.datepicker.js'],
                ]
            ])->label(false);
            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="formrow">
            <?php
            echo $form->field($model, 'description', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}',
                        'template' => '{input}{error}',
                    ])
                    ->label(false)
                    ->textarea(['placeholder' => $model->getAttributeLabel('description')]);
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::button('Cancel', ['class' => 'btn btn-secondary', 'id' => "close", 'data-dismiss' => "modal"]) ?>
    <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>