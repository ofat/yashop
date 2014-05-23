<?php
require_once __DIR__ . '/aliases.php';
$local = file_exists(__DIR__ . '/main-local.php') ? require __DIR__ . '/main-local.php' : [];
$params = file_exists(__DIR__ . '/params.php') ? require __DIR__ . '/params.php' : [];

return yii\helpers\ArrayHelper::merge(
    [
        'name' => 'YaShop',
        'language' => 'ru',
        'components' => [
            'user' => [
                'class' => 'yii\web\User',
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
                            'yii\bootstrap\NavBar',
                            'yashop\site\widgets\Menu'
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
            'assetManager' => [
                'bundles' => [

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
        'params' => $params
    ],
    $local
);