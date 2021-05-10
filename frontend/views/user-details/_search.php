<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'unique_id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'mobile_no') ?>

    <?php // echo $form->field($model, 'street_no') ?>

    <?php // echo $form->field($model, 'street_address') ?>

    <?php // echo $form->field($model, 'apt') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'zip_code') ?>

    <?php // echo $form->field($model, 'profile_pic') ?>

    <?php // echo $form->field($model, 'current_position') ?>

    <?php // echo $form->field($model, 'speciality') ?>

    <?php // echo $form->field($model, 'looking_for') ?>

    <?php // echo $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'work experience') ?>

    <?php // echo $form->field($model, 'job_title') ?>

    <?php // echo $form->field($model, 'job_looking_from') ?>

    <?php // echo $form->field($model, 'travel_preference') ?>

    <?php // echo $form->field($model, 'ssn') ?>

    <?php // echo $form->field($model, 'work_authorization') ?>

    <?php // echo $form->field($model, 'work_authorization_comment') ?>

    <?php // echo $form->field($model, 'license_suspended') ?>

    <?php // echo $form->field($model, 'professional_liability') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
