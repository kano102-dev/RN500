<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\components\FlashmessageWidget;

AppAsset::register($this);
$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
Yii::$app->assetManager->publish('@vendor/almasaeed2010/adminlte');
$assetThemeDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte');
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
        <link rel="stylesheet" href="<?php echo $assetThemeDir ?>/plugins/toastr/toastr.min.css">
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
        <?php
        $this->endBody();
        echo FlashmessageWidget::widget();
        ?>
        <script src="<?php echo $assetThemeDir ?>/plugins/toastr/toastr.min.js"></script>
    </body>
</html>
<?php $this->endPage() ?>