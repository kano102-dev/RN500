<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'RN500';
?>
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <p>Please choose your new password:</p>
                    <!-- login form -->
                    <div class="formpanel">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'reset-password-form']); ?>
                        <div class="formrow">
                            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
                        </div>
                        <div class="formrow">
                            <?= $form->field($model, 'confirm_password')->passwordInput() ?>
                        </div>
                        <?php echo Html::submitButton('Save', ['class' => 'btn btn-primary btn-block']) ?>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>