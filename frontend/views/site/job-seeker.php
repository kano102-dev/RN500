<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\Pjax;
use common\CommonFunction;
use common\models\UserDetails;

$document_type = [0 => 'Resume', 1 => 'Other'];
$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
$frontendDir = yii\helpers\Url::base(true);
?>

<style>
    .ui-slider .ui-slider-range{background: #273bd6;}
</style>

<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="fixed-sidebar">

                    <div class="range-content">
                        <p class="title">Let's Improve Your Profile !</p>
                        <div class="profile-percent">
                            <a href="#" class="btn">Profile strength: <span id="profile-percentage"></span></a>
                        </div>
                        <div class="range"></div>
                    </div>

                    <ul class="usernavdash">
                        <li class="active"><a href="#update-account"><div class="round">1</div> Update account <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#job-search"><div class="round">2</div> Job Search<span class="round font-a"><i class="fa fa-angle-right"></i></span> </a></li>
                        <li><a href="#about-you"><div class="round">3</div> About You <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#work-experience"><div class="round">4</div> Work experience <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#education"><div class="round">5</div> Education <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#license"><div class="round">6</div> License <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#certifications"><div class="round">7</div> Certifications <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#documents"><div class="round">8</div> Documents <span class="round font-a"><i class="fa fa-angle-right"></i></span></a></li>
                        <li><a href="#references"><div class="round">9</div> References<span class="round font-a"><i class="fa fa-angle-right"></i></span> </a></li>
                    </ul>
                </div>
            </div>
            <?php Pjax::begin(['id' => 'job-seeker', 'enablePushState' => false]); ?>
            <div class="col-md-8 col-sm-6">
                <div class="myads">
                    <ul class="searchList new-searchList">
                        <!-- start -->
                        <li id="update-account">

                            <?php if (isset($userDetails) && !empty($userDetails)) { ?>
                                <div class="row">
                                    <div class="col-md-8 col-sm-8">
                                        <div class="jobimg">
                                            <?php if (isset($userDetails->profile_pic) && !empty($userDetails->profile_pic)) { ?>
                                                <img src="<?= $frontendDir . "/uploads/user-details/profile/" . $userDetails->profile_pic ?>" style="width:70px;height:70px;">
                                            <?php } else { ?>
                                                <img src="<?= $assetDir ?>/images/jobs/jobimg.jpg" style="width:70px;height:70px;">
                                            <?php } ?>

                                        </div>
                                        <div class="jobinfo">
                                            <h5><?= $userDetails->first_name . " " . $userDetails->last_name ?></h5>
                                            <div class="location"><?= Yii::$app->user->identity->email ?></div>
                                            <?php if (isset($userDetails->interest_level) && !empty($userDetails->interest_level)) { ?>
                                                <?php if ($userDetails->interest_level == UserDetails::ACTIVELY_LOOKING) { ?>
                                                    <p class="interest_level actively_looking"> Actively Looking</p>
                                                <?php } else if ($userDetails->interest_level == UserDetails::OPEN_TO_OFFERS) { ?>
                                                    <p class="interest_level open_to_offers"> Open To Offers</p>
                                                <?php } else { ?>
                                                    <p class="interest_level search_on_hold"> Search On Hold</p>
                                                <?php } ?>
                                            <?php } ?>
                                            
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                            <div class="companyName pull-right"><a href="#" url="<?= Yii::$app->urlManager->createUrl(['user-details/update', 'id' => Yii::$app->user->id]) ?>" class="btn btn-info editProfile" >Edit</a></div>
                                        <div class="listbtn">
                                            <!--<div class="round"><i class="fa fa-file"></i></div>-->
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </li>
                        <!-- end --> 

                        <!-- start -->
                        <li class="box-padding" id="about-you">
                            <div class="row">
                                <div class="col-md-8 col-sm-4 col-xs-12">
                                    <div class="jobinfo">
                                        <h3><a href="javascript:void(0);">About You</a></h3>
                                    </div>
                                    <div class="content">
                                        <p>Name</p>
                                        <p>Phone</p>
                                        <p>Email</p>
                                        <p>Last 4 of SSN</p>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php if (isset($userDetails) && !empty($userDetails)) { ?>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="jobinfo">
                                            <h3>&nbsp;</h3>
                                        </div>
                                        <div class="content">
                                            <p><?= $userDetails->first_name . " " . $userDetails->last_name ?></p>
                                            <p><?= (isset($userDetails->mobile_no) && !empty($userDetails->mobile_no)) ? $userDetails->mobile_no : "&nbsp;" ?></p>
                                            <p><?= (isset(Yii::$app->user->identity->email) && !empty(Yii::$app->user->identity->email)) ? Yii::$app->user->identity->email : "&nbsp;" ?></p>
                                            <p><?= (isset($userDetails->ssn) && !empty($userDetails->ssn)) ? $userDetails->ssn : "&nbsp;" ?></p>


                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-xs-12 info">
                                    <div class="">
                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/update', 'id' => Yii::$app->user->id]) ?>" class="editProfile">
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
                        <li class="box-padding" id="work-experience">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="jobinfo">
                                        <h3><a href="javascript:void(0);">Work Experience</a></h3>
                                    </div>
                                    <?php if (isset($workExperience) && !empty($workExperience)) { ?>
                                        <?php foreach ($workExperience as $key => $value) { ?>
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-sm-8 col-xs-9">
                                                        <h4><?= $value['title'] ?></h4>
                                                        <p><?= $value['discipline']['name'] ?></p>
                                                    </div>
                                                    <div class="col-sm-4 edit-icon-right col-xs-3">
                                                        <a href="#" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/work-experience?id=' . $value['id']]) ?>" class="work-experience"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-xs-12 info">
                                    <div class="">
                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/work-experience']) ?>" class="work-experience">
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
                        <li class="box-padding" id="education">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="jobinfo">
                                        <h3><a href="javascript:void(0);">Education</a></h3>
                                    </div>
                                    <?php if (isset($education) && !empty($education)) { ?>
                                        <?php foreach ($education as $key => $value) { ?>
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-sm-8 col-xs-9">
                                                        <h4><?= $value['institution'] ?></h4>
                                                        <p><?= Yii::$app->params['DEGREE_TYPE'][$value['degree_name']] ?></p>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-3 edit-icon-right">
                                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-education?id=' . $value['id']]) ?>" class="AddEducation"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-xs-12 info">
                                    <div class="">
                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-education']) ?>" class="AddEducation">
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
                        <li class="box-padding" id="license">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="jobinfo">
                                        <h3><a href="javascript:void(0);">Licenses</a></h3>
                                    </div>
                                    <?php if (isset($license) && !empty($license)) { ?>
                                        <?php foreach ($license as $key => $value) { ?>
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-sm-8 col-xs-9">
                                                        <h4><?= $value['license_number'] ?></h4>
                                                        <p><?= Yii::$app->params['LICENSE_TYPE'][$value['license_name']] ?></p>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-3 edit-icon-right">
                                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/delete-document?id=' . $value['id']]) ?>"  data-document="licenses" class="delete-documents"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-licence?id=' . $value['id']]) ?>" class="AddLicence"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-xs-12 info">
                                    <div class="">
                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-licence']) ?>" class="AddLicence">
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
                        <li class="box-padding" id="certifications">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="jobinfo">
                                        <h3><a href="javascript:void(0);">Certifications</a></h3>
                                    </div>
                                    <?php if (isset($certification) && !empty($certification)) { ?>
                                        <?php foreach ($certification as $key => $value) { ?>
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-sm-8 col-xs-9">
                                                        <h4><?= Yii::$app->params['CERTIFICATION_TYPE'][$value['certificate_name']] ?></h4>
                                                        <p>&nbsp;</p>
                                                    </div>
                                                    <div class="col-sm-4 edit-icon-right col-xs-3">
                                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/delete-document?id=' . $value['id']]) ?>"  data-document="certification" class="delete-documents"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-certification?id=' . $value['id']]) ?>" class="AddCertification "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-xs-12 info">
                                    <div class="">
                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-certification']) ?>" class="AddCertification">
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
                        <li class="box-padding" id="documents">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="jobinfo">
                                        <h3><a href="javascript:void(0);">Documents</a></h3>
                                    </div>
                                    <?php if (isset($documents) && !empty($documents)) { ?>
                                        <?php foreach ($documents as $key => $value) { ?>
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-sm-8 col-xs-9">
                                                        <h4><?= $document_type[$value['document_type']] ?></h4>

                                                        <?php if (file_exists(CommonFunction::getDocumentBasePath() . "/" . $value['path'])) { ?>
                                                            <p><?= $value['path'] ?></p>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-3 edit-icon-right">
                                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/delete-document?id=' . $value['id']]) ?>"  data-document="document" class="delete-documents"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-document?id=' . $value['id']]) ?>" class="AddDocument"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-xs-12 info">
                                    <div class="">
                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-document']) ?>" class="AddDocument">
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
                        <li class="box-padding" id="references">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="jobinfo">
                                        <h3><a href="javascript:void(0);">References</a></h3>
                                    </div>
                                    <?php if (isset($references) && !empty($references)) { ?>
                                        <?php foreach ($references as $key => $value) { ?>
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-sm-8 col-xs-9">
                                                        <h4><?= $value['first_name'] . " " . $value['last_name'] ?></h4>
                                                        <p><?= $value['email'] ?></p>
                                                    </div>
                                                    <div class="col-sm-4 edit-icon-right col-xs-3">
                                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-reference?id=' . $value['id']]) ?>" class="AddReference"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row action">
                                <div class="col-md-12 col-sm-12 col-xs-12 info">
                                    <div class="">
                                        <a href="javascript:void(0);" url="<?= Yii::$app->urlManagerFrontend->createUrl(['user-details/add-reference']) ?>" class="AddReference">
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

                    </ul>
                </div>
            </div>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>



<?php
$getProfilePercentageUrl = Yii::$app->urlManagerFrontend->createUrl(['user-details/get-profile-percentage']);

$js = <<< JS

$('#commonModal').on('shown.bs.modal', function() { 
       $('#overlay').hide();
});   
        
$(document).on("click", ".editProfile", function() {
    $('#overlay').show();
    $(".modal-title").text("Profile");
    $("#commonModal").modal('show')
        .find("#modalContent")
        .load($(this).attr('url'));
        
});
        
$(document).on("click", ".work-experience", function() {
    $('#overlay').show();    
    $(".modal-title").text("Work Experience");
    $("#commonModal").modal('show')
        .find("#modalContent")
        .load($(this).attr('url'));
}); 
    
$(document).on("click", ".AddEducation", function() {
    $('#overlay').show();    
    $(".modal-title").text("Education");
    $("#commonModal").modal('show')
        .find("#modalContent")
        .load($(this).attr('url'));
}); 
    
$(document).on("click", ".AddLicence", function() {
    $('#overlay').show();    
    $(".modal-title").text("Licence");
    $("#commonModal").modal('show')
        .find("#modalContent")
        .load($(this).attr('url'));
});

$(document).on("click", ".AddCertification", function() {
    $('#overlay').show();    
    $(".modal-title").text("Certification");
    $("#commonModal").modal('show')
        .find("#modalContent")
        .load($(this).attr('url'));
});
    
$(document).on("click", ".AddDocument", function() {
    $('#overlay').show();    
    $(".modal-title").text("Document");
    $("#commonModal").modal('show')
        .find("#modalContent")
        .load($(this).attr('url'));
});
    
$(document).on("click", ".AddReference", function() {
    $('#overlay').show();    
    $(".modal-title").text("Reference");
    $("#commonModal").modal('show')
        .find("#modalContent")
        .load($(this).attr('url'));
}); 
    
$(document).on("click", ".addPreference", function() {
    $('#overlay').show();    
    $(".modal-title").text("Job Preference");
    $("#commonModal").modal('show')
        .find("#modalContent")
        .load($(this).attr('url'));
});        
    

        
function getProfilePercentage(){
        $.ajax({
             url    : '$getProfilePercentageUrl',
             type   : 'post',
             success: function (response){
                 console.log('enter');   
                 try{
                     if(response){
                         $('#profile-percentage').text(response + "%");
                         $('.range').slider({
                            range: "min",
                            animate: true,
                            value: response,
                            min: 0,
                            max: 100,
                            step: 1,
                          });
                           
                     }
                 }catch(e){
                    
                 }
             }
         });
   
}
    
getProfilePercentage();  
    
$(window).scroll(function(){
  var scroll = $(window).scrollTop();    
  var profileSectionHeight = $('.listpgWraper').height() - 500;
       
  if(scroll >= 100 && scroll <= profileSectionHeight){
      $('.fixed-sidebar').addClass('sticky-sidebar');
      $('.font-a').css("right","-5px");  
   } else {
       $('.fixed-sidebar').removeClass('sticky-sidebar');
        $('.font-a').css("right","10px");
   }      
}); 
    
$(document).on('click','.delete-documents',function(){
      var document = $(this).data('document');  
      var url =   $(this).attr('url');
      swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete this Document !",
            icon: "warning",
            buttons: [
              'No, cancel it!',
              'Yes, I am sure!'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
              $.post(url, {document: document}, function(result){
                    if(result){
                         $("#commonModal").modal('hide');
                         $.pjax.reload({container: "#job-seeker", timeout: 2000});
                         $(document).on("pjax:success", "#job-seeker", function (event) {
                             $.pjax.reload({'container': '#res-messages', timeout: 2000});
                         });
                    }
                }); 
            }
          })
  });        
        
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>


