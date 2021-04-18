<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title>RN500</title>
        <?php $this->head() ?>
        <!-- Fav Icon -->
        <link rel="shortcut icon" href="<?= $assetDir ?>/images/favicon.ico">
    </head>
    <body>
        <?php $this->beginBody() ?>

        <!-- Header start -->
        <?= $this->render('header', ['assetDir' => $assetDir]) ?>
        <!-- Header end --> 

        <!-- Search start -->
        <div class="searchwrap">
            <div class="container">
                <h3>One million success stories. <span>Start yours today.</span></h3>
                <div class="searchbar row">
                    <div class="col-md-5">
                        <input type="text" class="form-control" placeholder="Enter Skills or job title" />
                    </div>
                    <div class="col-md-3">
                        <select class="form-control">
                            <option>Select Categories</option>
                            <option>Marketing</option>
                            <option>Teaching & Education </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control">
                            <option>Select City</option>
                            <option>New York</option>
                            <option>San Joes</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="btn" value="Search Job">
                    </div>
                </div>
                <!-- button start -->
                <div class="getstarted"><a href="#."><i class="fa fa-user" aria-hidden="true"></i> Get Started Now</a></div>
                <!-- button end --> 

            </div>
        </div>
        <!-- Search End --> 

        <!-- How it Works start -->
        <div class="section howitwrap">
            <div class="container"> 
                <!-- title start -->
                <div class="titleTop">
                    <div class="subtitle">Here You Can See</div>
                    <h3>How It <span>Works?</span></h3>
                </div>
                <!-- title end -->
                <ul class="howlist row">
                    <!--step 1-->
                    <li class="col-md-4 col-sm-4">
                        <div class="iconcircle"><i class="fa fa-user" aria-hidden="true"></i></div>
                        <h4>Create An Account</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incidid ut labore et dolore magna aliqua.</p>
                    </li>
                    <!--step 1 end--> 

                    <!--step 2-->
                    <li class="col-md-4 col-sm-4">
                        <div class="iconcircle"><i class="fa fa-black-tie" aria-hidden="true"></i></div>
                        <h4>Search Desired Job</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incidid ut labore et dolore magna aliqua.</p>
                    </li>
                    <!--step 2 end--> 

                    <!--step 3-->
                    <li class="col-md-4 col-sm-4">
                        <div class="iconcircle"><i class="fa fa-file-text" aria-hidden="true"></i></div>
                        <h4>Send Your Resume</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incidid ut labore et dolore magna aliqua.</p>
                    </li>
                    <!--step 3 end-->
                </ul>
            </div>
        </div>
        <!-- How it Works Ends --> 

        <!-- Top Employers start -->
        <div class="section greybg">
            <div class="container"> 
                <!-- title start -->
                <div class="titleTop">
                    <div class="subtitle">Here You Can See</div>
                    <h3>Top <span>Employers</span></h3>
                </div>
                <!-- title end -->

                <ul class="employerList">
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo1.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo2.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo3.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo4.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo5.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo6.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo7.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo8.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo9.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo10.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo11.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo12.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo13.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo14.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo15.jpg" alt="Company Name" /></a></li>
                    <!--employer-->
                    <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="<?= $assetDir ?>/images/employers/emplogo16.jpg" alt="Company Name" /></a></li>
                </ul>
            </div>
        </div>
        <!-- Top Employers ends --> 

        <!-- Popular Searches start -->
        <div class="section">
            <div class="container"> 
                <!-- title start -->
                <div class="titleTop">
                    <div class="subtitle">Here You Can See</div>
                    <h3>Popular <span>Searches</span></h3>
                </div>
                <!-- title end -->
                <div class="topsearchwrap row">
                    <div class="col-md-6"> 
                        <!--Categories start-->
                        <h4>Browse By Categories</h4>
                        <ul class="row catelist">
                            <li class="col-md-6 col-sm-6"><a href="#.">Marketing <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Teaching &amp; Education <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Writing <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Telemarketing <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Administration <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Clerical &amp; Front Office <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">SEO <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Engineering <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Software & Web <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Sales & BD <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Customer Service <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Creative Design <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Accounts & Finance <span>(174)</span></a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Web Design <span>(174)</span></a></li>
                        </ul>
                        <!--Categories end--> 
                    </div>
                    <div class="col-md-6"> 
                        <!--Cities start-->
                        <h5>Browse By Cities</h5>
                        <ul class="row catelist">
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">New York</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Alexander City</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Andalusia</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Anniston</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Athens</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Atmore</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Auburn</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Bessemer</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Birmingham</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Chickasaw</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Clanton</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Cullman</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Decatur</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Demopolis</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Dothan</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Enterprise</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Eufaula</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Anchorage</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Cordova</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Fairbanks</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Haines</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Birmingham</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Chickasaw</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Clanton</a></li>
                        </ul>
                        <!--Cities end--> 
                    </div>
                </div>
            </div>
        </div>
        <!-- Popular Searches ends --> 

        <!-- Featured Jobs start -->
        <div class="section greybg">
            <div class="container"> 
                <!-- title start -->
                <div class="titleTop">
                    <div class="subtitle">Here You Can See</div>
                    <h3>Featured <span>Jobs</span></h3>
                </div>
                <!-- title end --> 

                <!--Featured Job start-->
                <ul class="jobslist row">
                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="<?= $assetDir ?>/images/employers/emplogo1.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="images/employers/emplogo2.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="partTime">Part Time</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="<?= $assetDir ?>/images/employers/emplogo3.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="freelance">Free Lancer</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="<?= $assetDir ?>/images/employers/emplogo4.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="<?= $assetDir ?>/images/employers/emplogo5.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="partTime">Part Time</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="<?= $assetDir ?>/images/employers/emplogo6.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="freelance">Free Lancer</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end-->

                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="<?= $assetDir ?>/images/employers/emplogo7.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="<?= $assetDir ?>/images/employers/emplogo8.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="partTime">Part Time</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="<?= $assetDir ?>/images/employers/emplogo9.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="freelance">Free Lancer</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end-->

                    <!--Job start-->
                    <li class="col-md-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-2 col-sm-2"><img src="<?= $assetDir ?>/images/employers/emplogo10.jpg" alt="Job Name" /></div>
                                <div class="col-md-7 col-sm-7">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="freelance">Free Lancer</label>   - <span>New York</span></div>
                                </div>
                                <div class="col-md-3 col-sm-3"><a href="#." class="applybtn">Apply Now</a></div>
                            </div>
                        </div>
                    </li>
                    <!--Job end-->

                </ul>
                <!--Featured Job end--> 

                <!--button start-->
                <div class="viewallbtn"><a href="job-listing.html">View All Featured Jobs</a></div>
                <!--button end--> 
            </div>
        </div>
        <!-- Featured Jobs ends --> 

        <!-- Video start -->
        <div class="videowraper section">
            <div class="container"> 
                <!-- title start -->
                <div class="titleTop">
                    <div class="subtitle">Here You Can See</div>
                    <h3>Watch Our <span>Video</span></h3>
                </div>
                <!-- title end -->

                <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue posuere lacus, id tincidunt nisi porta sit amet. Suspendisse et sapien varius, pellentesque dui non, semper orci.</p>
                <a href="#."><i class="fa fa-play-circle-o" aria-hidden="true"></i></a> </div>
        </div>
        <!-- Video end --> 

        <!-- Latest Jobs start -->
        <div class="section greybg">
            <div class="container"> 
                <!-- title start -->
                <div class="titleTop">
                    <div class="subtitle">Here You Can See</div>
                    <h3>Latest <span>Jobs</span></h3>
                </div>
                <!-- title end -->

                <ul class="jobslist row">
                    <!--Job 1-->
                    <li class="col-md-4 col-sm-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-3 col-sm-3"><img src="<?= $assetDir ?>/images/employers/emplogo1.jpg" alt="Job Name" /></div>
                                <div class="col-md-9 col-sm-9">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="fulltime">Full Time</label>  - <span>New York</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job 2-->
                    <li class="col-md-4 col-sm-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-3 col-sm-3"><img src="<?= $assetDir ?>/images/employers/emplogo11.jpg" alt="Job Name" /></div>
                                <div class="col-md-9 col-sm-9">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="freelance">Free Lancer</label>   - <span>New York</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job 3-->
                    <li class="col-md-4 col-sm-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-3 col-sm-3"><img src="<?= $assetDir ?>/images/employers/emplogo12.jpg" alt="Job Name" /></div>
                                <div class="col-md-9 col-sm-9">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="partTime">Part Time</label>   - <span>New York</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job 4-->
                    <li class="col-md-4 col-sm-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-3 col-sm-3"><img src="<?= $assetDir ?>/images/employers/emplogo13.jpg" alt="Job Name" /></div>
                                <div class="col-md-9 col-sm-9">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="freelance">Free Lancer</label>   - <span>New York</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job 5-->
                    <li class="col-md-4 col-sm-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-3 col-sm-3"><img src="<?= $assetDir ?>/images/employers/emplogo14.jpg" alt="Job Name" /></div>
                                <div class="col-md-9 col-sm-9">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job 6-->
                    <li class="col-md-4 col-sm-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-3 col-sm-3"><img src="<?= $assetDir ?>/images/employers/emplogo15.jpg" alt="Job Name" /></div>
                                <div class="col-md-9 col-sm-9">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job 7-->
                    <li class="col-md-4 col-sm-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-3 col-sm-3"><img src="<?= $assetDir ?>/images/employers/emplogo16.jpg" alt="Job Name" /></div>
                                <div class="col-md-9 col-sm-9">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="partTime">Part Time</label>   - <span>New York</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job 8-->
                    <li class="col-md-4 col-sm-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-3 col-sm-3"><img src="<?= $assetDir ?>/images/employers/emplogo2.jpg" alt="Job Name" /></div>
                                <div class="col-md-9 col-sm-9">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="freelance">Free Lancer</label>   - <span>New York</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Job end--> 

                    <!--Job 9-->
                    <li class="col-md-4 col-sm-6">
                        <div class="jobint">
                            <div class="row">
                                <div class="col-md-3 col-sm-3"><img src="<?= $assetDir ?>/images/employers/emplogo3.jpg" alt="Job Name" /></div>
                                <div class="col-md-9 col-sm-9">
                                    <h4><a href="#.">Technical Database Engineer</a></h4>
                                    <div class="company"><a href="#.">Datebase Management Company</a></div>
                                    <div class="jobloc"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Job end-->
                </ul>
                <!--view button-->
                <div class="viewallbtn"><a href="#.">View All Latest Jobs</a></div>
                <!--view button end--> 
            </div>
        </div>
        <!-- Latest Jobs ends --> 

        <!-- Testimonials start -->
        <div class="section">
            <div class="container"> 
                <!-- title start -->
                <div class="titleTop">
                    <div class="subtitle">Here You Can See</div>
                    <h3>Success <span>Stories</span></h3>
                </div>
                <!-- title end -->

                <ul class="testimonialsList">
                    <!--user 1 Start-->
                    <li class="item">
                        <div class="testimg"><img src="<?= $assetDir ?>/images/userimg.jpg" alt="Your alt text here" /></div>
                        <div class="clientname">Garry Miller Jr</div>
                        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum viverra id nunc at finibus. Etiam sollicitudin faucibus cursus. Proin luctus cursus nulla sed iaculis. Quisque vestibulum augue nec aliquet aliquet."</p>
                        <div class="clientinfo">CEO - Gates Inc</div>
                    </li>
                    <!--user 1 end--> 

                    <!--user 2 Start-->
                    <li class="item">
                        <div class="testimg"><img src="<?= $assetDir ?>/images/userimg.jpg" alt="Your alt text here" /></div>
                        <div class="clientname">Garry Miller Jr</div>
                        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum viverra id nunc at finibus. Etiam sollicitudin faucibus cursus. Proin luctus cursus nulla sed iaculis. Quisque vestibulum augue nec aliquet aliquet."</p>
                        <div class="clientinfo">CEO - Gates Inc</div>
                    </li>
                    <!--user 2 end-->
                </ul>
            </div>
        </div>
        <!-- Testimonials End --> 

        <!-- App Start -->
        <div class="appwraper">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-6"> 
                        <!--app image Start-->
                        <div class="appimg"><img src="<?= $assetDir ?>/images/app-mobile.png" alt="Your alt text here" /></div>
                        <!--app image end--> 
                    </div>
                    <div class="col-md-7 col-sm-6"> 
                        <!--app info Start-->
                        <div class="titleTop">
                            <div class="subtitle">Step Forword Now</div>
                            <h3>The Jobee APP</h3>
                        </div>
                        <div class="subtitle2">A world of oppertunity in your hand</div>
                        <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue posuere lacus, id tincidunt nisi porta sit amet. Suspendisse et sapien varius, pellentesque dui non, semper orci. Curabitur blandit, diam ut ornare ultricies.</p>
                        <div class="appbtn">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6"><a href="#."><img src="<?= $assetDir ?>/images/apple-btn.png" alt="Your alt text here"></a></div>
                                <div class="col-md-6 col-sm-6 col-xs-6"><a href="#."><img src="<?= $assetDir ?>/images/andriod-btn.png" alt="Your alt text here"></a></div>
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
                    <!--About Us-->
                    <div class="col-md-3 col-sm-12">
                        <div class="ft-logo"><img src="<?= $assetDir ?>/images/logo.png" alt="Your alt text here"></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et consequat elit. Proin molestie eros sed urna auctor lobortis. Integer eget scelerisque arcu. Pellentesque scelerisque pellentesque nisl, sit amet aliquam mi pellentesque fringilla. Ut porta augue a libero pretium laoreet. Suspendisse sit amet massa accumsan, pulvinar augue id, tristique tortor.</p>

                        <!-- Social Icons -->
                        <div class="social"> <a href="#." target="_blank"> <i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i></a> </div>
                        <!-- Social Icons end --> 
                    </div>
                    <!--About us End--> 

                    <!--Quick Links-->
                    <div class="col-md-2 col-sm-6">
                        <h5>Quick Links</h5>
                        <!--Quick Links menu Start-->
                        <ul class="quicklinks">
                            <li><a href="#.">Career Services</a></li>
                            <li><a href="#.">CV Writing</a></li>
                            <li><a href="#.">Career Resources</a></li>
                            <li><a href="#.">Company Listings</a></li>
                            <li><a href="#.">Success Stories</a></li>
                            <li><a href="#.">Contact Us</a></li>
                            <li><a href="#.">Create Account</a></li>
                            <li><a href="#.">Post a Job</a></li>
                            <li><a href="#.">Contact Sales</a></li>
                        </ul>
                    </div>
                    <!--Quick Links menu end--> 

                    <!--Jobs By Industry-->
                    <div class="col-md-3 col-sm-6">
                        <h5>Jobs By Industry</h5>
                        <!--Industry menu Start-->
                        <ul class="quicklinks">
                            <li><a href="#.">Information Technology Jobs</a></li>
                            <li><a href="#.">Recruitment/Employment Firms Jobs</a></li>
                            <li><a href="#.">Education/Training Jobs</a></li>
                            <li><a href="#.">Manufacturing Jobs</a></li>
                            <li><a href="#.">Call Center Jobs</a></li>
                            <li><a href="#.">N.G.O./Social Services Jobs</a></li>
                            <li><a href="#.">BPO Jobs</a></li>
                            <li><a href="#.">Textiles/Garments Jobs</a></li>
                            <li><a href="#.">Telecommunication/ISP Jobs</a></li>
                        </ul>
                        <!--Industry menu End-->
                        <div class="clear"></div>
                    </div>

                    <!--Latest Articles-->
                    <div class="col-md-4 col-sm-12">
                        <h5>Latest Articles</h5>
                        <ul class="posts-list">
                            <!--Article 1-->
                            <li>
                                <article class="post post-list">
                                    <div class="entry-content media">
                                        <div class="media-left"> <a href="#." title="" class="entry-image"> <img width="80" height="80" src="images/news-1.jpg" alt="Your alt text here"> </a> </div>
                                        <div class="media-body">
                                            <h4 class="entry-title"> <a href="#.">Sed fermentum at lectus nec porta.</a> </h4>
                                            <div class="entry-content-inner">
                                                <div class="entry-meta"> <span class="entry-date">Jan 28, 2016</span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </li>
                            <!--Article end 1--> 

                            <!--Article 2-->
                            <li>
                                <article class="post post-list">
                                    <div class="entry-content media">
                                        <div class="media-left"> <a href="#." title="" class="entry-image"> <img width="80" height="80" src="images/news-2.jpg" alt="Your alt text here"> </a> </div>
                                        <div class="media-body">
                                            <h4 class="entry-title"> <a href="#.">Sed fermentum at lectus nec porta.</a> </h4>
                                            <div class="entry-content-inner">
                                                <div class="entry-meta"> <span class="entry-date">Jan 28, 2016</span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </li>
                            <!--Article end 2--> 

                            <!--Article 3-->
                            <li>
                                <article class="post post-list">
                                    <div class="entry-content media">
                                        <div class="media-left"> <a href="#." title="" class="entry-image"> <img width="80" height="80" src="images/news-3.jpg" alt="Your alt text here"> </a> </div>
                                        <div class="media-body">
                                            <h4 class="entry-title"> <a href="#.">Sed fermentum at lectus nec porta.</a> </h4>
                                            <div class="entry-content-inner">
                                                <div class="entry-meta"> <span class="entry-date">Jan 28, 2016</span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </li>
                            <!--Article end 3-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--Footer end--> 

        <!--Copyright-->
        <div class="copyright">
            <div class="container">
                <div class="bttxt">Copyright &copy; <?= date('Y', strtotime('now')) ?> RN500. All Rights Reserved. Design by: <a href="http://graphicriver.net/user/ecreativesol" target="_blank">eCreativeSolutions</a> <strong>Powered By :<a href="https://icognicode.com">ICOGNICODE</a></strong></div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
