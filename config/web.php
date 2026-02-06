<?php

use app\events\eventHandlers\AddNewBooksEventHandler;
use app\models\activeRecords\Books;
use app\models\activeRecords\Subscribes;
use app\services\SmsPilotService;
use yii\base\Event;
use yii\di\Container;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wiG_2W7ZHCGOzA4rWd0hiSLlbgfWrS5Q',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\activeRecords\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',

                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>' => '<controller>/index',
            ],
        ],
    ],
    'container' => [
        'singletons' => [
            SmsPilotService::class => function (Container $container, $params, $config) {
                return new SmsPilotService($_ENV['SMSPILOT_APIKEY']);
            },
            AddNewBooksEventHandler::class => function(Container $container) {
                return new AddNewBooksEventHandler(
                    $container->get(SmsPilotService::class),
                    new Subscribes()
                );
            },
        ]
    ],
    // Обработка публикации автором новой книги. Шлются SMS всем подписчикам данного автора
    'on beforeRequest' => function() {
        /** @var AddNewBooksEventHandler $handler */
        $handler = Yii::$container->get(AddNewBooksEventHandler::class);

        Event::on(
            Books::class,
            Books::EVENT_AFTER_INSERT,
            [$handler, 'handle']
        );
    },
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
