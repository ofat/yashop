<?php

$params = file_exists(__DIR__) . '/params.php' ? require(__DIR__ . '/params.php') : [];

return [
    'id' => 'app-site',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'yashop\site\controllers',
    'components' => [
        'urlManager' => [
            'rules' => [
                'item/<id:\d+>' => 'item/view',
                'cabinet/profile/address' => 'cabinet/address',
                'cabinet/profile/address/<action>' => 'cabinet/address/<action>'
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
            'errorAction' => 'site/error',
        ]
    ],
    'modules' => [
        'cabinet' => [
            'class' => 'yashop\site\modules\cabinet\CabinetModule',
        ],
        'item' => [
            'class' => 'yashop\site\modules\item\ItemModule',
        ],
        'cart' => [
            'class' => 'yashop\site\modules\cart\CartModule',
        ],
        'catalog' => [
            'class' => 'yashop\site\modules\catalog\CatalogModule',
        ]
    ],
    'params' => $params,
];