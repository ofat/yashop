<?php

namespace yashop\site\modules\cabinet\controllers;

use yashop\site\modules\cabinet\CabinetController;

class DefaultController extends CabinetController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
