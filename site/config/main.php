<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-site',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'yashop\site\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'yashop\common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login']
        ],
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
    ],
    'params' => $params,
];
