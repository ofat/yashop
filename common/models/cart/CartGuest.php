<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\models\cart;

/**
 * Class for operations with guest cart
 * Class CartGuest
 * @package yashop\common\models\cart
 */
class CartGuest implements CartBase
{
    /**
     * @inheritdoc
     */
    public function add($sku_id, $num, $props, $description = false)
    {

    }

    /**
     * @inheritdoc
     */
    public function remove($sku_id)
    {

    }

    /**
     * @inheritdoc
     */
    public function editData($sku_id, $data)
    {

    }

    /**
     * @inheritdoc
     */
    public function editProps($sku_id, $props)
    {

    }

    /**
     * @inheritdoc
     */
    public function clear()
    {

    }

    /**
     * @inheritdoc
     */
    public function load($withParams = false)
    {

    }
}