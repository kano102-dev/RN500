<?php
/* @var $this yii\web\View */

use common\CommonFunction;

$this->title = 'My Yii Application';
$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
$backendDir = Yii::$app->assetManager->getPublishedUrl('@backend/');
$frontendDir = \Yii::getAlias('@frontend') . "/web/uploads/advertisement/";
?>
<style>
    .employee-details p{margin: 0 !important;font-weight: 600;}
    .pageSearch-new{margin-bottom: 0}
    .sidebar-new{text-align: center;font-weight: 600;font-size: 20px;}
    .carousel-wrap {width: 100%;position: relative;}
    /* fix blank or flashing items on carousel */
    .owl-carousel .item {position: relative;z-index: 100; -webkit-backface-visibility: hidden;text-align: center;margin-bottom: 25px}
    .owl-carousel .owl-nav{display: none}
    .searchbar .form-control{    border: 2px solid #3ca0d6;}
    .searchbar{margin-left: 2rem}
    .moreFTypeBox{text-align: center;}
    .moreFTypeBox p{text-align: center;font-size: 20px;font-weight: 600}
</style>

<!-- slider start -->
<!--<div class="listpgWraper">-->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <!--    <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>-->

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active main-item">
            <img class="main-carousel" src="<?= $assetDir . "/images/Brooklyn_Bridge.png" ?>" alt="Los Angeles" style="width:100%;">
        </div>
    </div>

    <!-- Left and right controls -->
    <!--    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>-->
</div>
<!-- slider End --> 

<div class="container">
    <div class="searchbar row">
        <div class="col-md-12 col-sm-12 col-12"> 
            <div class="carousel-wrap">
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="Search Open Jobs" />
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="City" />
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="State" />
                </div>
                <div class="col-sm-2">
                    <input type="submit" class="btn" value="Search Job">
                </div>
            </div>
        </div>
    </div>
</div>

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
                        <img height="250px" width="350px" src="<?= $frontendDir . $value['icon'] ?>" >
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

<div class="section">
    <div class="container"> 
        <div class="col-md-12 col-sm-12"> 
            <ul class="searchList browse-jobs">
                <?php foreach ($leadModels as $model) { ?>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div><br/><br/>
                                <div class="jobinfo">
                                    <div class="companyName">5.0 &#x2605;&#x2605;&#x2605;&#x2605;&#x2605;</div>
                                    <!--<div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>-->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4 employee-details">
                                <h3><a href="#."><?= $model->title ?></a></h3>
                                <p><?= $model->citiesName ?></p>
                                <p>Posted <?= CommonFunction::dateDiffInDays($model->created_at); ?> days ago</p>
                                <p>Benefits starts from Day 1</p>
                            </div>
                            <div class="col-md-4 col-sm-4 employee-details">
                                <p><b>Estimated Pay:</b> $<?= $model->jobseeker_payment ?>/<?= Yii::$app->params['job.payment_type'][$model->payment_type] ?></p>
                                <br/>
                                <p><b>Response Time:</b> within a day</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-sm-9">
                                <p>&nbsp;</p>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12"><span><b>Starting Date</b> :</span> <?= date('m-d-Y', strtotime($model->start_date)); ?></div>
                                    <div class="col-md-4 col-sm-12"><span><b>Shift</b> :</span> <?= $model->shift == 1 ? "Morning, Evening, Night, Flatulate" : Yii::$app->params['job.shift'][$model->shift] ?></div>
                                    <div class="col-md-4 col-sm-12"><span><b>Job Type</b> :</span> <?= Yii::$app->params['job.type'][$model->job_type] ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/view', 'id' => $model->id]) ?>">View Profile</a></div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
                if (count($leadModels) <= 0) {
                    echo "<h1>No Leads Found</h1>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<!-- Top Employers start -->
<div class="section greybg">
    <div class="container"> 
        <!-- title start -->
        <div class="titleTop">
            <h3>Industry <span> Leaders</span></h3>
        </div>
        <!-- title end -->

        <ul class="employerList">
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo1.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo2.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo3.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo4.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo5.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo6.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo7.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo8.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo9.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo10.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo11.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo12.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo13.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo14.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo15.jpg" alt="Company Name" /></a></li>
            <!--employer-->
            <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Company Name"><a href="company-detail.html"><img src="images/employers/emplogo16.jpg" alt="Company Name" /></a></li>
        </ul>
    </div>
</div>
<!-- Top Employers ends --> 

<!-- Popular Searches start -->
<div class="section">
    <div class="container"> 
        <!-- title start -->
        <div class="titleTop">
            <h3>Popular <span>Searches</span></h3>
        </div>
        <!-- title end -->
        <div class="topsearchwrap row">
            <div class="col-md-12"> 
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

<!--<div class="listpgWraper">
    <div class="container"> -->

<!-- Page Title start -->
<!--        <div class="pageSearch pageSearch-new">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar sidebar-new">
                        <p>My Profile</p>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="sidebar sidebar-new">
                        <p>Make sure your Profile is up to date. This will help to find job faster. </p>
                    </div>
                </div>
            </div>
        </div> -->
<!--        <div class="row">
            <div class="col-md-3 col-sm-12"> 
                <div class="sidebar">
                    <div class="gad">
                        <p>XX New Jobs</p>
                        <p>Posted in last X days</p>
                        <p>XX State Jobs</p>
                        <p>Posted in last X days</p>
                    </div>
                    <div class="gad"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/540x540-376x376.png" alt="your alt text" /></div>
                    <div class="gad"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/540x540-376x376.png" alt="your alt text" /></div>
                    <div class="gad"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/540x540-376x376.png" alt="your alt text" /></div>
                    <div class="gad"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/540x540-376x376.png" alt="your alt text" /></div>
                </div>
            </div>
        </div>-->
<!--    </div>
</div>-->
<!--</div>-->