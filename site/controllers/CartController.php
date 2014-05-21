<?php

namespace yashop\site\controllers;

use yashop\common\components\BaseController;
use Yii;

class CartController extends BaseController
{
    public function actionAdd()
    {
        return $this->render('add');
    }

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionReload()
    {
        return $this->render('reload');
    }

    public function actionRemove()
    {
        return $this->render('remove');
    }

}
