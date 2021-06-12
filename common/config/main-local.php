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
        'socialShare' => [
            'class' => \ymaker\social\share\configurators\Configurator::class,
            'socialNetworks' => [
                'Twitter' => [
                    'class' => \ymaker\social\share\drivers\Twitter::class,
                    'label' => \yii\helpers\Html::tag('i', '', ['class' => 'fa fa-twitter-square','style'=>"font-size: 27px;"]),
                ],
                'Gmail' => [
                    'class' => \ymaker\social\share\drivers\Gmail::class,
                    'label' => \yii\helpers\Html::tag('i', '', ['class' => 'fa fa-envelope','style'=>"font-size: 27px;"]),
                ],
                'LinkedIn' => [
                    'class' => \ymaker\social\share\drivers\LinkedIn::class,
                    'label' => \yii\helpers\Html::tag('i', '', ['class' => 'fa fa-linkedin-square','style'=>"font-size: 27px;"]),
                ],
                'Facebook' => [
                    'class' => \ymaker\social\share\drivers\Facebook::class,
                    'label' => \yii\helpers\Html::tag('i', '', ['class' => 'fa fa-facebook-square','style'=>"font-size: 27px;"]),
                ],
            ],
        ],
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
