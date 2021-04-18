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
                <div class="item active">
                    <img src="<?= $assetDir . "/images/1 Brooklyn_Bridge.jpg" ?>" alt="Los Angeles" style="width:100%;">
                </div>

                <div class="item">
                    <img src="<?= $assetDir . "/images/2B (1).jpg" ?>" alt="Chicago" style="width:100%;">
                </div>

                <div class="item">
                    <img src="<?= $assetDir . "/images/3BB.jpg" ?>" alt="New york" style="width:100%;">
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



        <?= $content ?>


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
        <!-- Footer start -->
        <?= $this->render('footer', ['assetDir' => $assetDir]) ?>
        <!-- Footer end --> 
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
