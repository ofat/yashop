<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
namespace yashop\site\modules\cart\controllers;

use yashop\common\components\BaseController;
use yashop\common\models\cart\Cart;
use yashop\common\models\cart\CartItem;
use yashop\site\modules\item\models\ItemView;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\HttpException;

class PropertyController extends BaseController
{
    public function actionIndex($id)
    {
        $cartItem = CartItem::find()->with('properties', 'sku')->where(['sku_id'=>$id])->one();
        if(!$cartItem)
            throw new HttpException(400,Yii::t('base', 'An error has occurred'));

        $itemView = new ItemView($cartItem->sku->item_id);
        $item = $itemView->loadInputParams();
        $active_params = ArrayHelper::map($cartItem->properties, 'property_id', 'value_id');

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
        $cart->editProps($id, $newId, $params);

        return true;
    }
}