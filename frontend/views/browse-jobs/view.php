<?php

use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use common\CommonFunction;
use yii\helpers\Url;
use yii\web\JsExpression;

$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
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
                </div>
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
                    </div>
                </div>
                <!-- Job Description end --> 

                <!-- related jobs start -->
                <!--                <div class="relatedJobs">
                                    <h3>Related Jobs</h3>
                                    <ul class="searchList">
                                         Job start 
                                        <li>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8">
                                                    <div class="jobimg"><img src="images/jobs/jobimg.jpg" alt="Job Name"></div>
                                                    <div class="jobinfo">
                                                        <h3><a href="#.">Technical Database Engineer</a></h3>
                                                        <div class="companyName"><a href="#.">Datebase Management Company</a></div>
                                                        <div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="listbtn"><a href="#.">Apply Now</a></div>
                                                </div>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis.</p>
                                        </li>
                                         Job end  
                
                                         Job start 
                                        <li>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8">
                                                    <div class="jobimg"><img src="images/jobs/jobimg.jpg" alt="Job Name"></div>
                                                    <div class="jobinfo">
                                                        <h3><a href="#.">Technical Database Engineer</a></h3>
                                                        <div class="companyName"><a href="#.">Datebase Management Company</a></div>
                                                        <div class="location"><label class="partTime">Part Time</label>   - <span>New York</span></div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="listbtn"><a href="#.">Apply Now</a></div>
                                                </div>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis.</p>
                                        </li>
                                         Job end  
                
                                         Job start 
                                        <li>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8">
                                                    <div class="jobimg"><img src="images/jobs/jobimg.jpg" alt="Job Name"></div>
                                                    <div class="jobinfo">
                                                        <h3><a href="#.">Technical Database Engineer</a></h3>
                                                        <div class="companyName"><a href="#.">Datebase Management Company</a></div>
                                                        <div class="location"><label class="freelance">Freelance</label>   - <span>New York</span></div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="listbtn"><a href="#.">Apply Now</a></div>
                                                </div>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu est. Phasellus vel dignissim tellus. Aenean fermentum fermentum convallis.</p>
                                        </li>
                                         Job end 
                                    </ul>
                                </div>-->
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
    </div>
</div>
