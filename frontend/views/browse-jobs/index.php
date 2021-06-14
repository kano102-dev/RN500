<?php

//use Yii;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use common\CommonFunction;
use yii\helpers\Url;
use yii\web\JsExpression;

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
    .select2-container--krajee .select2-selection--multiple .select2-selection__choice{margin: 5px 0 0 3px;
                                                                                       padding: 0 15px;}
    .select2-container--krajee .select2-selection--multiple .select2-selection__choice__remove{margin: -5px 0 0 0px;}
    .optionlist li span{right: 2px;}
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
                        
                        <div class="widget" id="emergency-widget">
                            <h4 class="widget-title">Emergency</h4>
                            <ul class="optionlist" id="optionlist-emergency">

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
                                    All
                                </li>
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
                                <?php
                                $url = Url::to(['browse-jobs/get-cities']);
                                echo Select2::widget([
                                    'name' => 'location',
                                    'value' => $selectedLocations,
                                    'options' => [
                                        'id' => 'select_location',
                                        'placeholder' => 'Select Location...',
                                        'multiple' => true,
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumInputLength' => 1,
                                        'ajax' => [
                                            'url' => $url,
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) {return {q:params.term, page:params.page || 1}; }'),
                                            'cache' => true,
                                        ],
                                        'escapeMarkup' => new JsExpression('function (markup) {return markup; }'),
                                        'templateResult' => new JsExpression('function(location) {return "<b>"+location.name+"</b>"; }'),
                                        'templateSelection' => new JsExpression('function (location) {
                                if(location.selected==true){
                                    return location.text; 
                                }else{
                                    return location.name;
                                }
                            }'),
                                    ],
                                ]);
                                ?>
                            </ul>
                        </div>

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
                                    <?php if (isset($_GET['salary']) && in_array(1, $_GET['salary'])) { ?>
                                        <input type="checkbox" name="salary[]" value="1" checked id="price1" />
                                    <?php } else { ?>
                                        <input type="checkbox" name="salary[]" value="1" id="price1" />
                                    <?php } ?>
                                    <label for="price1"></label>
                                    0 to $100
                                </li>
                                <li>
                                    <?php if (isset($_GET['salary']) && in_array(2, $_GET['salary'])) { ?>
                                        <input type="checkbox" name="salary[]" value="2" checked id="price2" />
                                    <?php } else { ?>
                                        <input type="checkbox" name="salary[]" value="2" id="price2" />
                                    <?php } ?>
                                    <label for="price2"></label>
                                    $100 to $199
                                </li>
                                <li>
                                    <?php if (isset($_GET['salary']) && in_array(3, $_GET['salary'])) { ?>
                                        <input type="checkbox" name="salary[]" value="3" checked id="price3" />
                                    <?php } else { ?>
                                        <input type="checkbox" name="salary[]" value="3" id="price3" />
                                    <?php } ?>
                                    <label for="price3"></label>
                                    $199 to $499
                                </li>
                                <li>
                                    <?php if (isset($_GET['salary']) && in_array(4, $_GET['salary'])) { ?>
                                        <input type="checkbox" name="salary[]" value="4" checked id="price4" />
                                    <?php } else { ?>
                                        <input type="checkbox" name="salary[]" value="4" id="price4" />
                                    <?php } ?>
                                    <label for="price4"></label>
                                    $499 to $999
                                </li>
                                <li>
                                    <?php if (isset($_GET['salary']) && in_array(5, $_GET['salary'])) { ?>
                                        <input type="checkbox" name="salary[]" value="5" checked id="price5" />
                                    <?php } else { ?>
                                        <input type="checkbox" name="salary[]" value="5" id="price5" />
                                    <?php } ?>
                                    <label for="price5"></label>
                                    $999 to $4999
                                </li>
                                <li>
                                    <?php if (isset($_GET['salary']) && in_array(6, $_GET['salary'])) { ?>
                                        <input type="checkbox" name="salary[]" value="6" checked id="price6" />
                                    <?php } else { ?>
                                        <input type="checkbox" name="salary[]" value="6" id="price6" />
                                    <?php } ?>
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
                                    <p>Posted <?= CommonFunction::dateDiffInDays($model->created_at) == 0 ? "Today" : CommonFunction::dateDiffInDays($model->created_at) . " days ago"; ?></p>
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
                    if (count($models) <= 0) {
                        echo "<h1>No Leads Found</h1>";
                    }
                    ?>
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
$emergency_prams = isset($_GET['emergency']) ? implode(',', $_GET['emergency']) : '';
$get_discipline_url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/get-discipline']);
$get_specialty_url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/get-specialty']);
$get_benefits_url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/get-benefits']);
$get_emergency_url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['browse-jobs/get-emergency']);
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();
$script_new = <<<JS
getDisciplineRecords();
getSpecialtyRecords();
getBenefitsRecords();
getEmergencyRecords();
        
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
        
    function getEmergencyRecords(pageno=0) {
        let params='$emergency_prams';
        let availabel=pageno;
        $.post("$get_emergency_url", {"$csrfParam":"$csrfToken",page: pageno,filter:params}, function(result){
             let data=JSON.parse(result);
            availabel+=data.offset;
            if(data.offset==0){
                $("#optionlist-emergency").html(data.options)
                let nextPage=parseInt(data.offset);
                if(data.options != ''){
                    $("#emergency-widget").append("<a href='javascript:void(0)' id='speciality-viewmore' onClick='getSpecialtyRecords("+nextPage+")'>View More</a>")
                }
            }else{
               $("#optionlist-emergency").append(data.options);
               $("#emergency-viewmore").remove();
               if(availabel<data.totalPage){
                    let nextPage=parseInt(data.offset);
                    if(data.options != ''){
                        $("#emergency-widget").append("<a href='javascript:void(0)' id='emergency-viewmore' onClick='getEmergencyRecords("+availabel+")'>View More</a>") 
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