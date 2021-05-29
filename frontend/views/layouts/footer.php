<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\CommonFunction;

?>

<!--Footer-->
<div class="footerWrap">
    <div class="container">
        <div class="row"> 
          <!--  About Us -->
            <div class="col-md-3 col-sm-12">
                <div class="ft-logo"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Your alt text here"></div>
                <p>RN500 LLC is one of the leading staffing service provider in North America. In healthcare industries to meet the staffing requirements in fastest growing market, we have developed advanced technology service solutions which can eliminate gaps between employers and job seekers. We are covering all of the tools which supports healthcare employers and job seekers under one umbrella where they can find all their needs such as all payroll and benefits managements, taxation, accommodation, travel resources, educational programs, financial assistance, credit cards, reward programs, medical and health insurances, etc. Enroll today on RN500.com and make your life easy on current challenging time..</p>

                 <!-- Social Icons -->
                <div class="social"> <a href="#." target="_blank"> <i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i></a> </div>
                 <!-- Social Icons end  -->
            </div>
            <!-- About us End -->

<!--            Quick Links-->
            <div class="col-md-2 col-sm-6">
                <h5>Quick Links</h5>
                <!--Quick Links menu Start-->
                <ul class="quicklinks">
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Search your Job</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Job Listing</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("job/post"); ?>">Post a Job</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("site/contact-us"); ?>">Contact Us</a></li>                    
                </ul>
            </div>
            <!--Quick Links menu end--> 

            <!--Jobs By Industry-->
            <div class="col-md-3 col-sm-6">
                <!--Industry menu Start-->
                <ul class="quicklinks">
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Jobs by Specialty</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Jobs by Disciptline</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Jobs by Benefits</a></li>
                    <li><a href="<?= Yii::$app->urlManagerFrontend->createUrl("browse-jobs"); ?>">Jobs by Locations</a></li>
                </ul>
                <!--Industry menu End-->
                <div class="clear"></div>
            </div>
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