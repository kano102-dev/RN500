<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use common\CommonFunction;
?>
<style>
    .footerWrap .quicklinks li a:hover{color: #fff;font-weight: bold;}
    .footerWrap .fa-location-arrow,.footerWrap .fa-phone,.footerWrap .fa-envelope{color: #fff;font-size: 25px;font-weight: bold;}
    .footer-content p,.footer-content a{text-decoration: none;color:#ccc;}
    .media-new{display:flex;align-items: center;margin-bottom: 20px;}
</style>
<!-- App Start -->
<div class="appwraper">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-6"> 
                <!--app image Start-->
                <div class="appimg"><img src="<?= $assetDir ?>/images/app-mobile2.png" alt="Your alt text here" /></div>
                <!--app image end--> 
            </div>
            <div class="col-md-7 col-sm-6"> 
                <!--app info Start-->
                <div class="titleTop">
                    <div class="subtitle">Step Forword Now</div>
                    <h3>The RN500 APP</h3>
                </div>
                <div class="subtitle2">A world of opportunity in your hand</div>
                <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue posuere lacus, id tincidunt nisi porta sit amet. Suspendisse et sapien varius, pellentesque dui non, semper orci. Curabitur blandit, diam ut ornare ultricies.</p>
                <div class="appbtn">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6"><a href="#."><img src="<?= $assetDir ?>/images/apple_store.png" id="ios" alt="Apple Store"></a></div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><a href="#."><img src="<?= $assetDir ?>/images/android.png" id="android" alt="Play Store"></a></div>
                    </div>
                </div>
                <!--app info end--> 
            </div>
        </div>
    </div>
</div>
<!-- App End --> 
<!--Footer-->
<div class="footerWrap">
    <div class="container">
        <div class="row"> 
            <!--  About Us -->
            <div class="col-md-5 col-sm-12">
                <div class="ft-logo"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Your alt text here"></div>
                <p>RN500 LLC is one of the leading staffing service provider in North America. In healthcare industries to meet the staffing requirements in fastest growing market, we have developed advanced technology service solutions which can eliminate gaps between employers and job seekers. We are covering all of the tools which supports healthcare employers and job seekers under one umbrella where they can find all their needs such as all payroll and benefits managements, taxation, accommodation, travel resources, educational programs, financial assistance, credit cards, reward programs, medical and health insurances, etc. Enroll today on RN500.com and make your life easy on current challenging time..</p>


            </div>
            <!-- About us End -->
            <div class="col-md-3 col-sm-12">
                <h5>Contact Info</h5>
                <!--Quick Links menu Start-->
                <div class="media-new ">
                    <div class="media-left">
                        <i class="fa fa-location-arrow"></i>
                    </div>
                    <div class="media-body ml-3 footer-content">                                
                        <p>
                            3100, North Ocean Dr, ,  <br>
                            Fort Lauderdale, FL 33308. USA
                        </p>
                    </div>
                </div>
                <div class="media-new">
                    <div class="media-left">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="media-body ml-3 footer-content">                                
                        <p>
                            +1 123–456–7890
                        </p>
                    </div>
                </div>
                <div class="media-new">
                    <div class="media-left">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="media-body ml-3 footer-content">                                
                        <a href="mailto:info@RN500.com" class="mt-1">info@RN500.com</a>
                    </div>
                </div>
                <p>&nbsp;</p>
                <h5 class="">Stay Connected</h5>
                <!-- Social Icons -->
                <div class="social"> <a href="#." target="_blank"> <i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i></a> </div>
                <!-- Social Icons end  -->
            </div>
            <!--            Quick Links-->
            <div class="col-md-2 col-sm-12">
                <h5>Company</h5>
                <!--Quick Links menu Start-->
                <ul class="quicklinks">
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("site/about-us"); ?>">About Us</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("site/contact-us"); ?>">Contact Us</a></li>                    
                </ul>
            </div>
            <div class="col-md-2 col-sm-12">
                <h5>Quick Links</h5>
                <!--Quick Links menu Start-->
                <ul class="quicklinks">
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Search your Job</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Job Listing</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("job/post"); ?>">Post a Job</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Jobs by Specialty</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Jobs by Disciptline</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Jobs by Benefits</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Jobs by Locations</a></li>                   
                </ul>
            </div>
            <!--Quick Links menu end--> 

        </div>
    </div>
</div>
<!--Footer end--> 

<!--Copyright-->
<div class="copyright">
    <div class="container">
        <div class="bttxt">Copyright &copy; <?= date('Y', strtotime('now')) ?> RN500. All Rights Reserved. <strong>Powered By :<a href="https://tracexpert.com"> Tracexpert</a></strong></div>
    </div>
</div>


<div id="overlay" style="display:none">
    <div class="loading"></div>
</div>