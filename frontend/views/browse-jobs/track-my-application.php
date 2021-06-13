<?php

use common\CommonFunction;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\LeadRecruiterJobSeekerMapping;
use kartik\icons\FontAwesomeAsset;
use kartik\rating\StarRating;

FontAwesomeAsset::register($this);
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
                        <?php Pjax::begin(['id' => 'pjx_my_application', 'timeout' => false, 'enablePushState' => false]); ?>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                    'attribute' => 'leadTitleWithRef',
                                    'format' => 'raw',
                                    'enableSorting' => false,
                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                ],
                                    [
                                    'attribute' => 'cityName',
                                    'enableSorting' => false,
                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                ],
                                    [
                                    'attribute' => 'recruiterComapnyWithBranch',
                                    'enableSorting' => false,
                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                ],
                                    [
                                    'attribute' => 'statusText',
                                    'enableSorting' => false,
                                    'filter' => Html::activeDropDownList($searchModel, 'statusText', LeadRecruiterJobSeekerMapping::getStatusList(), ['prompt' => 'All', 'class' => 'form-control']),
                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                ],
                                    [
                                    'attribute' => 'rating',
                                    'format' => 'raw',
                                    'enableSorting' => false,
//                                    'filter' => \kartik\rating\StarRating::widget(['model' => $searchModel, 'attribute' => 'rating',
//                                        'pluginOptions' => [
//                                            'theme' => 'krajee-uni',
//                                            'filledStar' => '&#x2605;',
//                                            'emptyStar' => '&#x2606;'
//                                ]]),
                                    'value' => function($model) {
                            
                                        return StarRating::widget([
                                                    'name' => 'rating',
                                                    'value' => $model->rating,
                                                    'pluginOptions' => [
                                                        'filledStar' => '&#x2605;',
                                                        'emptyStar' => '&#x2606;',
                                                        'showCaption' => false,
                                                        'showClear' => false
                                                    ],
                                                    'pluginEvents' => [
                                                        'rating:change' => "function(event, value, caption) {
                                                                setRatingTo('$model->lead_id',value);
                                                        }",
                                                    ],
                                        ]);
                                    },
                                    'filterInputOptions' => ['autocomplete' => 'off', 'class' => 'form-control'],
                                ],
//                                    [
//                                    'class' => 'yii\grid\ActionColumn',
//                                    'contentOptions' => ['style' => 'width:5%;'],
//                                    'header' => 'Actions',
//                                    'template' => '{proceed}',
//                                    'buttons' => [
//                                        //view button
//                                        'proceed' => function ($url, $model) use ($lead_id) {
//                                            if (!$model->is_already_applied) {
//                                                $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/apply-job', 'lead_id' => $lead_id, 'branch_id' => $model->id]);
//                                                return Html::a('Proceed', 'javascript:void(0)', [
//                                                            'onclick' => "applyToThisbranch('$url')",
//                                                            'data-pjax' => 0,
//                                                            'title' => Yii::t('app', 'Proceed'),
//                                                            'class' => 'btn btn-success',
//                                                ]);
//                                            } else {
//                                                return Html::a('Applied', 'javascript:void(0)', [
//                                                            'data-pjax' => 0,
//                                                            'title' => Yii::t('app', 'Applied'),
//                                                            'class' => 'btn btn-primary',
//                                                ]);
//                                            }
//                                        }
//                                    ],
//                                ],
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
$addRatingUrl = Yii::$app->urlManager->createAbsoluteUrl(['browse-jobs/set-rating']);
$script_new = <<<JS
    function setRatingTo(leadId,rating){
        $.ajax({
            method: "POST",
            url: '$addRatingUrl',
            data: {leadId:leadId, rating: rating}
        }).done(function( res ) {
            $.pjax.reload({container:'#pjx_my_application', timeout:false, async:false})
        });
    }
JS;
$this->registerJS($script_new, 1);
?>