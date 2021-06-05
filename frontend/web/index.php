<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$configFile = '';
if ($_SERVER['SERVER_NAME'] == 'rn500.com') {
    $configFile = 'main.php';
} elseif ($_SERVER['SERVER_NAME'] == 'dev.rn500.com') {
    $configFile = 'main-stage.php';
} else {
    $configFile = 'main-local.php';
}
$config = yii\helpers\ArrayHelper::merge(
                require __DIR__ . '/../../common/config/' . $configFile,
                require __DIR__ . '/../config/' . $configFile);

(new yii\web\Application($config))->run();
