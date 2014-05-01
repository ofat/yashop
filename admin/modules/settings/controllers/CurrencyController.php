<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace admin\modules\settings\controllers;

use admin\models\CurrencySearch;
use Yii;
use common\models\Currency;
use common\helpers\CrudController;

/**
 * LanguageController implements the CRUD actions for Country model.
 */
class CurrencyController extends CrudController
{

    protected function getActionsList()
    {
        return ['index', 'list', 'view', 'create'];
    }

    public function actionCreate()
    {
        return $this->actionView(0);
    }

    protected function getModel()
    {
        return Currency::className();
    }

    protected function getSearchModel()
    {
        return CurrencySearch::className();
    }

}