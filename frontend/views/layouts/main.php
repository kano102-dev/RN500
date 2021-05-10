<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use ranamehul20\twak\TwakWidget;

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
            .listpgWraper {background: #f9f9ff;}
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

        <?= $content ?>

        <?= TwakWidget::widget(['key' => '609387b9185beb22b30a8c79/1f504kd7t']) ?>
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
