<?php

namespace admin\modules\settings\controllers;

use Yii;
use common\models\Country;
use admin\models\CountrySearch;
use common\helpers\CrudController;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends CrudController
{

    protected function getActionsList()
    {
        return ['index', 'list', 'view','create', 'switch'];
    }

    public function actionSwitch()
    {
        $selection = Yii::$app->request->get('selection');
        $type = Yii::$app->request->get('type', 'on');
        Country::setActive(array_values($selection), ($type == 'on'));
        return $this->redirect(['list']);
    }

    public function actionCreate()
    {
        return $this->actionView(0);
    }

    protected function getModel()
    {
        return Country::className();
    }

    protected function getSearchModel()
    {
        return CountrySearch::className();
    }

}