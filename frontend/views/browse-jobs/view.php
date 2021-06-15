<?php

use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use common\CommonFunction;
use yii\helpers\Url;
use yii\web\JsExpression;

$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
$frontendDir = Yii::$app->urlManagerFrontend->getBaseUrl() . "/uploads/advertisement/";
?>

<style>
    /*.social-share {display:flex;margin: 25px 0px;}*/
    .social-share li{padding: 0px 5px;}
    .social-share {padding:20px 0px 20px 25px}
    .job-header .contentbox p{text-align: justify !important;}

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

        <!-- Job Header start -->
        <div class="job-header">
            <div class="jobinfo">
                <div class="row">
                    <div class="col-md-8">
                        <h2><?= $model->title ?></h2>
                        <div class="ptext">Date Posted: <?= date('m-d-Y', $model->created_at) ?></div>
                        <div class="ptext"><?= $model->citiesName ?></div>
                        <div class="salary">Salary: <strong>$<?= $model->jobseeker_payment ?>/<?= Yii::$app->params['job.payment_type'][$model->payment_type] ?></strong></div>
                    </div>
                </div>
            </div>
            <div class='row'>
                <?php if (CommonFunction::isJobSeeker()) { ?>
                    <div class='col-md-2'>
                        <div class="jobButtons"> 
                            <a href="<?php echo Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/apply', 'ref' => $model->reference_no]) ?>" class="btn apply"><i class="fa fa-paper-plane" aria-hidden="true"></i> Apply Now</a>                        
                        </div>
                    </div>
                    <div class='col-md-5'>
                        <?=
                        \ymaker\social\share\widgets\SocialShare::widget([
                            'configurator' => 'socialShare',
                            'url' => Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/view', 'id' => $model->id]),
                            'title' => $model->title,
                            'description' => $model->description,
                            'imageUrl' => "$assetDir/images/RN500_logo177X53.png",
                        ]);
                        ?>
                        <a href="javascript:void(0)" data-url="<?php echo Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/refer-to-friend', 'lead_id' => $model->id]) ?>" class="refer-to-friend" modal-title="Refer To Friend"><i class="fa fa-share-alt-square" aria-hidden="true" style="font-size: 27px;"></i></a>
                    </div>
                <?php } else { ?>
                    <div class='col-md-12'>
                        <?=
                        \ymaker\social\share\widgets\SocialShare::widget([
                            'configurator' => 'socialShare',
                            'url' => Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/view', 'id' => $model->id]),
                            'title' => $model->title,
                            'description' => $model->description,
                            'imageUrl' => "$assetDir/images/RN500_logo177X53.png",
                        ]);
                        ?>
                        <a href="javascript:void(0)" data-url="<?php echo Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/refer-to-friend', 'lead_id' => $model->id]) ?>" class="refer-to-friend" modal-title="Refer To Friend"><i class="fa fa-share-alt-square" aria-hidden="true" style="font-size: 27px;"></i></a>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Job Detail start -->
        <div class="row">
            <div class="col-md-8"> 
                <!-- Job Description start -->
                <div class="job-header">
                    <div class="contentbox">
                        <h3>Job Description</h3>
                        <p><?= $model->description ?></p>
                        <?php if (isset($benefit) && !empty($benefit)) { ?>
                            <h3>Benifits</h3>
                            <ul>
                                <?php foreach ($benefit as $value) { ?>
                                    <li><?= $value->benefit->name ?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        <?php if (isset($discipline) && !empty($discipline)) { ?>
                            <h3>Discipline</h3>
                            <ul>
                                <?php foreach ($discipline as $value) { ?>
                                    <li><?= $value->discipline->name ?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        <?php if (isset($specialty) && !empty($specialty)) { ?>
                            <h3>Specialty</h3>
                            <ul>
                                <?php foreach ($specialty as $value) { ?>
                                    <li><?= $value->speciality->name ?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        <?php if (isset($emergency) && !empty($emergency)) { ?>
                            <h3>Emergency</h3>
                            <ul>
                                <?php foreach ($emergency as $value) { ?>
                                    <li><?= $value->emergency->name ?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
                <!-- Job Description end --> 
            </div>
            <!-- related jobs end -->

            <div class="col-md-4"> 
                <!-- Job Detail start -->
                <div class="job-header">
                    <div class="jobdetail">
                        <h3>Job Detail</h3>
                        <ul class="jbdetail">
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Job Id</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->reference_no ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Location</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->citiesName ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Employment Status</div>
                                <div class="col-md-6 col-xs-6"> <span><?= Yii::$app->params['job.type'][$model->job_type] ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Shift</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->shift == 1 ? "Morning, Evening, Night, Flatulate" : Yii::$app->params['job.shift'][$model->shift] ?></span></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- How it Works start -->
                <div class="section howitwrap">
                    <div class="container"> 
                        <div class="row">
                            <?php
                            $i = 0;
                            if (isset($advertisment) && !empty($advertisment)) {
                                ?>
                                <?php foreach ($advertisment as $key => $value) { ?>
                                    <div class="col-md-4 col-sm-6 col-xl-12 moreFTypeBox blogFTypeBox" <?php if ($i >= 3) { ?> style="display:none;" <?php } ?>>
                                        <?php if (isset($value['icon']) && !empty($value['icon'])) { ?>
                                            <?php if (file_exists(Yii::getAlias('@frontend') . "/web/uploads/advertisement/" . $value['icon'])) { ?>
                                                <a href="<?= $value['link_url'] ?>" target="_blank"><img height="250px" width="350px" src="<?= $frontendDir . $value['icon'] ?>"></a>
                                            <?php } ?>
                                            <?php
                                        } else {
                                            if (isset($value['video_link']) && !empty($value['video_link'])) {
                                                ?>
                                                <video width="350" height="250" controls>
                                                    <source src="<?= $value['video_link'] ?>">
                                                </video>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <p><?= $value['name'] ?></p>
                                        <p>&nbsp;</p>
                                    </div>
                                    <?php
                                    $i++;
                                }
                                ?>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center" id="viewFTypeMore">
                                <p>&nbsp;</p>

                                <?php if (isset($advertisment) && !empty($advertisment)) { ?>
                                    <?php if (count($advertisment) > 3) { ?>
                                        <a href="#" class="wp_view_more btn btn-info">View More</a>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- How it Works Ends --> 
            </div>
        </div>
    </div>
</div>

<?php
$script_new = <<<JS
    $(document).on("click", ".refer-to-friend", function() {
        $("#commonModal").find(".modal-title").text($(this).attr('modal-title'));
        $("#commonModal").modal('show').find("#modalContent").load($(this).attr('data-url'));

    });

    function reload(id){
        $.pjax.reload({container:'#'+id, timeout:false, async:false});
    }
JS;
$this->registerJS($script_new, 3);
?>

