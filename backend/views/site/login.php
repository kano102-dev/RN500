<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$is_otp_sent = $model->is_otp_sent;
?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form', 'options' => ['autocomplete' => 'off']]) ?>

        <?php
        echo $form->field($model, 'username', [
                    'options' => ['class' => 'form-group has-feedback'],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group mb-3']
                ])
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username'),'readOnly'=>$is_otp_sent])
        ?>

        <?php
        echo $form->field($model, 'password', [
                    'options' => ['class' => 'form-group has-feedback'],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group mb-3']
                ])
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'readOnly'=>$is_otp_sent])
        ?>


        <?php
        if ($is_otp_sent) {
            echo "<p> We have sent any OTP to your registered email. </p>";
            echo $form->field($model, 'otp', [
                    'options' => ['class' => 'form-group has-feedback'],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group mb-3']
                ])
                ->label(false)
                ->textInput(['placeholder' => 'OTP']);
        }
        ?>


        <div class="row">
            <!--<div class="col-8">-->
            <?php
//                echo $form->field($model, 'rememberMe')->checkbox([
//                    'template' => '<div class="icheck-primary">{input}{label}</div>',
//                    'labelOptions' => [
//                        'class' => ''
//                    ],
//                    'uncheck' => null
//                ]) 
            ?>
            <!--</div>-->
            <div class="col-12">
                <?php echo Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>

        <!--        <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>-->
        <!-- /.social-auth-links -->

        <p class="mt-2">
            <a href="#">forgot password? </a>
        </p>
        <p class="mb-0">
            <!--            <a href="#" class="text-center">Register a new membership</a>-->
            <a href="#" class="text-center">Doesn't have a account</a>
        </p>
    </div>
    <!-- /.login-card-body -->
</div>