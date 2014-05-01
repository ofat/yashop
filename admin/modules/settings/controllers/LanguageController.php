<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace admin\modules\settings\controllers;

use admin\models\LanguageSearch;
use Yii;
use common\models\Language;
use common\helpers\CrudController;

/**
 * LanguageController implements the CRUD actions for Country model.
 */
class LanguageController extends CrudController
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
        return Language::className();
    }

    protected function getSearchModel()
    {
        return LanguageSearch::className();
    }

}