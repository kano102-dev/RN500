<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<style>
    .employee-details p{margin: 0 !important;font-weight: 600;}
    .pageSearch-new{margin-bottom: 0}
    .sidebar-new{text-align: center;font-weight: 600;font-size: 20px;}
    .carousel-wrap {width: 100%;position: relative;}
    /* fix blank or flashing items on carousel */
    .owl-carousel .item {position: relative;z-index: 100; -webkit-backface-visibility: hidden;text-align: center;margin-bottom: 25px}
    .owl-carousel .owl-nav{display: none}


</style>

<div class="listpgWraper">
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

        <!-- Page Title start -->
        <div class="pageSearch pageSearch-new">
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
        </div>
        <div class="row">
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
            <div class="col-md-9 col-sm-12"> 
                <!-- Search List -->
                <ul class="searchList">
                    <li>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="jobimg"><img src="https://admissions.ncsu.edu/wp-content/uploads/sites/19/2020/08/200-150x150.jpeg" alt="Job Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Employer Name</a></h3>
                                    <div class="companyName">Staffing Company</div>
                                    <div class="companyName">5.0 &#x2605;&#x2605;&#x2605;&#x2605;&#x2605; (XXX)</div>
                                    <!--<div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>-->
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
                                    <!--<div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>-->
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
                                    <!--<div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>-->
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
                                    <!--<div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>-->
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
                                    <!--<div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>-->
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
        <!-- Popular Searches start -->
        <div class="section">
            <div class="container"> 
                <!-- title start -->
                <div class="titleTop">
                    <h3>Industry  <span>Leaders</span></h3>
                </div>
                <!-- title end -->
                <div class="topsearchwrap row">
                    <div class="col-md-12 col-12"> 
                        <!--Categories start-->
                        <h4>Browse By Categories</h4>
                        <ul class="row catelist">
                            <li class="col-md-6 col-sm-6"><a href="#.">Marketing </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Teaching &amp; Education </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Writing </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Telemarketing </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Administration </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Clerical &amp; Front Office </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">SEO </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Engineering </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Software & Web </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Sales & BD </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Customer Service </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Creative Design </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Accounts & Finance </a></li>
                            <li class="col-md-6 col-sm-6"><a href="#.">Web Design </a></li>
                        </ul>
                        <!--Categories end--> 
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Popular Searches ends --> 

        <!-- Popular Searches start -->
        <div class="section">
            <div class="container"> 
                <!-- title start -->
                <div class="titleTop">
                    <h3>Popular <span>States</span></h3>
                </div>
                <!-- title end -->
                <div class="topsearchwrap row">
                    <div class="col-md-12 col-12" > 
                        <!--Categories start-->
                        <h5>States</h5>
                        <ul class="row catelist">
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Alabama</a></li>
                            <li class="col-md-4 col-sm-4 col-xs-6"><a href="#.">Alaska</a></li>
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
                        <!--Categories end--> 
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- Popular Searches ends --> 
    </div>
</div>
