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
Pjax::end();
$activeClass = "active";
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$frontendDir = yii\helpers\Url::base(true);
?>

<style>
    .listpgWraper{padding: 100px 0 !important;}
    .top-content{position: absolute;top: 20px;right: 30px;}
    .top-content p{font-size: 15px;font-weight: 600;color: black;}
    .header-new{position: fixed;left: 0;right: 0;background: white;z-index: 999;}
    .nav-tabs li{margin-right: 5px !important;}
    #overlay {position: fixed;z-index: 9999;height: 2em;width: 2em;overflow: show;margin: auto;top: 0;left: 0;bottom: 0;right: 0;}
    #overlay:before {content: '';display: block;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(0,0,0,0.3);}
    #overlay img{position: absolute;z-index: 99;transform: translate(-50%,-50%);}
    .loading{height: 0;width: 0;padding: 15px;border: 6px solid #fff;border-right-color: #1c4599;border-radius: 22px;z-index: 99;-webkit-animation: rotate 1s infinite linear;}
    @-webkit-keyframes rotate {
        /* 100% keyframe for  clockwise. 
           use 0% instead for anticlockwise */
        100% {
            -webkit-transform: rotate(360deg);
        }
    }
    @media (max-width:767px){
        .top-content{display: none}
    }
</style>

<div class="header">
    <!--<div class="top-content"><p>One million success stories. Start yours today.</p></div>-->
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-12"> <a href="<?= Yii::$app->urlManagerFrontend->createUrl("/"); ?>" class="logo"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="RN500" /></a>
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

                            <li class="<?= $controller == 'site' && $action == 'index' ? $activeClass : '' ?>"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("/"); ?>">Home</a> 
                            </li>
                            <li class="<?= $controller == 'site' && $action == 'about-us' ? $activeClass : '' ?>"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("site/about-us"); ?>">About us</a></li>
                            <li class="<?= $controller == 'site' && $action == 'contact-us' ? $activeClass : '' ?>"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("site/contact-us"); ?>">Contact</a></li>
                            <li class="<?= $controller == 'browse-jobs' && $action == 'index' ? $activeClass : '' ?>"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Browse Jobs</a></li>

                            <?php if (CommonFunction::isRecruiter()) { ?>
                                <li class="<?= $controller == 'browse-jobs' && $action == 'recruiter-lead' ? $activeClass : '' ?>"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs/recruiter-lead"); ?>">Recruiter Leads</a></li>
                            <?php } ?>
                            <?php if (CommonFunction::isEmployer() || CommonFunction::isRecruiter()) { ?>
                                <li class="<?= $controller == 'leads-received' && $action == 'leads-received' ? $activeClass : '' ?>"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("leads-received/index"); ?>">Applications Received</a></li>
                                <li class="<?= $controller == 'job' && $action == 'post' ? $activeClass : '' ?> postjob"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("job/post"); ?>">Post a job</a></li>
                            <?php } ?>

                            <?php if (!empty(Yii::$app->user->identity)) { ?>  

                                <li class="dropdown userbtn new-dropdown-menu">
                                    <a href="javascript:void(0);">
                                        <?php if (isset(Yii::$app->user->identity->details->profile_pic) && !empty(Yii::$app->user->identity->details->profile_pic)) { ?>
                                            <img src="<?= $frontendDir . "/uploads/user-details/profile/" . Yii::$app->user->identity->details->profile_pic ?>" alt="" class="userimg" />
                                        <?php } else { ?>
                                            <img src="<?= $assetDir ?>/images/profile.png" alt="" class="userimg" />
                                        <?php } ?>    
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if (CommonFunction::isEmployer() || CommonFunction::isRecruiter()) { ?>
                                            <li><a href="<?= Yii::$app->urlManagerAdmin->createUrl('site/') ?>"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                                        <?php } ?>
                                        <li class="<?= $controller == 'site' && $action == 'job-seeker' ? $activeClass : '' ?>"><a href="<?= CommonFunction::isJobSeeker() ? Yii::$app->urlManagerFrontend->createUrl("/site/job-seeker/") : Yii::$app->urlManagerFrontend->createUrl(["user-details/profile", 'id' => Yii::$app->user->identity->id]); ?>"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
                                        <li class="<?= $controller == 'auth' && $action == 'change-password' ? $activeClass : '' ?>"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("/auth/change-password"); ?>"><i class="fa fa-lock" aria-hidden="true"></i> Change Password</a></li>
                                        <?php if (CommonFunction::isJobSeeker()) { ?>
                                            <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl('browse-jobs/track-my-application') ?>"><i class="fa fa-map" aria-hidden="true"></i> Track My Application</a></li>
                                        <?php } ?>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("/auth/logout"); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li class="<?= $controller == 'auth' && ($action == 'login' || $action == 'register' || $action == 'request-password-reset') ? $activeClass : '' ?>"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("/auth/login"); ?>">Sign In / Sign Up</a></li>
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
