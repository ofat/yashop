<?php

namespace yashop\site\controllers;

use yashop\common\components\BaseController;
use yashop\site\models\ItemView;

class ItemController extends BaseController
{
    public function actionView($id)
    {
        $itemView = new ItemView($id);
        $item = $itemView->load();

        return $this->render('view', ['item'=>$item]);
    }

}
