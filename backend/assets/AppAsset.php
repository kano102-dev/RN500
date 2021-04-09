<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/nav.css',
        'datatable/css/dataTables.bootstrap4.min.css',
    ];
    public $js = [
        'js/jquery.nestable.js',
        'datatable/js/jquery.dataTables.min.js',
        'datatable/js/dataTables.bootstrap4.min.js',
    ];
    public $depends = [
    ];

}
