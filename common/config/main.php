<?php
return [
    'name' => 'YaShop',
    'language' => 'ru',
    'components' => [
        'user' => [
            'identityClass' => 'yashop\common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain' => '.yashop'
            ]
        ],
        'view' => [
            'defaultExtension' => 'twig',
            'renderers' => [
                'twig' => [
                    'class' => 'common\twig\ViewRenderer',
                    'options' => [
                        'cache' => false,
                        'autoescape' => true
                    ],
                    'namespaces' => [
                        'yii\bootstrap\NavBar'
                    ],
                    'globals' => [
                        'Html' => '\yii\helpers\Html',
                        'Base' => '\yashop\common\helpers\Base'
                    ],
                    'functions' => [
                        't' => '\Yii::t'
                    ]
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['user']
        ],
        'i18n' => [
            'translations' => [
                'cabinet.*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@yashop-common/messages',
                    'fileMap' => [
                        'cabinet.profile' => 'cabinet/profile.php',
                    ],
                ],
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@yashop-common/messages'
                ],
            ],
        ],
    ],
    'modules' => [
        'gii' => 'yii\gii\Module'
    ],
];
