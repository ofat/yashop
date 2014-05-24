<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\models\cart;

/**
 * Base class for all operations with cart for guests and signed-in users
 * Class Cart
 * @property integer $maxItems
 *
 * @package yashop\common\models\cart
 */
class Cart extends CartBase
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
        if(!is_array($sku_id))
            $sku_id = array($sku_id);
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
    public function editProps($sku_id, $newId, $props)
    {
        return $this->cart->editProps($sku_id, $newId, $props);
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

    /**
     * @inheritdoc
     */
    public function getMaxItems()
    {
        return $this->cart->getMaxItems();
    }

    /**
     * @inheritdoc
     */
    public function getCountItems()
    {
        return $this->cart->getCountItems();
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return $this->cart->getData();
    }

    public function getSum()
    {
        return $this->cart->getSum();
    }
}