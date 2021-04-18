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
        </style>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <!-- Header start -->
        <?= $this->render('header', ['assetDir' => $assetDir]) ?>
        <!-- Header end --> 

        <?= $content ?>

        <!-- Footer start -->
        <?= $this->render('footer', ['assetDir' => $assetDir]) ?>
        <!-- Footer end --> 
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
