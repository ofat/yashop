<?php

namespace yashop\site\controllers;

use yashop\common\components\BaseController;
use yashop\common\models\cart\Cart;
use Yii;

class CartController extends BaseController
{
    public function actionAdd($count, array $props, $sku_id)
    {
        $cart = new Cart();
        if($cart->add($sku_id, $count, $props)) {
            return Yii::t('cart', 'Item added to cart');
        } else {
            return Yii::t('cart', 'Error adding');
        }
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
