<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use backend\assets\FontAwesomeAsset;
use backend\assets\AdminLteAsset;
use backend\assets\AppAsset;

AdminLteAsset::register($this);
FontAwesomeAsset::register($this);
AppAsset::register($this);
$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
Yii::$app->assetManager->publish('@vendor/almasaeed2010/adminlte');
$assetThemeDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?= Yii::$app->urlManagerAdmin->createUrl('//'); ?>/images/favicon.ico">
        <?php $this->registerCsrfMetaTags() ?>
        <title>RN500</title>
        <link rel="stylesheet" href="<?php echo $assetThemeDir ?>/plugins/toastr/toastr.min.css">
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini">
        <?php $this->beginBody() ?>

        <div class="wrapper">
            <!-- Navbar -->
            <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>

            <!-- Content Wrapper. Contains page content -->
            <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <?= $this->render('control-sidebar') ?>
            <!-- /.control-sidebar -->

            <!-- common modal -->
            <?= $this->render('common-modal') ?>
            <!-- /.common modal -->

            <!-- Main Footer -->
            <?= $this->render('footer') ?>
        </div>


        <?php
        $this->endBody();
        echo \common\components\FlashmessageWidget::widget();
        ?>

        <script src="<?php echo $assetThemeDir ?>/plugins/toastr/toastr.min.js"></script>
    </body>
</html>
<?php $this->endPage() ?>

<style>
    ol.breadcrumb{
        background-color: white !important;
        border: 1px solid #ececec !important;
        padding: 10px !important;
    }
</style>