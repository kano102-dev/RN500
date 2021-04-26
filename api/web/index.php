<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    //header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH, PUT, DELETE");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
 require(__DIR__ . '/../../common/config/bootstrap.php');
// Manage Config files for different servers
$configFile = "main-local.php";

$config = yii\helpers\ArrayHelper::merge(
                require(__DIR__ . '/../../common/config/main.php'),
                require(__DIR__ . '/../../common/config/' . $configFile),
                require(__DIR__ . '/../config/main.php'),
                require(__DIR__ . '/../config/main-local.php')
);
//echo "<pre/>";
//print_r($config);
//exit;
$application = new yii\web\Application($config);
$application->run();
