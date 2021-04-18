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
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'useFileTransport' => false,
//            'viewPath' => '@common/mail',
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.sendgrid.net',
//                'username' => 'apikey',
////                'password' => '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',
//                'password' => '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',
//                'port' => '587',
//                'encryption' => 'tls',
//            ],
//        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.rn500.com',
                'username' => 'info@rn500.com',
                'password' => 'frGNIZab6gcR',
                'port' => '26',
//                'host' => 'smtp.sendgrid.net',
//                'username' => 'apikey',
//                'password' => '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',
//                'password' => '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',
//                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-rn500', 'httpOnly' => true],
            'authTimeout' => 172800,
            'loginUrl' => 'http://localhost/rn500/auth/login'
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'rn500',
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
