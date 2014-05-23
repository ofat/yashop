<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\models\cart;
use yashop\common\models\item\ItemSku;
use yii\web\HttpException;

/**
 * Class for operations with signed-in user cart
 * Class CartUser
 * @package yashop\common\models\cart
 */
class CartUser implements CartBase
{
    protected $userId;

    public function __construct($id)
    {
        $this->userId = $id;
    }

    /**
     * @inheritdoc
     */
    public function add($sku_id, $num, $props, $description = false)
    {
        $sku = ItemSku::find()->with('item')->where(['id'=>$sku_id])->one();

        if(!$sku)
            return false;

        //Check if we have record with same params
        $params = [
            'user_id'   => $this->userId,
            'sku_id'    => $sku_id
        ];

        $cartItem = CartItem::find()->where($params)->one();
        if($cartItem) {
            $cartItem->num += $num;
            return $cartItem->save();
        }
        else
        {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $cartItem = new CartItem;
                $cartItem->user_id = $this->userId;
                $cartItem->num = $num;
                $cartItem->sku_id = $sku_id;
                $r = $cartItem->save();
                if(!$r)
                    throw new \Exception($cartItem->getErrors()[0]);
                foreach($props as $pid=>$vid)
                {
                    $cartProp = new CartProperty;
                    $cartProp->property_id = $pid;
                    $cartProp->value_id = $vid;
                    $cartProp->cart_item_id = $cartItem->id;
                    $r = $cartProp->save() && $r;
                    if(!$r)
                        throw new \Exception($cartProp->getErrors()[0]);
                }
                if($r) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
                return $r;
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw new HttpException(400, $e->getMessage());
                return false;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function remove($sku_id)
    {
        $params = [
            'user_id'   => $this->userId,
            'sku_id'    => $sku_id
        ];

        $cartItem = CartItem::find()->where($params)->one();

        return $cartItem ? $cartItem->delete() : false;
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
        CartItem::deleteAll('user_id=:uid', [':uid' => $this->userId]);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function load($withParams = false)
    {

    }
}