<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\models\cart;

abstract class CartBase
{
    protected $_sum;

    protected $_count;

    protected $_data;

    /**
     * Add item to cart
     * @param $sku_id
     * @param $num
     * @param $props
     * @param bool $description
     * @return mixed
     */
    abstract function add($sku_id, $num, $props, $description = false);

    /**
     * Remove item from cart
     * @param $sku_id
     * @return boolean
     */
    abstract function remove($sku_id);

    /**
     * Edit base data in cart
     * @param $sku_id
     * @param $data
     * @return boolean
     */
    abstract function editData($sku_id, $data);

    /**
     * Edit item properties in cart
     * @param $sku_id
     * @param $props
     * @return boolean
     */
    abstract function editProps($sku_id, $props);

    /**
     * Remove all items from cart
     * @return boolean
     */
    abstract function clear();

    /**
     * Load data from cart
     * @param bool $withParams
     * @return mixed
     */
    abstract function load($withParams = false);

    /**
     * Max number of items that user can add to cart
     * @return integer
     */
    abstract function getMaxItems();

    /**
     * Number of items that user added to cart
     * @return integer
     */
    public function getCountItems()
    {
        return $this->_count;
    }

    /**
     * Return total sum for all items
     * @return float
     */
    public function getSum()
    {
        return $this->_sum;
    }

    /**
     * Return all items data
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }
}