<?php

namespace yashop\site\modules\cart\controllers;

use yashop\common\components\BaseController;
use yashop\common\models\cart\Cart;
use yashop\site\modules\cart\assets\CartAsset;
use Yii;
use yii\web\HttpException;

class DefaultController extends BaseController
{
    /**
     * @var Cart Instance of class Cart
     */
    protected $cart;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(parent::beforeAction($action)) {
            $this->cart = new Cart();
            return true;
        } else {
            return false;
        }
    }

    public function actionAdd($count, array $props, $sku_id)
    {
        if($this->cart->add($sku_id, $count, $props)) {
            return Yii::t('cart', 'Item added to cart');
        } else {
            throw new HttpException(500, Yii::t('base', 'An error has occurred'));
        }
    }

    public function actionRemove($sku_id)
    {
        if($this->cart->remove($sku_id)) {
            return true;
        } else {
            throw new HttpException(500, Yii::t('base', 'An error has occurred'));
        }
    }

    public function actionClear()
    {
        $this->cart->clear();
        return true;
    }

    public function actionIndex()
    {
        $this->cart->load(true);

        CartAsset::register(Yii::$app->view);

        return $this->render('index', ['cart' => $this->cart]);
    }

    public function actionReload()
    {
        return $this->render('reload');
    }
}
