<?php

namespace admin\controllers;

use common\helpers\CrudController;
use Yii;
use common\models\User;
use admin\models\UserSearch;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends CrudController
{
    protected function getModel()
    {
        return User::className();
    }

    protected function getSearchModel()
    {
        return UserSearch::className();
    }

}
