<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'I`m local',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'ru-RU',
    'sourceLanguage'=>'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
    ],
    'components' => [
        // Настройки компонента приложения auth client collection (аутентификация через соцсети)
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '332679075210-j6m3l81a7l7e03k6tesu55a3s7imhq28.apps.googleusercontent.com',
                    'clientSecret' => 'qx3_MPoNXCEsZkwy-ozaeQKr',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '353139508888425',
                    'clientSecret' => '37947c11ad826a9a562d6d2a7f3dac89',
                ],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '6996626',
                    'clientSecret' => '6OnBqAoUj00nOTScATQy',
                    'scope' => ['email']
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'asdfasudfhqwbhfdashkashdflashd',
            // Для того чтобы API мог принимать данные в формате JSON
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => '#########@gmail.com',
                'password' => '#########',
                'port' => '587',
                'encryption' => 'tls',
            ],
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
        // Включаем красивые адреса, в том числе для API.
        'urlManager' => [
            'enablePrettyUrl' => true,
//            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '<action:(login)>' => 'site/login',
                '<action:(logout)>' => 'site/logout',
                '<action:(favorites)>' => 'site/favorites',
                '<action:(policy)>' => 'site/policy',
                '<controller:(shop)>s' => '<controller>/index',
                '<controller:(shop)>s/<id:\d+>' => '<controller>/view',
                '<controller:(shop)>s/<id:\d+>/<action:(view|update|delete)>' => '<controller>/<action>',
                '<controller:(shop)>s/<action:(rating)>' => '<controller>/<action>',
                '<controller:(shop)>/<action:(create)>' => '<controller>/create-step-1',
                '<controller:(shop)>s/<id:\d+>/<action:(update/photo)>' => '<controller>/create-step-2',
                '<controller:(shop)>s/<id:\d+>/<action:(update/address)>' => '<controller>/create-step-3',
                '<controller:(shop)>s/<id:\d+>/<action:(update/prices)>' => '<controller>/create-step-4',
                '<controller:(event)>s' => '<controller>/index',
                '<controller:(event)>s/<id:\d+>' => '<controller>/view',
                '<controller:(event)>s/<id:\d+>/<action:(view|update|delete)>' => '<controller>/<action>',
                '<controller:(event)>/<action:(create)>' => '<controller>/create-step-1',
                '<controller:(event)>s/<id:\d+>/<action:(update/info)>' => '<controller>/create-step-2',
                '<controller:(event)>s/<id:\d+>/<action:(update/photo)>' => '<controller>/create-step-3',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/shop'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/user'],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
