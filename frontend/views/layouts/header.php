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
            <div class="col-md-2 col-sm-3 col-xs-12"> <a href="index.html" class="logo"><img src="<?= $assetDir ?>/images/logo.png" alt="" /></a>
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
                            <li class="dropdown active"><a href="index.html">Home <span class="caret"></span></a> 
                                <!-- dropdown start -->
                                <ul class="dropdown-menu">
                                    <li class="active"><a href="index.html">Home Static Image</a></li>
                                    <li><a href="<?= $assetDir ?>/index2.html">Home With Map</a></li>
                                    <li><a href="<?= $assetDir ?>/index3.html">Home With Slider</a></li>
                                </ul>
                                <!-- dropdown end --> 
                            </li>
                            <li><a href="<?= $assetDir ?>/about-us.html">About us</a></li>
                            <li class="dropdown"><a href="#.">Pages <span class="caret"></span></a> 
                                <!-- dropdown start -->
                                <ul class="dropdown-menu">
                                    <li><a href="<?= $assetDir ?>/about-us.html">About Us</a></li>
                                    <li><a href="<?= $assetDir ?>/login.html">Login</a></li>
                                    <li><a href="<?= $assetDir ?>/register.html">Register</a></li>
                                    <li><a href="<?= $assetDir ?>/job-listing.html">Job Listing</a></li>
                                    <li><a href="<?= $assetDir ?>/job-detail.html">Job Detail</a></li>
                                    <li><a href="<?= $assetDir ?>/candidate-listing.html">Candidate Listing</a></li>
                                    <li><a href="<?= $assetDir ?>/candidate-detail.html">Candidate Detail</a></li>
                                    <li><a href="<?= $assetDir ?>/company-detail.html">Company Profile</a></li>
                                    <li><a href="<?= $assetDir ?>/edit-profile.html">Edit Profile</a></li>
                                    <li><a href="<?= $assetDir ?>/post-job.html">Post a Job</a></li>
                                    <li><a href="<?= $assetDir ?>/packages.html">Packages</a></li>
                                    <li><a href="<?= $assetDir ?>/faqs.html">FAQs</a></li>
                                    <li><a href="<?= $assetDir ?>/404.html">404 Page</a></li>
                                    <li><a href="<?= $assetDir ?>/typography.html">Typography</a></li>
                                </ul>
                                <!-- dropdown end --> 
                            </li>
                            <li class="dropdown"><a href="<?= $assetDir ?>/blog.html">Blog <span class="caret"></span></a> 
                                <!-- dropdown start -->
                                <ul class="dropdown-menu">
                                    <li><a href="<?= $assetDir ?>/blog.html">Blog List</a></li>
                                    <li><a href="<?= $assetDir ?>/blog-detail.html">Blog Detail</a></li>
                                    <li><a href="<?= $assetDir ?>/blog-grid.html">Blog Grid</a></li>
                                    <li><a href="<?= $assetDir ?>/blog-full-width.html">Blog Grid Full Width</a></li>
                                </ul>
                                <!-- dropdown end --> 
                            </li>
                            <li><a href="<?= $assetDir ?>/contact-us.html">Contact</a></li>
                            <li class="postjob"><a href="<?= $assetDir ?>/post-job.html">Post a job</a></li>
                            <li class="jobseeker"><a href="<?= $assetDir ?>/candidate-listing.html">Job Seeker</a></li>
                            <li class="dropdown userbtn"><a href=""><img src="<?= $assetDir ?>/images/candidates/01.jpg" alt="" class="userimg" /></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= $assetDir ?>/dashboard.html"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                                    <li><a href="#"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profilt</a></li>
                                    <li><a href="#"><i class="fa fa-briefcase" aria-hidden="true"></i> My Jobs</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                                </ul>
                            </li>
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
