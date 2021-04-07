<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $sourcePath = '@themes/jobs-portal';
    public $css = [
        'css/owl.carousel.css',
        'css/font-awesome.css',
        'css/main.css',
        'css/site.css',
    ];
    public $js = [
        'js/jquery-2.1.4.min.js',
        'js/owl.carousel.js',
        'js/script.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
