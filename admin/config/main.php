<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'yashop\admin\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'dashboard',
    'modules' => [
        'settings' => [
            'class' => 'yashop\admin\modules\settings\SettingsModule'
        ],
        'widgets' => [
            'class' => 'yashop\admin\modules\widgets\WidgetsModule',
        ],
        'catalog' => [
            'class' => 'yashop\admin\modules\catalog\CatalogModule',
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'yashop\common\models\User',
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
            'enablePrettyUrl' => true
        ],
        'i18n' => [
            'translations' => [
                'admin.*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@yashop-common/messages',
                    'fileMap' => [
                        'admin.country'  => 'admin/country.php',
                        'admin.menu'     => 'admin/menu.php',
                        'admin.promo'    => 'admin/promo.php',
                        'admin.language' => 'admin/language.php',
                        'admin.currency' => 'admin/currency.php',
                        'admin.category' => 'admin/category.php',
                        'admin.item'     => 'admin/item.php',
                        'admin.settings' => 'admin/settings.php'
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
