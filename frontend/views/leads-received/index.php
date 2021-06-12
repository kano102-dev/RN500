<?php

use common\CommonFunction;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\LeadRecruiterJobSeekerMapping;
use kartik\date\DatePicker;
?>
<style>
    .tab-container-custom  ul li{
        padding: 0px !important;
    }
    .tab-container-custom ul li:before{
        content: '' !important;
    }
    .btn-theme-dark, .btn-theme-dark:hover, .btn-theme-dark:focus{
        background: #263bd6;
        color: white;
    }
    .btn-secondary, .btn-secondary:hover, .btn-secondary:focus{
        background-color:gray;
        color: white;
    }

</style>
<!-- Page Title start -->
<div class="pageTitle">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h1 class="page-heading">Job Detail</h1>
            </div>
        </div>
    </div>
</div>
<!-- Page Title End -->


<div class="listpgWraper">
    <div class="container"> 

        <!-- Job Detail start -->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Job Description start -->
                <div class="job-header">
                    <div class="contentbox">

                        <div class="tab-container-custom">

                            <ul class="nav nav-tabs" id="leadsTab">
                                <li class="active"><a data-toggle="tab" href="#tab_pending" onClick="reload('pjx_pending')">Pending</a></li>
                                <li><a data-toggle="tab" href="#tab_inprogress" onClick="reload('pjx_inprogress')">In-Progress</a></li>
                                <li><a data-toggle="tab" href="#tab_selected" onClick="reload('pjx_selected')">Selected</a></li>
                                <li><a data-toggle="tab" href="#tab_rejected" onClick="reload('pjx_rejected')">Rejected</a></li>
                            </ul>

                            <div class="tab-content">

                                <div id="tab_pending" class="tab-pane fade in active">
                                    <div class="table table-responsive">

                                        <?php Pjax::begin(['id' => 'pjx_pending', 'timeout' => false, 'enablePushState' => false]); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProviderPending,
                                            'id' => 'grdvw_pending',
                                            'filterModel' => $searchModelPending,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn',
                                                    'headerOptions' => ['style' => 'width:5px']
                                                ],
                                                    [
                                                    'attribute' => 'leadTitleWithRef',
                                                    'value' => function($model) {
                                                        return Html::a($model->leadTitleWithRef, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/browse-jobs/recruiter-view', 'id' => $model->lead_id]), ['data-pjax' => '0', 'target' => '_blank']);
                                                    },
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                ],
                                                    [
                                                    'attribute' => 'jobSeekerName',
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'value' => function($model) {
                                                        return Html::a($model->jobSeekerName, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $model->jobSeeker->details->unique_id]), ['data-pjax' => 0, 'target' => '_blank']);
                                                    }
                                                ],
                                                    [
                                                    'attribute' => 'rec_joining_date',
                                                    'visible' => CommonFunction::isEmployer(),
                                                    'headerOptions' => ['style' => 'width:15%'],
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                    'value' => function($model) {
                                                        return ($model->rec_joining_date != '') ? date("d-M-Y", strtotime($model->rec_joining_date)) : '';
                                                    },
                                                    'filter' => DatePicker::widget([
                                                        'attribute' => 'rec_joining_date',
                                                        'model' => $searchModelPending,
                                                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'dd-M-yyyy',
                                                        ]
                                                    ])
                                                ],
                                                    [
                                                    'attribute' => 'cityName',
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                ],
                                                    [
                                                    'class' => 'yii\grid\ActionColumn',
                                                    'contentOptions' => ['style' => 'width:180px;'],
                                                    'header' => 'Actions',
                                                    'template' => '{approve} {reject}',
                                                    'buttons' => [
                                                        'approve' => function ($url, $model) {
                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['leads-received/approval-form', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_APPROVED]);
                                                            return Html::a('Approve', 'javascript:void(0)', [
                                                                        'url' => $url,
                                                                        'modal-title' => 'Approve',
                                                                        'data-pjax' => 0,
                                                                        'title' => Yii::t('app', 'Approve'),
                                                                        'class' => 'btn btn-theme-dark lead-approve',
                                                            ]);
                                                        },
                                                        'reject' => function ($url, $model) {
                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['leads-received/approval-form', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_REJECTED]);
                                                            return Html::a('Reject', 'javascript:void(0)', [
                                                                        'url' => $url,
                                                                        'modal-title' => 'Reject',
                                                                        'data-pjax' => 0,
                                                                        'title' => Yii::t('app', 'Reject'),
                                                                        'class' => 'btn btn-danger lead-reject',
                                                            ]);
                                                        }
                                                    ],
                                                ],
                                            ],
                                        ]);
                                        ?>

                                        <?php Pjax::end() ?>

                                    </div>

                                </div>

                                <div id="tab_inprogress" class="tab-pane fade">
                                    <div class="table table-responsive">
                                        <?php Pjax::begin(['id' => 'pjx_inprogress', 'timeout' => false, 'enablePushState' => false]); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProviderInprogress,
                                            'id' => 'grdvw_inprogress',
                                            'filterModel' => $searchModelInprogress,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn',
                                                    'headerOptions' => ['style' => 'width:5px']
                                                ],
                                                    [
                                                    'attribute' => 'leadTitleWithRef',
                                                    'value' => function($model) {
                                                        return Html::a($model->leadTitleWithRef, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/browse-jobs/recruiter-view', 'id' => $model->lead_id]), ['data-pjax' => '0', 'target' => '_blank']);
                                                    },
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                ],
                                                    [
                                                    'attribute' => 'jobSeekerName',
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'value' => function($model) {
                                                        return Html::a($model->jobSeekerName, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $model->jobSeeker->details->unique_id]), ['data-pjax' => 0, 'target' => '_blank']);
                                                    }
                                                ],
                                                    [
                                                    'attribute' => 'rec_joining_date',
                                                    'visible' => CommonFunction::isRecruiter(),
                                                    'headerOptions' => ['style' => 'width:15%'],
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                    'value' => function($model) {
                                                        return ($model->rec_joining_date != '') ? date("d-M-Y", strtotime($model->rec_joining_date)) : '';
                                                    },
                                                    'filter' => DatePicker::widget([
                                                        'attribute' => 'rec_joining_date',
                                                        'model' => $searchModelInprogress,
                                                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                                        'pluginOptions' => [
                                                            'id' => 'rec_joining_inprogress',
                                                            'name' => 'rec_joining_inprogress',
                                                            'autoclose' => true,
                                                            'format' => 'dd-M-yyyy',
                                                        ]
                                                    ])
                                                ],
                                                    [
                                                    'attribute' => 'cityName',
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                ],
//                                                    [
//                                                    'class' => 'yii\grid\ActionColumn',
//                                                    'contentOptions' => ['style' => 'width:180px;'],
//                                                    'header' => 'Actions',
//                                                    'template' => '{approve} {reject}',
//                                                    'buttons' => [
//                                                        'approve' => function ($url, $model) {
//                                                            return Html::a('Approve', 'javascript:void(0)', [
//                                                                        'data-pjax' => 0,
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class' => 'btn btn-theme-dark',
//                                                            ]);
//                                                        },
//                                                        'reject' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_REJECTED]);
//                                                            return Html::a('Reject', 'javascript:void(0)', [
//                                                                        'data-pjax' => 0,
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class' => 'btn btn-danger',
//                                                            ]);
//                                                        }
//                                                    ],
//                                                ],
                                            ],
                                        ]);
                                        ?>
                                        <?php Pjax::end() ?>

                                    </div>

                                </div>

                                <div id="tab_selected" class="tab-pane fade">
                                    <div class="table table-responsive">
                                        <?php Pjax::begin(['id' => 'pjx_selected', 'timeout' => false, 'enablePushState' => false]); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProviderSelected,
                                            'filterModel' => $searchModelSelected,
                                            'id' => 'grdvw_selected',
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn',
                                                    'headerOptions' => ['style' => 'width:5px']
                                                ],
                                                    [
                                                    'attribute' => 'leadTitleWithRef',
                                                    'value' => function($model) {
                                                        return Html::a($model->leadTitleWithRef, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/browse-jobs/recruiter-view', 'id' => $model->lead_id]), ['data-pjax' => '0', 'target' => '_blank']);
                                                    },
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                ],
                                                    [
                                                    'attribute' => 'rec_joining_date',
                                                    'format' => 'html',
                                                    'headerOptions' => ['style' => 'width:15%'],
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                    'value' => function($model) {
                                                        return ($model->rec_joining_date != '') ? date("d-M-Y", strtotime($model->rec_joining_date)) : '';
                                                    },
                                                    'filter' => DatePicker::widget([
                                                        'attribute' => 'rec_joining_date_selected',
                                                        'model' => $searchModelSelected,
                                                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'dd-M-yyyy',
                                                        ]
                                                    ])
                                                ],
                                                    [
                                                    'attribute' => 'jobSeekerName',
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'value' => function($model) {
                                                        return Html::a($model->jobSeekerName, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $model->jobSeeker->details->unique_id]), ['data-pjax' => 0, 'target' => '_blank']);
                                                    }
                                                ],
                                                    [
                                                    'attribute' => 'cityName',
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                ],
//                                                    [
//                                                    'class' => 'yii\grid\ActionColumn',
//                                                    'contentOptions' => ['style' => 'width:180px;'],
//                                                    'header' => 'Actions',
//                                                    'template' => '{approve} {reject}',
//                                                    'buttons' => [
//                                                        'approve' => function ($url, $model) {
//                                                            return Html::a('Approve', 'javascript:void(0)', [
//                                                                        'data-pjax' => 0,
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class' => 'btn btn-theme-dark',
//                                                            ]);
//                                                        },
//                                                        'reject' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_REJECTED]);
//                                                            return Html::a('Reject', 'javascript:void(0)', [
//                                                                        'data-pjax' => 0,
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class' => 'btn btn-danger',
//                                                            ]);
//                                                        }
//                                                    ],
//                                                ],
                                            ],
                                        ]);
                                        ?>

                                        <?php Pjax::end() ?>

                                    </div>
                                </div>

                                <div id="tab_rejected" class="tab-pane fade">
                                    <div class="table table-responsive">
                                        <?php Pjax::begin(['id' => 'pjx_rejected', 'timeout' => false, 'enablePushState' => false]); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProviderRejected,
                                            'filterModel' => $searchModelRejected,
                                            'id' => 'grdvw_rejected',
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn',
                                                    'headerOptions' => ['style' => 'width:5px']
                                                ],
                                                    [
                                                    'attribute' => 'leadTitleWithRef',
                                                    'value' => function($model) {
                                                        return Html::a($model->leadTitleWithRef, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/browse-jobs/recruiter-view', 'id' => $model->lead_id]), ['data-pjax' => '0', 'target' => '_blank']);
                                                    },
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                ],
                                                    [
                                                    'attribute' => 'jobSeekerName',
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'value' => function($model) {
                                                        return Html::a($model->jobSeekerName, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $model->jobSeeker->details->unique_id]), ['data-pjax' => 0, 'target' => '_blank']);
                                                    }
                                                ],
                                                    [
                                                    'attribute' => 'cityName',
                                                    'enableSorting' => false,
                                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                                ],
