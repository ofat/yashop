<?php

namespace yashop\site\modules\item\controllers;

use Yii;
use yashop\site\modules\item\models\ItemView;
use yashop\common\components\BaseController;
use yii\helpers\Json;
use yii\web\View;

class DefaultController extends BaseController
{

    protected $itemAsset = '\yashop\site\modules\item\assets\ItemAsset';

    public function actionIndex($id)
    {
        $itemView = new ItemView($id);
        $item = $itemView->load();

        $this->registerScripts($item);
        return $this->render('index', ['item'=>$item]);
    }

    protected function registerScripts($item)
    {
        $className = $this->itemAsset;
        $className::register(Yii::$app->view);

        $params = Json::encode($item->sku);
        $js = '';
        $js .= "yashop.item.sku.params = ".$params."; \n";
        $js .= "yashop.item.price = ".$item->price."; \n";
        $js .= "yashop.item.id = ".$item->getId()."; \n";
        Yii::$app->view->registerJs($js, View::POS_END);
    }
}
