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
        'css/animate.css',
        'css/custom-adminpanel.css',
    ];
    public $js = [
        'js/jquery.nestable.js',
        'js/jquery.table2excel.min.js',
        'datatable/js/jquery.dataTables.min.js',
        'datatable/js/dataTables.bootstrap4.min.js',
    ];
    public $depends = [
    ];

}
