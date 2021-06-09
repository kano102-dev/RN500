<?php

use common\CommonFunction;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\LeadRecruiterJobSeekerMapping;
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

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab_pending">Pending</a></li>
                                <li><a data-toggle="tab" href="#tab_inprogress">In-Progress</a></li>
                                <li><a data-toggle="tab" href="#tab_selected">Selected</a></li>
                                <li><a data-toggle="tab" href="#tab_rejected">Rejected</a></li>
                            </ul>

                            <div class="tab-content">

                                <div id="tab_pending" class="tab-pane fade in active">
                                    <div class="table table-responsive">
                                        <?php Pjax::begin(['id' => 'pjx_lead_pending', 'timeout' => false]); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProviderPending,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn',
                                                    'headerOptions' => ['style' => 'width:5px']
                                                ],
                                                    [
                                                    'attribute' => 'leadTitleWithRef',
                                                    'format' => 'html',
                                                    'enableSorting' => false,
                                                ],
                                                    [
                                                    'attribute' => 'jobSeekerName',
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'value' => function($model) {
                                                        return Html::a($model->jobSeekerName, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $model->jobSeeker->details->unique_id]), ['data-pjax' => 0, 'target' => '_blank']);
                                                    }
                                                ],
                                                    [
                                                    'class' => 'yii\grid\ActionColumn',
                                                    'contentOptions' => ['style' => 'width:180px;'],
                                                    'header' => 'Actions',
                                                    'template' => '{approve} {reject}',
                                                    'buttons' => [
                                                        'approve' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_APPROVED]);
                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/recruiter-approval-form', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_APPROVED]);
                                                            return Html::a('Approve', 'javascript:void(0)', [
                                                                        'url' => $url,
                                                                        'modal-title' => 'Approve',
//                                                                        'onclick' => "doActionWithConfirmation('Are you sure, you want to approve this lead?','$url')",
                                                                        'data-pjax' => 0,
                                                                        'title' => Yii::t('app', 'Approve'),
                                                                        'class' => 'btn btn-theme-dark lead-approve',
                                                            ]);
                                                        },
                                                        'reject' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_REJECTED]);
                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/recruiter-approval-form', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_REJECTED]);
                                                            return Html::a('Reject', 'javascript:void(0)', [
                                                                        'url' => $url,
                                                                        'modal-title' => 'Reject',
//                                                                        'onclick' => "doActionWithConfirmation('Are you sure, you want to reject this lead?','$url')",
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
                                        <?php Pjax::end(); ?>
                                    </div>

                                </div>

                                <div id="tab_inprogress" class="tab-pane fade">
                                    <div class="table table-responsive">
                                        <?php Pjax::begin(['id' => 'pjx_lead_inprogress', 'timeout' => false]); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProviderInprogress,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn',
                                                    'headerOptions' => ['style' => 'width:5px']
                                                ],
                                                    [
                                                    'attribute' => 'leadTitleWithRef',
                                                    'format' => 'html',
                                                    'enableSorting' => false,
                                                ],
                                                    [
                                                    'attribute' => 'jobSeekerName',
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'value' => function($model) {
                                                        return Html::a(
                                                                        $model->jobSeekerName, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $model->jobSeeker->details->unique_id]), ['data-pjax' => 0, 'target' => '_blank']
                                                        );
                                                    }
                                                ],
