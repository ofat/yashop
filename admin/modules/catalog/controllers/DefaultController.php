<?php

namespace yashop\admin\modules\catalog\controllers;

use yashop\common\components\BaseController;

class DefaultController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
