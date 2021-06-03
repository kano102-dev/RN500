<?php

use common\CommonFunction;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

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
                        <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute'=>'branch_name',
                                    'enableSorting'=>false
                                    ],
                                'company_name',
                                    [
                                    'class' => 'yii\grid\ActionColumn',
                                    'contentOptions' => ['style' => 'width:5%;'],
                                    'header' => 'Actions',
                                    'template' => '{proceed}',
                                    'buttons' => [
                                        //view button
                                        'proceed' => function ($url, $model) use ($lead_id) {
//                                            echo "<span class='jobButtons'>";
                                            $url = Yii::$app->urlManager->createAbsoluteUrl(['browse-jobs/apply-job', 'lead_id' => $lead_id, 'branch_id' => $model->id]);
                                            return Html::a('Proceed', 'javascript:void(0)', [
                                                        'onclick' => "applyToThisbranch('$url')",
                                                        'data-pjax' => 0,
                                                        'title' => Yii::t('app', 'View'),
                                                        'class' => 'btn btn-success',
                                            ]);
//                                            echo "</span>";
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
        
        swal("Are you sure, you want to proceed.",{
            buttons: ["Cancel", "Yes!"],
        }).then((value) => {
            if(value){
                $.ajax({
                    method: "POST",
                    url: url,
                }).done(function( res ) {});
            }
        });
    }
JS;
$this->registerJS($script_new, 3);
?>