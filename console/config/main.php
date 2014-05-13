<?php

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'modules' => [
        'fake' => [
            'class' => 'yashop\console\modules\fake\FakeModule',
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@yashop-console/migrations',
        ],
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'templatePath' => '@yashop-common/tests/templates/fixtures',
            'fixtureDataPath' => '@yashop-common/tests/fixtures/data',
            'namespace' => 'yashop\common\tests\fixtures'
        ],
        'rbac' => [
            'class' => 'yashop\console\controllers\RbacController'
        ]
    ]
];
