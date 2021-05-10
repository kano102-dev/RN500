<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
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
</style>

<!-- slider start -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active main-item">
            <img class="main-carousel" src="<?= $assetDir . "/images/Brooklyn_Bridge.png" ?>" alt="Los Angeles" style="width:100%;">
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
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



            <div class="col-md-12 col-sm-12 col-12"> 
                <div class="carousel-wrap">
                    <div class="owl-carousel">
                        <div class="item">
                            <img src="http://placehold.it/150x150">
                            <p>Advertisment 1</p>
                        </div>
                        <div class="item">
                            <img src="http://placehold.it/150x150">
                            <p>Advertisment 2</p>
                        </div>
                        <div class="item">
                            <img src="http://placehold.it/150x150">
                            <p>Advertisment 3</p>
                        </div>
                        <div class="item">
                            <img src="http://placehold.it/150x150"><p>Advertisment 4</p>
                        </div>
                        <div class="item">
                            <img src="http://placehold.it/150x150">
                            <p>Advertisment 5</p>
                        </div>
                        <div class="item">
                            <img src="http://placehold.it/150x150">
                            <p>Advertisment 6</p>
                        </div>
                        <div class="item">
                            <img src="http://placehold.it/150x150">
                            <p>Advertisment 7</p>
                        </div>
                        <div class="item">
                            <img src="http://placehold.it/150x150">
                            <p>Advertisment 8</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- How it Works Ends --> 

<div class="section">
    <div class="container"> 
        <div class="col-md-12 col-sm-12"> 
            <ul class="searchList">
                <li>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="jobimg"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/200-150x150.jpeg" alt="Job Name" /></div>
                            <div class="jobinfo">
                                <h3><a href="#.">Employer Name</a></h3>
                                <div class="companyName">Staffing Company</div>
                                <div class="companyName">5.0 &#x2605;&#x2605;&#x2605;&#x2605;&#x2605; (XXX)</div>
                                <div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>Title of Job</p>
                            <p>City, State</p>
                            <p>Posted X days ago</p>
                            <p>Benefits starts from Day 1</p>
                            <p>Employee Assistance</p>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>$XX – XX/hour OR</p>
                            <p>$XX – XX/weekly</p>
                            <p>Estimated Pay</p>
                            <p>Response Time: within a day</p>
                            <div class="listbtn"><a href="#.">Apply Now</a></div>
                        </div>
                    </div>
                    <p><span>Starting Date :</span> Weeks/Months/Year <span>Shift :</span> Travel/Permanent/Temp</p>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="jobimg"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/200-150x150.jpeg" alt="Job Name" /></div>
                            <div class="jobinfo">
                                <h3><a href="#.">Employer Name</a></h3>
                                <div class="companyName">Staffing Company</div>
                                <div class="companyName">5.0 &#x2605;&#x2605;&#x2605;&#x2605;&#x2605; (XXX)</div>
                                <div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>Title of Job</p>
                            <p>City, State</p>
                            <p>Posted X days ago</p>
                            <p>Benefits starts from Day 1</p>
                            <p>Employee Assistance</p>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>$XX – XX/hour OR</p>
                            <p>$XX – XX/weekly</p>
                            <p>Estimated Pay</p>
                            <p>Response Time: within a day</p>
                            <div class="listbtn"><a href="#.">Apply Now</a></div>
                        </div>
                    </div>
                    <p><span>Starting Date :</span> Weeks/Months/Year <span>Shift :</span> Travel/Permanent/Temp</p>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="jobimg"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/200-150x150.jpeg" alt="Job Name" /></div>
                            <div class="jobinfo">
                                <h3><a href="#.">Employer Name</a></h3>
                                <div class="companyName">Staffing Company</div>
                                <div class="companyName">5.0 &#x2605;&#x2605;&#x2605;&#x2605;&#x2605; (XXX)</div>
                                <div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>Title of Job</p>
                            <p>City, State</p>
                            <p>Posted X days ago</p>
                            <p>Benefits starts from Day 1</p>
                            <p>Employee Assistance</p>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>$XX – XX/hour OR</p>
                            <p>$XX – XX/weekly</p>
                            <p>Estimated Pay</p>
                            <p>Response Time: within a day</p>
                            <div class="listbtn"><a href="#.">Apply Now</a></div>
                        </div>
                    </div>
                    <p><span>Starting Date :</span> Weeks/Months/Year <span>Shift :</span> Travel/Permanent/Temp</p>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="jobimg"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/200-150x150.jpeg" alt="Job Name" /></div>
                            <div class="jobinfo">
                                <h3><a href="#.">Employer Name</a></h3>
                                <div class="companyName">Staffing Company</div>
                                <div class="companyName">5.0 &#x2605;&#x2605;&#x2605;&#x2605;&#x2605; (XXX)</div>
                                <div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>Title of Job</p>
                            <p>City, State</p>
                            <p>Posted X days ago</p>
                            <p>Benefits starts from Day 1</p>
                            <p>Employee Assistance</p>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>$XX – XX/hour OR</p>
                            <p>$XX – XX/weekly</p>
                            <p>Estimated Pay</p>
                            <p>Response Time: within a day</p>
                            <div class="listbtn"><a href="#.">Apply Now</a></div>
                        </div>
                    </div>
                    <p><span>Starting Date :</span> Weeks/Months/Year <span>Shift :</span> Travel/Permanent/Temp</p>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="jobimg"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/200-150x150.jpeg" alt="Job Name" /></div>
                            <div class="jobinfo">
                                <h3><a href="#.">Employer Name</a></h3>
                                <div class="companyName">Staffing Company</div>
                                <div class="companyName">5.0 &#x2605;&#x2605;&#x2605;&#x2605;&#x2605; (XXX)</div>
                                <div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>Title of Job</p>
                            <p>City, State</p>
                            <p>Posted X days ago</p>
                            <p>Benefits starts from Day 1</p>
                            <p>Employee Assistance</p>
                        </div>
                        <div class="col-md-4 col-sm-4 employee-details">
                            <p>$XX – XX/hour OR</p>
                            <p>$XX – XX/weekly</p>
                            <p>Estimated Pay</p>
                            <p>Response Time: within a day</p>
                            <div class="listbtn"><a href="#.">Apply Now</a></div>
                        </div>
                    </div>
                    <p><span>Starting Date :</span> Weeks/Months/Year <span>Shift :</span> Travel/Permanent/Temp</p>
                </li>
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
