<?php

namespace site\modules\cabinet\controllers;

use site\modules\cabinet\CabinetController;

class DefaultController extends CabinetController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
