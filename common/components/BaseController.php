<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\components;

use yashop\common\helpers\Config;
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if(parent::beforeAction($action)) {
            Yii::$app->language = Config::getLanguageCode();
            return true;
        } else {
            return false;
        }
    }
}