<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use common\CommonFunction;
use yii\widgets\Pjax;
use yii\web\View;

Pjax::begin(['id' => 'res-messages', 'timeout' => false]);
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    $temp_key = explode("_", $key);
    $key = $temp_key[0];
    $scripta = <<< JS
 toastr.$key("$message","",{timeOut:5000,progressBar:true,preventDuplicates:false});
JS;
    $this->registerJs($scripta);
}
Pjax::end()
?>

<style>
    .top-content{position: absolute;top: 20px;right: 30px;}
    .top-content p{font-size: 15px;font-weight: 600;color: black;}

    @media (max-width:767px){
        .top-content{display: none}
    }
</style>

<div class="header">
    <!--<div class="top-content"><p>One million success stories. Start yours today.</p></div>-->
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-12"> <a href="<?= Yii::$app->urlManager->createUrl("/"); ?>" class="logo"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="RN500" /></a>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-10 col-sm-12 col-xs-12"> 
                <!-- Nav start -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-collapse collapse" id="nav-main">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="<?= Yii::$app->urlManager->createUrl("/"); ?>">Home</a> 
                            </li>
                            <li><a href="">About us</a></li>
                            <li><a href="">Contact</a></li>
                            <?php if (!empty(Yii::$app->user->identity)) { ?> 
                                <?php if (Yii::$app->user->identity->type == \common\models\User::TYPE_JOB_SEEKER) { ?>
                                    <li><a href="<?= Yii::$app->urlManager->createUrl("site/job-seeker"); ?>">Job Seeker</a></li>
                                <?php } else { ?>
                                    <li><a href="<?= Yii::$app->urlManager->createUrl(["user-details/profile", 'id' => Yii::$app->user->id]); ?>">Profile</a></li>
                                <?php } ?>
                            <?php } ?>
                            <li><a href="<?= Yii::$app->urlManager->createUrl("browse-jobs"); ?>">Browse Jobs</a></li>
                            <?php if (CommonFunction::isRecruiter()) { ?>
                                <li><a href="<?= Yii::$app->urlManager->createUrl("browse-jobs/recruiter-lead"); ?>">Recruiter Leads</a></li>
                            <?php } ?>
                            <?php if (CommonFunction::isEmployer() || CommonFunction::isRecruiter()) { ?>
                                <li class="postjob"><a href="<?= Yii::$app->urlManager->createUrl("job/post"); ?>">Post a job</a></li>
                            <?php } ?>
                            <?php if (!empty(Yii::$app->user->identity)) { ?>
                                <li class="dropdown userbtn"><a href=""><img src="<?= $assetDir ?>/images/candidates/01.jpg" alt="" class="userimg" /></a>
                                    <ul class="dropdown-menu">
                                        <?php if (CommonFunction::isEmployer() || CommonFunction::isRecruiter()) { ?>
                                            <li><a href="<?= Yii::$app->urlManager->createUrl('admin/site/') ?>"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                                        <?php } ?>
                                        <li><a href="<?= Yii::$app->urlManager->createUrl("/site/job-seeker/"); ?>"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
                                        <li><a href="<?= Yii::$app->urlManager->createUrl("/auth/change-password"); ?>"><i class="fa fa-lock" aria-hidden="true"></i> Change Password</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="<?= Yii::$app->urlManager->createUrl("/auth/logout"); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li><a href="<?= Yii::$app->urlManager->createUrl("/auth/login"); ?>">Sign In / Sign Up</a></li>
                            <?php } ?>
                        </ul>
                        <!-- Nav collapes end --> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- Nav end --> 
            </div>
        </div>
        <!-- row end --> 
    </div>
    <!-- Header container end --> 
</div>
