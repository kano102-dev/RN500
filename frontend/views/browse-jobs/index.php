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
?>
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
                                <input type="checkbox" name="checkname" value="1" id="shift-1" />
                                <label for="shift-1"></label>
                                All</li>
                            <li>
                                <input type="checkbox" name="checkname" value="2" id="shift-2" />
                                <label for="shift-2"></label>
                                Morning
                            </li>
                            <li>
                                <input type="checkbox" name="checkname" value="3" id="shift-3" />
                                <label for="shift-3"></label>
                                Evening
                            </li>
                            <li>
                                <input type="checkbox" name="checkname" value="4" id="shift-4" />
                                <label for="shift-4"></label>
                                Night
                            </li>
                            <li>
                                <input type="checkbox" name="checkname" value="5" id="shift-5" />
                                <label for="shift-5"></label>
                                Flatulate
                            </li>
                        </ul>
                    </div>

                    <!-- Jobs By Industry -->
                    <div class="widget">
                        <h4 class="widget-title">Location</h4>
                        <ul class="optionlist">
                            <li>
                                <input type="checkbox" name="checkname" id="infotech" />
                                <label for="infotech"></label>
                                Information Technology <span>22</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="advertise" />
                                <label for="advertise"></label>
                                Advertising/PR <span>45</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="services" />
                                <label for="services"></label>
                                Services <span>44</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="health" />
                                <label for="health"></label>
                                Health & Fitness <span>88</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="mediacomm" />
                                <label for="mediacomm"></label>
                                Media/Communications <span>22</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="fashion" />
                                <label for="fashion"></label>
                                Fashion <span>11</span> </li>
                        </ul>
                        <a href="#.">View More</a> </div>

                    <!-- Top Companies -->
                    <div class="widget">
                        <h4 class="widget-title">Benefits</h4>
                        <ul class="optionlist">
                            <li>
                                <input type="checkbox" name="checkname" id="Envato" />
                                <label for="Envato"></label>
                                Envato <span>12</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="Themefores" />
                                <label for="Themefores"></label>
                                Themefores <span>33</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="GraphicRiver" />
                                <label for="GraphicRiver"></label>
                                Graphic River <span>33</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="Codecanyon" />
                                <label for="Codecanyon"></label>
                                Codecanyon <span>33</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="AudioJungle" />
                                <label for="AudioJungle"></label>
                                Audio Jungle <span>33</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="Videohive" />
                                <label for="Videohive"></label>
                                Videohive <span>33</span> </li>
                        </ul>
                        <a href="#.">View More</a> </div>

                    <!-- Salary -->
                    <div class="widget">
                        <h4 class="widget-title">Salary Range</h4>
                        <ul class="optionlist">
                            <li>
                                <input type="checkbox" name="checkname" id="price1" />
                                <label for="price1"></label>
                                0 to $100 <span>12</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="price2" />
                                <label for="price2"></label>
                                $100 to $199 <span>41</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="price3" />
                                <label for="price3"></label>
                                $199 to $499 <span>33</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="price4" />
                                <label for="price4"></label>
                                $499 to $999 <span>66</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="price5" />
                                <label for="price5"></label>
                                $999 to $4999 <span>159</span> </li>
                            <li>
                                <input type="checkbox" name="checkname" id="price6" />
                                <label for="price6"></label>
                                Above $4999 <span>865</span> </li>
                        </ul>
                        <a href="#.">View More</a> </div>
                    <div class="searchnt">
                        <button class="btn"><i class="fa fa-search" aria-hidden="true"></i> Search Jobs</button>
                    </div>
                </div>
                <!-- Side Bar end --> 
            </div>
            <div class="col-md-9 col-sm-12"> 
                <!-- Search List -->
                <ul class="searchList">
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                    <!-- Candidate -->
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="Candidate Name" /></div>
                                <div class="jobinfo">
                                    <h3><a href="#.">Jhon Doe</a></h3>
                                    <div class="cateinfo">Java Developer</div>
                                    <div class="location"> New York City, New York</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="minsalary">$5000 <span>/ month</span></div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="listbtn"><a href="#.">View Profile</a></div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nulla eget nisl dapibus finibus. Maecenas quis sem vel neque rhoncus dignissim. Ut et eros rhoncus, gravida tellus auctor,</p>
                    </li>
                </ul>

                <!-- Pagination Start -->
                <div class="pagiWrap">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="showreslt">Showing 1-10</div>
                        </div>
                        <div class="col-md-8 col-sm-6 text-right">
                            <ul class="pagination">
                                <li class="active"><a href="#.">1</a></li>
                                <li><a href="#.">2</a></li>
                                <li><a href="#.">3</a></li>
                                <li><a href="#.">4</a></li>
                                <li><a href="#.">5</a></li>
                                <li><a href="#.">6</a></li>
                                <li><a href="#.">7</a></li>
                                <li><a href="#.">8</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$get_discipline_url = Yii::$app->urlManager->createAbsoluteUrl(['browse-jobs/get-discipline']);
$get_specialty_url = Yii::$app->urlManager->createAbsoluteUrl(['browse-jobs/get-specialty']);
$script_new = <<<JS
getDisciplineRecords();
getSpecialtyRecords();
        
    function getDisciplineRecords(pageno=0) {
        let availabel=pageno;
        $.get('$get_discipline_url?page='+pageno,function (result) {
            let data=JSON.parse(result);
            availabel+=data.offset;
            if(data.offset==0){
                $("#optionlist-discipline").html(data.options)
                let nextPage=parseInt(data.offset);
                $("#discipline-widget").append("<a href='javascript:void(0)' id='discipline-viewmore' onClick='getDisciplineRecords("+nextPage+")'>View More</a>")
            }else{
               $("#optionlist-discipline").append(data.options);
               $("#discipline-viewmore").remove();
               if(availabel<data.totalPage){
                    let nextPage=parseInt(data.offset);
                    $("#discipline-widget").append("<a href='javascript:void(0)' id='discipline-viewmore' onClick='getDisciplineRecords("+availabel+")'>View More</a>") 
               }
            }
        });
    }
        
    function getSpecialtyRecords(pageno=0) {
        let availabel=pageno;
        $.get('$get_specialty_url?page='+pageno,function (result) {
            let data=JSON.parse(result);
            availabel+=data.offset;
            if(data.offset==0){
                $("#optionlist-speciality").html(data.options)
                let nextPage=parseInt(data.offset);
                $("#speciality-widget").append("<a href='javascript:void(0)' id='speciality-viewmore' onClick='getSpecialtyRecords("+nextPage+")'>View More</a>")
            }else{
               $("#optionlist-speciality").append(data.options);
               $("#speciality-viewmore").remove();
               if(availabel<data.totalPage){
                    let nextPage=parseInt(data.offset);
                    $("#speciality-widget").append("<a href='javascript:void(0)' id='speciality-viewmore' onClick='getSpecialtyRecords("+availabel+")'>View More</a>") 
               }
            }
        });
    }
JS;
$this->registerJS($script_new, 3);
?>