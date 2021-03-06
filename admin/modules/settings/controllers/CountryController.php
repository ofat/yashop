<?php

namespace yashop\admin\modules\settings\controllers;

use Yii;
use yashop\common\models\Country;
use yashop\admin\models\CountrySearch;
use yashop\common\components\CrudController;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends CrudController
{

    protected function getActionsList()
    {
        return ['index', 'list', 'view','create', 'switch', 'switch-all'];
    }

    public function actionSwitch()
    {
        $selection = Yii::$app->request->get('selection');
        $type = Yii::$app->request->get('type', 'on');
        if(!empty($selection))
            Country::setActive(array_values($selection), ($type == 'on'));
        return $this->redirect(['list']);
    }

    public function actionSwitchAll()
    {
        $type = Yii::$app->request->get('type', 'on');
        Country::setActiveAll($type == 'on');
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