//                                                    [
//                                                    'class' => 'yii\grid\ActionColumn',
//                                                    'contentOptions' => ['style' => 'width:180px;'],
//                                                    'header' => 'Actions',
//                                                    'template' => '{approve} {reject}',
//                                                    'buttons' => [
//                                                        'approve' => function ($url, $model) {
//                                                            return Html::a('Approve', 'javascript:void(0)', [
//                                                                        'data-pjax' => 0,
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class' => 'btn btn-theme-dark',
//                                                            ]);
//                                                        },
//                                                        'reject' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_REJECTED]);
//                                                            return Html::a('Reject', 'javascript:void(0)', [
//                                                                        'data-pjax' => 0,
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class' => 'btn btn-danger',
//                                                            ]);
//                                                        }
//                                                    ],
//                                                ],
                                            ],
                                        ]);
                                        ?>
                                        <?php Pjax::end() ?>

                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$script_new = <<<JS
    
    $(document).on("click", ".lead-approve, .lead-reject", function() {
        $(".modal-title").text($(this).attr('modal-title'));
        $("#commonModal").modal('show').find("#modalContent").load($(this).attr('url'));
        
    });
    
    function reload(id){
            $.pjax.reload({container:'#'+id, timeout:false, async:false});
    }
 
JS;
$this->registerJS($script_new, 3);
?>