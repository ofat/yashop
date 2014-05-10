<?php
return [
    'name' => 'YaShop',
    'language' => 'ru',
    'components' => [
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