//                                                    [
//                                                    'class' => 'yii\grid\ActionColumn',
//                                                    'contentOptions' => ['style' => 'width:180px;'],
//                                                    'header' => 'Actions',
//                                                    'template' => '{approve} {reject}',
//                                                    'buttons' => [
//                                                        'approve' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_APPROVED]);
//                                                            return Html::a('Approve', 'javascript:void(0)', [
//                                                                        'onclick' => "doActionWithConfirmation('Are you sure, you want to approve this lead?','$url')",
//                                                                        'data-pjax' => 0,
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class' => 'btn btn-theme-dark',
//                                                            ]);
//                                                        },
//                                                        'reject' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_REJECTED]);
//                                                            return Html::a('Reject', 'javascript:void(0)', [
//                                                                        'onclick' => "doActionWithConfirmation('Are you sure, you want to reject this lead?','$url')",
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
                                        <?php Pjax::end(); ?>
                                    </div>

                                </div>

                                <div id="tab_selected" class="tab-pane fade">
                                    <div class="table table-responsive">
                                        <?php Pjax::begin(['id' => 'pjx_lead_selected', 'timeout' => false]); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProviderSelected,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn',
                                                    'headerOptions' => ['style' => 'width:5px']
                                                ],
                                                    [
                                                    'attribute' => 'leadTitleWithRef',
                                                    'format' => 'html',
                                                    'enableSorting' => false,
                                                ],
                                                    [
                                                    'attribute' => 'jobSeekerName',
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'value' => function($model) {
                                                        return Html::a(
                                                                        $model->jobSeekerName, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $model->jobSeeker->details->unique_id]), ['data-pjax' => 0, 'target' => '_blank']
                                                        );
                                                    }
                                                ],
//                                                    [
//                                                    'class' => 'yii\grid\ActionColumn',
//                                                    'contentOptions' => ['style' => 'width:180px;'],
//                                                    'header' => 'Actions',
//                                                    'template' => '{approve} {reject}',
//                                                    'buttons' => [
//                                                        'approve' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_APPROVED]);
//                                                            return Html::a('Approve', 'javascript:void(0)', [
//                                                                        'onclick' => "doActionWithConfirmation('Are you sure, you want to approve this lead?','$url')",
//                                                                        'data-pjax' => 0,
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class' => 'btn btn-theme-dark',
//                                                            ]);
//                                                        },
//                                                        'reject' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_REJECTED]);
//                                                            return Html::a('Reject', 'javascript:void(0)', [
//                                                                        'onclick' => "doActionWithConfirmation('Are you sure, you want to reject this lead?','$url')",
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
                                        <?php Pjax::end(); ?>
                                    </div>
                                </div>

                                <div id="tab_rejected" class="tab-pane fade">
                                    <div class="table table-responsive">
                                        <?php Pjax::begin(['id' => 'pjx_lead_rejected', 'timeout' => false]); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProviderRejected,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn',
                                                    'headerOptions' => ['style' => 'width:5px']
                                                ],
                                                    [
                                                    'attribute' => 'leadTitleWithRef',
                                                    'format' => 'html',
                                                    'enableSorting' => false,
                                                ],
                                                    [
                                                    'attribute' => 'jobSeekerName',
                                                    'format' => 'raw',
                                                    'enableSorting' => false,
                                                    'value' => function($model) {
                                                        return Html::a(
                                                                        $model->jobSeekerName, Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $model->jobSeeker->details->unique_id]), ['data-pjax' => 0, 'target' => '_blank']
                                                        );
                                                    }
                                                ],
//                                                    [
//                                                    'class' => 'yii\grid\ActionColumn',
//                                                    'contentOptions' => ['style' => 'width:180px;'],
//                                                    'header' => 'Actions',
//                                                    'template' => '{approve} {reject}',
//                                                    'buttons' => [
//                                                        'approve' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_APPROVED]);
//                                                            return Html::a('Approve', 'javascript:void(0)', [
//                                                                        'onclick' => "doActionWithConfirmation('Are you sure, you want to approve this lead?','$url')",
//                                                                        'data-pjax' => 0,
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class' => 'btn btn-theme-dark',
//                                                            ]);
//                                                        },
//                                                        'reject' => function ($url, $model) {
//                                                            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/approval-from-recruiter', 'lrj' => $model->id, 'status' => LeadRecruiterJobSeekerMapping::STATUS_REJECTED]);
//                                                            return Html::a('Reject', 'javascript:void(0)', [
//                                                                        'onclick' => "doActionWithConfirmation('Are you sure, you want to reject this lead?','$url')",
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
                                        <?php Pjax::end(); ?>
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
    
    function doActionWithConfirmation(message,url){
        
        swal(message,{
            buttons: ["Cancel", "Yes!"],
        }).then((value) => {
            if(value){
                $('#overlay').show();
                $.ajax({
                    method: "POST",
                    url: url,
                }).done(function( res ) {
                    $('#overlay').hide();
                });
            }
        });
    }
JS;
$this->registerJS($script_new, 3);
?>