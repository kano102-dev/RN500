<?php

//use Yii;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use common\CommonFunction;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!-- Page Title start -->
<!--<div class="pageTitle">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <h1 class="page-heading">Post Job</h1>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="breadCrumb"><a href="#.">Home</a> / <span>Post Job</span></div>
      </div>
    </div>
  </div>
</div>-->
<!-- Page Title End -->

<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="userccount">
                    <div class="formpanel"> 

                        <!-- Job Information -->
                        <h5>Job Information</h5>
                        <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['autocomplete' => 'off']]) ?>
                        <?php if (CommonFunction::isLoggedInUserDefaultBranch()) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="formrow">
                                        <?php
                                        echo $form->field($model, 'branch_id')->widget(Select2::classname(), [
                                            'data' => $branchList,
                                            'options' => ['placeholder' => $model->getAttributeLabel('branch_id')],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label(false);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="formrow">
                                    <?php
                                    echo $form->field($model, 'disciplines')->widget(Select2::classname(), [
                                        'data' => $disciplinesList,
                                        'options' => ['placeholder' => $model->getAttributeLabel('disciplines'), 'multiple' => true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label(false);
                                    ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="formrow">
                                    <?php
                                    echo $form->field($model, 'benefits')->widget(Select2::classname(), [
                                        'data' => $benefitList,
                                        'options' => ['placeholder' => $model->getAttributeLabel('benefits'), 'multiple' => true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label(false);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formrow">
                                    <?php
                                    echo $form->field($model, 'specialies')->widget(Select2::classname(), [
                                        'data' => $specialiesList,
                                        'options' => ['placeholder' => $model->getAttributeLabel('specialies'), 'multiple' => true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label(false);
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="formrow">
                                    <?php
                                    echo $form->field($model, 'jobseeker_payment', [
                                                'options' => ['class' => 'form-group has-feedback'],
                                                'inputTemplate' => '{input}',
                                                'template' => '{input}{error}',
                                            ])
                                            ->label(false)
                                            ->textInput(['placeholder' => $model->getAttributeLabel('jobseeker_payment')]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formrow">
                                    <?php
                                    echo $form->field($model, 'payment_type', [
                                                'options' => ['class' => 'form-group has-feedback'],
                                                'inputTemplate' => '{input}',
                                                'template' => '{input}{error}',
                                            ])
                                            ->label(false)
                                            ->dropdownList(Yii::$app->params['job.payment_type'], ['class' => 'form-control', 'prompt' => $model->getAttributeLabel('payment_type')]);
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="formrow">
                                    <?php
                                    echo $form->field($model, 'job_type', [
                                                'options' => ['class' => 'form-group has-feedback'],
                                                'inputTemplate' => '{input}',
                                                'template' => '{input}{error}',
                                            ])
                                            ->label(false)
                                            ->dropdownList(Yii::$app->params['job.type'], ['class' => 'form-control', 'prompt' => $model->getAttributeLabel('job_type')]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formrow">
                                    <?php
                                    echo $form->field($model, 'shift', [
                                                'options' => ['class' => 'form-group has-feedback'],
                                                'inputTemplate' => '{input}',
                                                'template' => '{input}{error}',
                                            ])
                                            ->label(false)
                                            ->dropdownList(Yii::$app->params['job.shift'], ['class' => 'form-control', 'prompt' => $model->getAttributeLabel('shift')]);
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                            <div class="col-md-12">
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

                        <br>
                        <input type="submit" class="btn" value="Post Job">

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
