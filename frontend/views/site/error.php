<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>

<style>
    .error-page .error{font-size: 175px !important;font-weight: bold;color: #1e71b5;font-weight: 600;}
    .error-page .btn{    border-radius: 50px;font-size: 18px;font-weight: 300;line-height: 1.33;color: #fffefe !important;padding: 10px 26px !important;background: #1d1d1d;border: 2px solid #1d1d1d;}
    .error-page .btn:focus {outline: none;}

</style>
<section class="error-page">
    <div class="container">
        <div class="row">
            <div class="well-lg"></div>
            <div class="col-md-12 col-12 text-center">       
                <h1 class="error">404</h1>
                <h1>Oops! Page Not Found!</h1>
                <p>
                    We're sorry, but the page you are looking for doesn't exist.
                </p>
            </div>
            <div class="col-md-12 col-12 text-center">
                <p>&nbsp;</p>
                <a href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl('/') ?>"><button class="btn pull-right"><i class="fa fa-arrow-left"></i> Back to Home</button></a>
            </div>
            <p class="m-0">&nbsp;</p>

        </div>
    </div>
</section>