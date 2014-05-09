<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\admin\modules\catalog\controllers;

use yashop\admin\models\ItemSearch;
use yashop\common\helpers\CrudController;
use yashop\common\models\item\Item;

class ItemController extends CrudController
{
    protected function getModel()
    {
        return Item::className();
    }

    protected function getSearchModel()
    {
        return ItemSearch::className();
    }
}