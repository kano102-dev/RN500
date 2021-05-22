<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'RN500';
?>


<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <h5>Password Reset</h5>
                    <!-- login form -->
                    <div class="formpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'options' => ['autocomplete' => 'off']]) ?>

                                <div class="formrow">
                                    <?php
                                    echo $form->field($model, 'password', [
                                        'options' => ['class' => 'form-group has-feedback', 'autofocus' => true,],
                                        'inputTemplate' => '{input}',
                                        'template' => '{input}{error}',
                                    ])->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password'),])
                                    ?>
                                </div>
                                
                                <div class="formrow">
                                    <?php
                                    echo $form->field($model, 'confirm_password', [
                                        'options' => ['class' => 'form-group has-feedback', 'autofocus' => true,],
                                        'inputTemplate' => '{input}',
                                        'template' => '{input}{error}',
                                    ])->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('confirm_password'),])
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                            <div class="newuser"><i class="fa fa-lock" aria-hidden="true"></i> <a href="<?= Yii::$app->urlManager->createUrl('/auth/login'); ?>">Click here to login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>