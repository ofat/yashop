<?php

namespace yashop\admin\modules\widgets\controllers;

use yashop\common\components\BaseController;

class DefaultController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
