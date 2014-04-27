<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $user = $auth->createRole('user');
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user);

        return 0;
    }

    public function actionAssign($userId, $roleName)
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole($roleName);
        $auth->assign($role, $userId);

        return 0;
    }
}