<?php

namespace yashop\console\modules\fake\controllers;

use yii\console\Controller;
use yii\helpers\FileHelper;

class DefaultController extends Controller
{
    public function actionIndex()
    {

    }

    protected function getImportList()
    {
        $files = FileHelper::findFiles(__DIR__);
        $subject = implode('',$files);
        $pattern = '~controllers/((?!Base|Default).*?)\.php~';
        $matches = array();
        preg_match_all($pattern, $subject, $matches);

        return $matches[1];
    }
}
