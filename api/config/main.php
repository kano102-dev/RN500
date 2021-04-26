<?php

$paramsFile = "params-local.php";
$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'),
        // require(__DIR__ . '/../../common/config/params-local.php'),
        require(__DIR__ . '/params.php'),
        require(__DIR__ . '/' . $paramsFile)
);
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => Yii::getAlias('@api') . '/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    // Using this for website maintenance. If maintenance_mode is ON , All APIs will return message in response
    'on beforeRequest' => function ($event) {
        if (Yii::$app->params['maintenance_mode'] == 'ON') {
            echo "The site is currently under maintenance.";
            die;
        }
    },
    'components' => [
        'Controller' => [
            'class' => 'api\modules\v1\components\Controller',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        // 'enableSession'=>true,
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '0ZXOYLjsL_iEZCeqIuz0q4tnY69dQxVo',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                    'logFile' => $params['logPath'] . "/error/error.log",
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
            // [
            //     'class' => 'yii\log\FileTarget',
            //     'levels' => ['info'],
            //     'categories' => ['lifetime_points'],
            //     'logFile' => $params['logPath']."/lifetime_points/lifetime_points.log",
            //     'logVars' => [],
            //     'maxFileSize' => 1024 * 2,
            //     'maxLogFiles' => 20,
            // ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/country',
                ],
            ],
        ]
    ],
    'params' => $params,
];
