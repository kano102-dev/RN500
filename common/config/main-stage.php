<?php

$db = require __DIR__ . '/test.php';
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => $db,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.rn500.com',
                'username' => 'info@rn500.com',
                'password' => 'welcome@12345',
                'port' => '26',
                'encryption' => 'tls',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-rn500', 'httpOnly' => true],
            'authTimeout' => 120000,
            'loginUrl' => '/auth/login'
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'rn500',
        ],
        'urlManagerAdmin' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class' => 'yii\web\UrlManager',
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
