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
//$webImageDir = Yii::$app->assetManager->getPublishedUrl('@themes');
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
        
        <style>
            .header {background: #3ca0d6;}
            .listpgWraper {background: #f9f9ff;}
            .navbar-default .navbar-nav>.active>a{color: #fff;}
            .navbar-default .navbar-nav>li>a{color: #fff;}
            .navbar-nav>li>a:hover, .navbar-nav>li:hover>a, .navbar-nav>li.active>a {border-bottom-color: #26343c;}
            .topsearchwrap h4,.topsearchwrap h5{    background: #3ca0d6;}
            .carousel-item {
    height: 80vh;
    min-height: 350px;
    background: no-repeat center center scroll;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
        </style>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <!-- Header start -->
        <?= $this->render('header', ['assetDir' => $assetDir]) ?>
        <!-- Header end --> 

        <!-- Search start -->
        <div>
            <!--<div class="container">-->
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="background-image: url('https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/gettyimages-688899881-1519413300.jpg');">
                            <!--<img src="https://www.amny.com/wp-content/uploads/2020/03/GettyImages-1181858711-1024x683.jpg" alt="Los Angeles">-->
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
            <!--</div>-->
        </div>
        <!-- Search End --> 



        <?= $content ?>





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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" ></script>

        <script>

            $('.owl-carousel').owlCarousel({
                loop: true,
//                margin: 0,
//                nav: true,
//                navText: [
//                    "<i class='fa fa-caret-left'></i>",
//                    "<i class='fa fa-caret-right'></i>"
//                ],
                autoplay: true,
                autoplayHoverPause: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 7
                    }
                }
            })
        </script>
        <!--Footer end--> 

        <!--Copyright-->
        <div class="copyright">
            <div class="container">
                <div class="bttxt">Copyright &copy; 2017 RN500. All Rights Reserved. Design by: <a href="http://graphicriver.net/user/ecreativesol" target="_blank">eCreativeSolutions</a></div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
