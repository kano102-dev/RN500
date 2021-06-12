<?php

use common\CommonFunction;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\LeadRecruiterJobSeekerMapping;

$lead_id = $model->id;
?>
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
                        <?php Pjax::begin(); ?>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                'company_name',
                                    [
                                    'attribute' => 'branch_name',
                                    'enableSorting' => false
                                ],
                                    [
                                    'class' => 'yii\grid\ActionColumn',
                                    'contentOptions' => ['style' => 'width:5%;'],
                                    'header' => 'Actions',
                                    'template' => '{proceed}',
                                    'buttons' => [
                                        //view button
                                        'proceed' => function ($url, $model) use ($lead_id) {
                                            if (!LeadRecruiterJobSeekerMapping::checkAlreadyApplied($lead_id, $model->id, Yii::$app->user->identity->id)) {
                                                $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/apply-job', 'lead_id' => $lead_id, 'branch_id' => $model->id]);
                                                return Html::a('Proceed', 'javascript:void(0)', [
                                                            'onclick' => "applyToThisbranch('$url')",
                                                            'data-pjax' => 0,
                                                            'title' => Yii::t('app', 'Proceed'),
                                                            'class' => 'btn btn-success',
                                                ]);
                                            } else {
                                                return Html::a('Applied', 'javascript:void(0)', [
                                                            'data-pjax' => 0,
                                                            'title' => Yii::t('app', 'Applied'),
                                                            'class' => 'btn btn-primary',
                                                ]);
                                            }
                                        }
                                    ],
                                ],
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

<?php
$script_new = <<<JS
    function applyToThisbranch(url){
        
        swal("Are you sure, you want to apply this job?",{
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