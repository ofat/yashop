<?php

namespace site\controllers;

use site\models\ItemView;
use yii\web\Controller;

class ItemController extends Controller
{
    public function actionView($id)
    {
        $itemView = new ItemView($id);
        $item = $itemView->load();

        return $this->render('view', ['item'=>$item]);
    }

}
