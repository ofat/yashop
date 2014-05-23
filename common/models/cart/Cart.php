<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\models\cart;

/**
 * Base class for all operations with cart for guests and signed-in users
 * Class Cart
 * @package yashop\common\models\cart
 */
class Cart implements CartBase
{
    /**
     * @var Cart
     */
    protected $cart;

    /**
     *
     */
    public function __construct()
    {
        if(\Yii::$app->user->isGuest) {
            $this->cart = new CartGuest();
        } else {
            $this->cart = new CartUser(\Yii::$app->user->id);
        }
    }

    /**
     * @inheritdoc
     */
    public function add($sku_id, $num, $props, $description = false)
    {
        return $this->cart->add($sku_id, $num, $props, $description);
    }

    /**
     * @inheritdoc
     */
    public function remove($sku_id)
    {
        return $this->cart->remove($sku_id);
    }

    /**
     * @inheritdoc
     */
    public function editData($sku_id, $data)
    {
        return $this->cart->editData($sku_id, $data);
    }

    /**
     * @inheritdoc
     */
    public function editProps($sku_id, $props)
    {
        return $this->cart->editProps($sku_id, $props);
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        return $this->cart->clear();
    }

    /**
     * @inheritdoc
     */
    public function load($withParams = false)
    {
        return $this->cart->load($withParams);
    }
}