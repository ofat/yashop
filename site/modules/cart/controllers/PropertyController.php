<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
namespace yashop\site\modules\cart\controllers;

use yashop\common\components\BaseController;
use yashop\common\models\cart\Cart;
use yashop\common\models\item\ItemSku;
use yashop\site\modules\item\models\ItemView;
use Yii;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\HttpException;

class PropertyController extends BaseController
{
    public function actionIndex($id)
    {
        $itemId = (new Query())->select('item_id')->from(ItemSku::tableName())->where(['id'=>$id])->scalar();
        if(!$itemId)
            throw new HttpException(400,Yii::t('base', 'An error has occurred'));

        $itemView = new ItemView($itemId);
        $item = $itemView->loadInputParams();

        $cart = new Cart();
        $active_params = $cart->getParams($id);

        $params = Json::encode($item->sku);
        $js = "yashop.cart.property.params = $params; \n";
        Yii::$app->view->registerJs($js);

        return $this->renderAjax('input_params',array(
            'params'   => $item->inputParams,
            'active_params' => $active_params
        ));
    }

    public function actionSave($id, $newId)
    {
        $params = Yii::$app->request->get('params');

        $cart = new Cart();
        $cart->editParams($id, $newId, $params);

        return true;
    }
}