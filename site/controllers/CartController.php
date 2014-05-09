<?php

namespace yashop\site\controllers;

use Yii;
use yii\web\Controller;

class CartController extends Controller
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
