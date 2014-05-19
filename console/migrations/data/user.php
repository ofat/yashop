<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
use yii\helpers\Security;

return [
    [
        'username' => 'admin',
        'auth_key' => Security::generateRandomKey(),
        'password_hash' => Security::generatePasswordHash('admin'),
        'password_reset_token' => Security::generateRandomKey() . '_' . time(),
        'created_at' => time(),
        'updated_at' => time(),
        'email' => 'admin@test.com',
    ]
];