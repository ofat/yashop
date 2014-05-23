<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\models\cart;

interface CartBase
{
    /**
     * Add item to cart
     * @param $sku_id
     * @param $num
     * @param $props
     * @param bool $description
     * @return mixed
     */
    function add($sku_id, $num, $props, $description = false);

    /**
     * Remove item from cart
     * @param $sku_id
     * @return boolean
     */
    function remove($sku_id);

    /**
     * Edit base data in cart
     * @param $sku_id
     * @param $data
     * @return boolean
     */
    function editData($sku_id, $data);

    /**
     * Edit item properties in cart
     * @param $sku_id
     * @param $props
     * @return boolean
     */
    function editProps($sku_id, $props);

    /**
     * Remove all items from cart
     * @return boolean
     */
    function clear();

    /**
     * Load data from cart
     * @param bool $withParams
     * @return mixed
     */
    function load($withParams = false);
}