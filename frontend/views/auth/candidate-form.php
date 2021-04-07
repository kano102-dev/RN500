<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'candidate-form']) ?>
<div class="formrow">
    <?php
    echo $form->field($model, 'first_name', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}',
                'template' => '{input}{error}',
            ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('first_name')])
    ?>
</div>
<div class="formrow">
    <?php
    echo $form->field($model, 'last_name', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}',
                'template' => '{input}{error}',
            ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('last_name')])
    ?>
</div>
<div class="formrow">
    <?php
    echo $form->field($model, 'email', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}',
                'template' => '{input}{error}',
            ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')])
    ?>
</div>
<div class="formrow">
    <?php
    echo $form->field($model, 'password', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}',
                'template' => '{input}{error}',
            ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
    ?>
</div>
<div class="formrow">
    <?php
    echo $form->field($model, 'confirm_password', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}',
                'template' => '{input}{error}',
            ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('confirm_password')])
    ?>
</div>
<div class="formrow">
    <input type="checkbox" value="agree text" name="agree" />
    There are many variations of passages of Lorem Ipsum available</div>
<?php echo Html::submitButton('Register', ['class' => 'btn btn-primary btn-block']) ?>
<?php \yii\bootstrap4\ActiveForm::end(); ?>
