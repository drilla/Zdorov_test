<?php
use backend\models\User;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'urlManager' => [
            'class' => \yii\web\UrlManager::class,
            'enablePrettyUrl' => true, // запрещаем r= routes
            'showScriptName'  => false, // запрещаем index.php
            'rules' => [
                '/'                                 => 'site/index',
                'error'                             => 'site/error',
                'user'                              => 'user/list',
                'user/edit/<id:\d+>'                => 'user/edit',
                'user/delete/<id:\d+>'              => 'user/delete',
                'product/toggle-state/<id:\d+>'     => 'product/toggle-state',
                'order-history/list/<order_id:\d+>' => 'order-history/list',

                '<action:\w+>'                      => 'site/<action>',
                '<controller:\w+>/<action:\w+>'     => '<controller>/<action>',
            ],
        ],
        'user' => [
            'class' => \backend\components\User::class,
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
