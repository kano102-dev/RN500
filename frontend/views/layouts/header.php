<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="header">
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
                            <li><a href="<?= $assetDir ?>/about-us.html">About us</a></li>
                            <li><a href="<?= $assetDir ?>/contact-us.html">Contact</a></li>
<!--                            <li class="postjob"><a href="<?= $assetDir ?>/post-job.html">Post a job</a></li>
                            <li class="jobseeker"><a href="<?= $assetDir ?>/candidate-listing.html">Job Seeker</a></li>-->
                            <?php if (!empty(Yii::$app->user->identity)) { ?>                            
                                <li class="dropdown userbtn"><a href=""><img src="<?= $assetDir ?>/images/candidates/01.jpg" alt="" class="userimg" /></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?= $assetDir ?>/dashboard.html"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                                        <li><a href="#"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profilt</a></li>
                                        <li><a href="#"><i class="fa fa-briefcase" aria-hidden="true"></i> My Jobs</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="<?= Yii::$app->urlManager->createUrl("/auth/logout"); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                                    </ul>
                                </li>
                            <?php } else {?>
                                <li><a href="<?= Yii::$app->urlManager->createUrl("/auth/login"); ?>">Login</a></li>
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
