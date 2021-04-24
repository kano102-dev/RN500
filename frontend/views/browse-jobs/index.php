<?php

//use Yii;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use common\CommonFunction;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
$shift_prams = isset($_GET['shift']) ? $_GET['shift'] : [];
?>
<style>
    .browse-jobs li p {line-height: 22px;color: #333;margin: 0;font-weight: 600}
</style>

<!-- Page Title start -->
<div class="pageTitle">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h1 class="page-heading">Find Your Jobs</h1>
            </div>
        </div>
    </div>
</div>
<!-- Page Title End -->

<div class="listpgWraper">
    <div class="container"> 

        <!-- Search Result and sidebar start -->
        <div class="row">
            <div class="col-md-3 col-sm-12">  
                <!-- Side Bar start -->
                <div class="sidebar"> 
                    <form method="GET">
                        <!-- Jobs By Discipline -->
                        <div class="widget" id="discipline-widget">
                            <h4 class="widget-title">Discipline</h4>
                            <ul class="optionlist" id="optionlist-discipline">

                            </ul>
                        </div>

                        <!-- Jobs By Specialty -->
                        <div class="widget" id="speciality-widget">
                            <h4 class="widget-title">Specialty</h4>
                            <ul class="optionlist" id="optionlist-speciality">

                            </ul>
                        </div>

                        <!-- Jobs By Shift -->
                        <div class="widget">
                            <h4 class="widget-title">Shift</h4>
                            <ul class="optionlist">
                                <li>
                                    <?php if (in_array(1, $shift_prams)) { ?>
                                        <input type="checkbox" name="shift[]" value="1" id="shift-1" checked />
                                    <?php } else { ?>
                                        <input type="checkbox" name="shift[]" value="1" id="shift-1" />
                                    <?php } ?>
                                    <label for="shift-1"></label>
                                    All</li>
                                <li>
                                    <?php if (in_array(2, $shift_prams)) { ?>
                                        <input type="checkbox" name="shift[]" value="2" id="shift-2" checked />
                                    <?php } else { ?>
                                        <input type="checkbox" name="shift[]" value="2" id="shift-2" />
                                    <?php } ?>
                                    <label for="shift-2"></label>
                                    Morning
                                </li>
                                <li>
                                    <?php if (in_array(3, $shift_prams)) { ?>
                                        <input type="checkbox" name="shift[]" value="3" id="shift-3" checked />
                                    <?php } else { ?>
                                        <input type="checkbox" name="shift[]" value="3" id="shift-3" />
                                    <?php } ?>
                                    <label for="shift-3"></label>
                                    Evening
                                </li>
                                <li>
                                    <?php if (in_array(4, $shift_prams)) { ?>
                                        <input type="checkbox" name="shift[]" value="4" id="shift-4" checked />
                                    <?php } else { ?>
                                        <input type="checkbox" name="shift[]" value="4" id="shift-4" />
                                    <?php } ?>
                                    <label for="shift-4"></label>
                                    Night
                                </li>
                                <li>
                                    <?php if (in_array(5, $shift_prams)) { ?>
                                        <input type="checkbox" name="shift[]" value="5" id="shift-5" checked />
                                    <?php } else { ?>
                                        <input type="checkbox" name="shift[]" value="5" id="shift-5" />
                                    <?php } ?>
                                    <label for="shift-5"></label>
                                    Flatulate
                                </li>
                            </ul>
                        </div>

                        <!-- Jobs By Location -->
                        <div class="widget">
                            <h4 class="widget-title">Location</h4>
                            <ul class="optionlist">
                                <li>
                                    <input type="checkbox" name="checkname" id="infotech" />
                                    <label for="infotech"></label>
                                    Information Technology
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="advertise" />
                                    <label for="advertise"></label>
                                    Advertising/PR
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="services" />
                                    <label for="services"></label>
                                    Services
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="health" />
                                    <label for="health"></label>
                                    Health & Fitness
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="mediacomm" />
                                    <label for="mediacomm"></label>
                                    Media/Communications
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="fashion" />
                                    <label for="fashion"></label>
                                    Fashion
                                </li>
                            </ul>
                            <a href="#.">View More</a> </div>

                        <!-- Top Benefits -->
                        <div class="widget" id="benefit-widget">
                            <h4 class="widget-title">Benefits</h4>
                            <ul class="optionlist" id="optionlist-benefit">
                            </ul>
                        </div>

                        <!-- Salary -->
                        <div class="widget">
                            <h4 class="widget-title">Salary Range</h4>
                            <ul class="optionlist">
                                <li>
                                    <input type="checkbox" name="checkname" id="price1" />
                                    <label for="price1"></label>
                                    0 to $100
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="price2" />
                                    <label for="price2"></label>
                                    $100 to $199
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="price3" />
                                    <label for="price3"></label>
                                    $199 to $499
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="price4" />
                                    <label for="price4"></label>
                                    $499 to $999
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="price5" />
                                    <label for="price5"></label>
                                    $999 to $4999
                                </li>
                                <li>
                                    <input type="checkbox" name="checkname" id="price6" />
                                    <label for="price6"></label>
                                    Above $4999
                                </li>
                            </ul>
                        </div>
                        <div class="searchnt">
                            <button class="btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Search Lead</button>
                        </div>
                    </form>
                </div>
                <!-- Side Bar end --> 
            </div>
            <div class="col-md-9 col-sm-12"> 
                <!-- Search List -->
                <ul class="searchList browse-jobs">
                    <?php foreach ($models as $model) { ?>
                        <!-- Candidate -->
                        <li>
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                    <div class="jobinfo">
                                        <h3><a href="#."><?= $model->title ?></a></h3>
                                        <div class="companyName">Staffing Company</div>
                                        <div class="companyName">5.0 &#x2605;&#x2605;&#x2605;&#x2605;&#x2605; (XXX)</div>
                                        <!--<div class="location"><label class="fulltime">Full Time</label>   - <span>New York</span></div>-->
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-4 col-sm-4 employee-details">
                                    <p><?= $model->title ?></p>
                                    <p>New York City, New York</p>
                                    <p>Posted X days ago</p>
                                    <p>Benefits starts from Day 1</p>
                                    <p>Employee Assistance</p>
                                </div>
                                <div class="col-md-4 col-sm-4 employee-details">
                                    <p>$XX – XX/hour OR</p>
                                    <p><?= Yii::$app->params['job.payment_type'][$model->payment_type] ?></p>
                                    <p>$ <?= $model->jobseeker_payment ?></p>
                                    <p><?= Yii::$app->params['job.type'][$model->job_type] ?></p>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-sm-9">
                                    <p>&nbsp;</p>
                                    <p><span>Starting Date :</span> Weeks/Months/Year <span>Shift :</span> Travel/Permanent/Temp <span>Description :</span><?= $model->description ?></p>

                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <div class="listbtn"><a href="#.">View Profile</a></div>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>

                <!-- Pagination Start -->
                <div class="pagiWrap">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 text-right">
                            <?php echo \yii\widgets\LinkPager::widget(['pagination' => $pages]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$discipline_prams = isset($_GET['discipline']) ? implode(',', $_GET['discipline']) : '';
$specialty_prams = isset($_GET['speciality']) ? implode(',', $_GET['speciality']) : '';
$benefits_prams = isset($_GET['benefit']) ? implode(',', $_GET['benefit']) : '';
$get_discipline_url = Yii::$app->urlManager->createAbsoluteUrl(['browse-jobs/get-discipline']);
$get_specialty_url = Yii::$app->urlManager->createAbsoluteUrl(['browse-jobs/get-specialty']);
$get_benefits_url = Yii::$app->urlManager->createAbsoluteUrl(['browse-jobs/get-benefits']);
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();
$script_new = <<<JS
getDisciplineRecords();
getSpecialtyRecords();
getBenefitsRecords();
        
    function getDisciplineRecords(pageno=0) {
        let params='$discipline_prams';
        let availabel=pageno;
        $.post("$get_discipline_url", {"$csrfParam":"$csrfToken",page: pageno,filter:params}, function(result){
            let data=JSON.parse(result);
            availabel+=data.offset;
            if(data.offset==0){
                $("#optionlist-discipline").html(data.options)
                let nextPage=parseInt(data.offset);
                if(data.options != ''){
                    $("#discipline-widget").append("<a href='javascript:void(0)' id='discipline-viewmore' onClick='getDisciplineRecords("+nextPage+")'>View More</a>")
                }
            }else{
               $("#optionlist-discipline").append(data.options);
               $("#discipline-viewmore").remove();
               if(availabel<data.totalPage){
                    let nextPage=parseInt(data.offset);
                    if(data.options != ''){
                        $("#discipline-widget").append("<a href='javascript:void(0)' id='discipline-viewmore' onClick='getDisciplineRecords("+availabel+")'>View More</a>") 
                    }
               }
            }
        });
    }
        
    function getSpecialtyRecords(pageno=0) {
        let params='$specialty_prams';
        let availabel=pageno;
        $.post("$get_specialty_url", {"$csrfParam":"$csrfToken",page: pageno,filter:params}, function(result){
             let data=JSON.parse(result);
            availabel+=data.offset;
            if(data.offset==0){
                $("#optionlist-speciality").html(data.options)
                let nextPage=parseInt(data.offset);
                if(data.options != ''){
                    $("#speciality-widget").append("<a href='javascript:void(0)' id='speciality-viewmore' onClick='getSpecialtyRecords("+nextPage+")'>View More</a>")
                }
            }else{
               $("#optionlist-speciality").append(data.options);
               $("#speciality-viewmore").remove();
               if(availabel<data.totalPage){
                    let nextPage=parseInt(data.offset);
                    if(data.options != ''){
                        $("#speciality-widget").append("<a href='javascript:void(0)' id='speciality-viewmore' onClick='getSpecialtyRecords("+availabel+")'>View More</a>") 
                    }
               }
            }
        });
    }
        
    function getBenefitsRecords(pageno=0) {
        let params='$benefits_prams';
        let availabel=pageno;
        $.post("$get_benefits_url", {"$csrfParam":"$csrfToken",page: pageno,filter:params}, function(result){
             let data=JSON.parse(result);
            availabel+=data.offset;
            if(data.offset==0){
                $("#optionlist-benefit").html(data.options)
                let nextPage=parseInt(data.offset);
                if(data.options != ''){
                    $("#benefit-widget").append("<a href='javascript:void(0)' id='benefit-viewmore' onClick='getBenefitsRecords("+nextPage+")'>View More</a>")
                }
            }else{
               $("#optionlist-benefit").append(data.options);
               $("#benefit-viewmore").remove();
               if(availabel<data.totalPage){
                    let nextPage=parseInt(data.offset);
                    if(data.options != ''){
                        $("#benefit-widget").append("<a href='javascript:void(0)' id='benefit-viewmore' onClick='getBenefitsRecords("+availabel+")'>View More</a>") 
                    }
               }
            }
        });
    }
JS;
$this->registerJS($script_new, 3);
?>