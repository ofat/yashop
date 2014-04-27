<?php

namespace admin\controllers;

use common\helpers\CrudController;
use Yii;
use common\models\User;
use admin\models\UserSearch;
use common\models\search\AddressSearch;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends CrudController
{

    protected function getActionsList()
    {
        return array_merge(parent::getActionsList(),['address']);
    }

    public function actionAddress($id)
    {
        $searchModel = new AddressSearch();
        $params = [
            'AddressSearch' => [
                'user_id' => $id
            ]
        ];
        $dataProvider = $searchModel->search($params);

        $userModel = $this->findModel($id);

        return $this->render('address', [
            'data' => $dataProvider,
            'userModel' => $userModel
        ]);
    }

    protected function getModel()
    {
        return User::className();
    }

    protected function getSearchModel()
    {
        return UserSearch::className();
    }

}
