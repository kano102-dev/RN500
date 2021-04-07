<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$is_otp_sent = $model->is_otp_sent;
?>
<style>
    .invalid-feedback{
        padding-top: 8px;
        color:red;
    }
</style>
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <!--<div class="socialLogin">-->
<!--                        <h5>Login Or Register with Social</h5>
                        <a href="#." class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a> 
                        <a href="#." class="gp"><i class="fa fa-google-plus" aria-hidden="true"></i></a> 
                        <a href="#." class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a> -->
                    <!--</div>-->
                    <h5>User Login</h5>
                    <!-- login form -->
                    <div class="formpanel">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form', 'options' => ['autocomplete' => 'off']]) ?>
                        <div class="formrow">
                            <?php
                            echo $form->field($model, 'username', [
                                        'options' => ['class' => 'form-group has-feedback'],
                                        'inputTemplate' => '{input}',
                                        'template' => '{input}{error}',
                                    ])
                                    ->label(false)
                                    ->textInput(['placeholder' => $model->getAttributeLabel('username'), 'readOnly' => $is_otp_sent])
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
                                    ->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'readOnly' => $is_otp_sent])
                            ?>
                        </div>
                        <div class="formrow">
                            <?php
                            if ($is_otp_sent) {
                                echo "<p> We have sent an OTP to your registered email. </p>";
                                echo $form->field($model, 'otp', [
                                            'options' => ['class' => 'form-group']
                                        ])
                                        ->label(false)
                                        ->textInput(['placeholder' => 'OTP']);
                            }
                            ?>

                        </div>
                        <?php echo Html::submitButton('Login', ['class' => 'btn btn-primary btn-block']) ?>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                    <!-- login form  end--> 
                    <!-- sign up form -->
                    <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> New User? <a href="<?= Yii::$app->urlManager->createUrl('/auth/register'); ?>">Register Here</a></div>
                    <!-- sign up form end--> 

                </div>
            </div>
        </div>
    </div>
</div>