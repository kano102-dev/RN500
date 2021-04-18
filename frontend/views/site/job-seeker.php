<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
?>

<style>

    .searchList li:hover{box-shadow: 0 5px 11px 0 rgb(0 0 0 / 18%), 0 4px 15px 0 rgb(0 0 0 / 15%);border:none;}
    .usernavdash li a{display: flex;align-items: center;}
    .usernavdash .fa-plus{color: #4088ff !important;font-size: 20px !important;top: 3px;}
    .usernavdash .fa-angle-right{color: #4088ff !important;font-size: 23px !important;font-weight: bold;}
    .usernavdash i{position: relative;color: #d9e0e8 !important; font-size: 25px !important;}
    /*.usernavdash i span{position: absolute;left: 7px;color: #000;font-size: 14px;top: 4px;}*/
    .round{width: 1.5rem;height: 1.5rem;justify-content: center;background: #d9e0e8;border-radius: 100%;font-size: .75rem;margin-right: 1rem;text-align: center;line-height: 23px;}
    .font-a{position: absolute;right:10px;}
    .range-content{background: #3ca0d6; padding: 15px;}
    .range-content .title{font-weight: bold;font-size: 15px;color: #fff;}
    .range-content .profile-percent{text-align: center;margin-bottom: 15px;}
    .range-content .profile-percent a{font-weight: bold;font-size: 13px;padding: 5px; background: #263bd6;color: #fff;margin-top: 15px;}
    .listbtn .round{float:right;float: right;position: absolute;right: 0;top: 0px;width: 2.5rem;height: 2.5rem;line-height: 38px;}
    .searchList li .companyName a{color: #fff;}
    .card {padding-left:auto;padding-right:auto;border-radius: 10px;margin-top:15px;box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);-webkit-transition: .25s box-shadow;transition: .25s box-shadow;}
    .card:focus, .card:hover {box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15);}
    .card-inverse .card-img-overlay {background-color: rgba(51, 51, 51, 0.85);border-color: rgba(51, 51, 51, 0.85);}
    .card-img-top{margin-top:10px;}
    .jobinfo .card .card-header, .jobinfo .card .card-footer{display: flex;align-items: center;border-bottom: 1px solid #d4dce0;padding: 20px;}
    .jobinfo .card .card-header .card-title{margin-bottom: 0;margin-left: 10px;}
    .jobinfo .card .card-block{padding:20px;border-bottom: 1px solid #d4dce0;}
    .jobinfo .card .card-header .card-icon{margin-right: 0;height: 35px;width: 35px;line-height: 2;font-size: 17px;background: #3ca0d6;}
    .jobinfo .card .card-header .card-icon .fa{color:#fff;}
    .action {padding: 0px 15px 0px 15px;}
    .action .info{border-top: 1px solid black;    margin: 10px 0px 10px 0px;}
    .action .info a{text-decoration: none;font-weight: bold;font-size: 20px;display: flex;align-items: center;}
    .action .info a .action-icon{position: absolute;right:10px;top:5px;}
    .action .info a .action-icon .fa-angle-right{font-weight: bold;font-size: 30px;}
    .box-padding{padding:0 !important;}
    .box-padding .jobinfo{padding:20px 0px 0px 20px;}
    .box-padding .content{padding:0px 0px 0px 20px;}

</style>

<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="fixed-sidebar">
                    <div class="range-content">
                        <p class="title">Let's Improve Your Profile !</p>
                        <div class="profile-percent">
                            <a href="#" class="btn">Profile strength: 53%</a>
                        </div>
                        <input id="range" type="range" min="0" max="50000" >
                    </div>
                    <ul class="usernavdash">
                        <li class="active"><a href="#"><div class="round">1</div> Create a NurseFly account <span class="round font-a"><i class="fa fa-plus"></i></span></a></li>
                        <li><a href="#"><div class="round">2</div> Documents <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#"><div class="round">3</div> License <span class="round font-a"><i class="fa fa-plus"></i></span></a></li>
                        <li><a href="#"><div class="round">4</div> Certifications <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#"><div class="round">5</div> Work experience <span class="round font-a"><i class="fa fa-plus"></i></span></a></li>
                        <li><a href="#"><div class="round">6</div> Education <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#"><div class="round">7</div> About You <span class="round font-a"><i class="fa fa-plus"></i></span></a></li>
                        <li><a href="#"><div class="round">8</div> Job Search<span class="round font-a"><i class="fa fa-angle-right"></i></span> </a></li>
                        <li><a href="#"><div class="round">9</div> References<span class="round font-a"><i class="fa fa-plus"></i></span> </a></li>
                        <li><a href="#"><div class="round">10</div> Skills Checklist <span class="round font-a"><i class="fa fa-plus"></i></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 col-sm-6">
                <div class="myads">
                    <ul class="searchList">
                        <!-- start -->
                        <li>
                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <div class="jobimg">
                                        <img src="<?= $assetDir ?>/images/jobs/jobimg.jpg" alt="Job Name">
                                    </div>
                                    <div class="jobinfo">
                                        <h5>User Name</h5>
                                        <div class="location">User Designation</div>
                                        <div class="companyName"><a href="#" class="btn btn-info" >Edit</a></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="listbtn">
                                        <div class="round"><i class="fa fa-file"></i></div>
                                    </div>
                                </div>
                            </div>

                        </li>
                        <!-- end --> 

                        <!-- start -->
                        <li>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3><a href="#.">Job Search</a></h3>
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-icon round"><i class="fa fa-shopping-bag"></i></div>
                                                <h4 class="card-title">Permanent Job Preferences</h4>
                                            </div>
                                            <div class="card-block">
                                                <p class="card-text">No Preferences Set</p>
                                            </div>
                                            <div class="card-footer">
                                                <h4 class="card-title">Update Permanent Job Search Preferences</h4>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-icon round"><i class="fa fa-file"></i></div>
                                                <h4 class="card-title">Travel Job Preferences</h4>
                                            </div>
                                            <div class="card-block">
                                                <p class="card-text">No Preferences Set</p>
                                            </div>
                                            <div class="card-footer">
                                                <h4 class="card-title">Update Permanent Job Search Preferences</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </li>
                        <!-- end --> 

                        <!-- start -->
                        <li class="box-padding">
                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <div class="jobinfo">
                                        <h3><a href="#.">About You</a></h3>
                                    </div>
                                    <div class="content">
                                        <p>Name</p>
                                        <p>Discipline</p>
                                        <p>Speciality</p>
                                        <p>Secondary Speciality</p>
                                        <p>Phone</p>
                                        <p>Email</p>
                                        <p>Last 4 of SSN</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="jobinfo">
                                        <h3>&nbsp;</h3>
                                    </div>
                                    <div class="content">
                                        <p>User Name</p>
                                        <p>RN</p>
                                        <p>-</p>
                                        <p>-</p>
                                        <p>-</p>
                                        <p>-</p>
                                        <p>-</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-12 info">
                                    <div class="">
                                        <a href="#">
                                            <p>Update Information</p>
                                            <div class="action-icon">
                                                <i class="fa fa-angle-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- end -->

                        <!-- start -->
                        <li class="box-padding">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3><a href="#.">Work Experience</a></h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3>&nbsp;</h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-12 info">
                                    <div class="">
                                        <a href="#">
                                            <p>Add Work Experience</p>
                                            <div class="action-icon">
                                                <i class="fa fa-angle-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- end -->

                        <!-- start -->
                        <li class="box-padding">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3><a href="#.">Education</a></h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3>&nbsp;</h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-12 info">
                                    <div class="">
                                        <a href="#">
                                            <p>Add Education</p>
                                            <div class="action-icon">
                                                <i class="fa fa-angle-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- end -->

                        <!-- start -->
                        <li class="box-padding">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3><a href="#.">Licenses</a></h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3>&nbsp;</h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-12 info">
                                    <div class="">
                                        <a href="#">
                                            <p>Add Licenses</p>
                                            <div class="action-icon">
                                                <i class="fa fa-angle-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- end -->

                        <!-- start -->
                        <li class="box-padding">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3><a href="#.">Certifications</a></h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3>&nbsp;</h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-12 info">
                                    <div class="">
                                        <a href="#">
                                            <p>Add Certifications</p>
                                            <div class="action-icon">
                                                <i class="fa fa-angle-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- end -->

                        <!-- start -->
                        <li class="box-padding">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3><a href="#.">Documents</a></h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3>&nbsp;</h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-12 info">
                                    <div class="">
                                        <a href="#">
                                            <p>Add Documents</p>
                                            <div class="action-icon">
                                                <i class="fa fa-angle-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- end -->

                        <!-- start -->
                        <li class="box-padding">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3><a href="#.">References</a></h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3>&nbsp;</h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-12 info">
                                    <div class="">
                                        <a href="#">
                                            <p>Add References</p>
                                            <div class="action-icon">
                                                <i class="fa fa-angle-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- end -->

                        <!-- start -->
                        <li class="box-padding">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3><a href="#.">Skills checklist</a></h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="jobinfo">
                                        <h3>&nbsp;</h3>
                                    </div>
                                    <div class="content">

                                    </div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-12 info">
                                    <div class="">
                                        <a href="#">
                                            <p>Add skills checklist</p>
                                            <div class="action-icon">
                                                <i class="fa fa-angle-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- end -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>