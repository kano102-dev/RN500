<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'RN500';
?>
<div class="card">
    <div class="card-body login-card-body">
        <p>Please choose your new password:</p>
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
        <div class="row">
            <div class="col-12">
                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?= $form->field($model, 'confirm_password')->passwordInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php echo Html::submitButton('Save', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?> 
    </div>
</div>
