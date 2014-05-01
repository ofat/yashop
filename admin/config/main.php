<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'dashboard',
    'modules' => [
        'settings' => [
            'class' => 'admin\modules\settings\SettingsModule'
        ],
        'widgets' => [
            'class' => 'admin\modules\widgets\WidgetsModule',
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => 'login'
        ],
        'urlManager' => [
            'rules' => [
                'login' => 'dashboard/login',
                'logout' => 'dashboard/logout'
            ]
        ],
        'urlManagerSite' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => 'http://yashop/',
            'enablePrettyUrl' => true
        ],
        'i18n' => [
            'translations' => [
                'admin.*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@app/../common/messages',
                    'fileMap' => [
                        'admin.country' => 'admin/country.php',
                        'admin.menu' => 'admin/menu.php',
                        'admin.promo' => 'admin/promo.php',
                        'admin.language' => 'admin/language.php',
                        'admin.currency' => 'admin/currency.php'
                    ],
                ],
            ]
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
        'errorHandler' => [
            'errorAction' => 'dashboard/error',
        ],
    ],
    'params' => $params,
];
