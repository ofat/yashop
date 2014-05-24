<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\models\cart;
use yashop\common\helpers\Base;
use yashop\common\helpers\Config;
use yashop\common\models\item\Item;
use yashop\common\models\item\ItemDescription;
use yashop\common\models\item\ItemSku;
use yashop\common\models\Property;
use yashop\common\models\PropertyDescription;
use yii\db\Query;
use yii\web\HttpException;

/**
 * Class for operations with signed-in user cart
 * Class CartUser
 * @package yashop\common\models\cart
 */
class CartUser extends CartBase
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
        $cartItem = $this->getModel($sku_id);
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
                foreach($props as $pid=>$vid)
                {
                    $cartProp = new CartProperty;
                    $cartProp->property_id = $pid;
                    $cartProp->value_id = $vid;
                    $cartProp->cart_item_id = $cartItem->id;
                    $r = $cartProp->save() && $r;
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
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function remove($sku_id)
    {
        CartItem::deleteAll(['user_id'=>$this->userId, 'sku_id'=>$sku_id]);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function editData($sku_id, $data)
    {
        $cartItem = $this->getModel($sku_id);
        $cartItem->setAttributes($data);

        return $cartItem->save();
    }

    /**
     * @inheritdoc
     */
    public function editProps($sku_id, $newId, $props)
    {
        $cartItem = $this->getModel($sku_id);
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $cartItem->sku_id = $newId;
            $r = $cartItem->save();
            CartProperty::deleteAll(['cart_item_id' => $cartItem->id]);
            foreach($props as $pid=>$vid)
            {
                $cartProp = new CartProperty;
                $cartProp->property_id = $pid;
                $cartProp->value_id = $vid;
                $cartProp->cart_item_id = $cartItem->id;
                $r = $cartProp->save() && $r;
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
        }
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        CartItem::deleteAll(['user_id' => $this->userId]);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function load($withParams = false)
    {
        $data = (new Query())
            ->select('cart_item.id AS cart_id, cart_item.num, cart_item.description, item_desc.name, item.image')
            ->addSelect('item_sku.price AS base_price, item_sku.promo_price, item_sku.image AS sku_image, item_sku.id, item_sku.item_id')
            ->from([
                'cart_item' => CartItem::tableName()
            ])
            ->where(['cart_item.user_id' => $this->userId])
            ->leftJoin(['item_sku' => ItemSku::tableName()], 'item_sku.id=cart_item.sku_id')
            ->leftJoin(['item' => Item::tableName()], 'item.id=item_sku.item_id')
            ->leftJoin(
                ['item_desc' => ItemDescription::tableName()],
                'item_desc.item_id = item_sku.item_id AND item_desc.language_id=:langId',
                [':langId'=>Config::getLanguage()]
            )
            ->orderBy('cart_item.created_at DESC')
            ->all();
        //echo '<pre>'; print_r($data); exit;
        $this->_sum = 0;
        $this->_count = 0;

        $ids = [];
        foreach($data as $k=>$item)
        {
            $id = $item['cart_id'];

            $image = $item['sku_image'] ? $item['sku_image'] : $item['image'];
            $data[$k]['image'] = $image;
            unset($item['sku_image']);

            $price = $item['promo_price'] ? $item['promo_price'] : $item['base_price'];
            $item['price'] = $price;
            $item['params'] = [];
            $this->_data[$id] = $item;

            $ids[] = $id;
            $this->_sum += Base::getPrice($item['num'], $price, false);
            $this->_count += $item['num'];
        }

        if($withParams) {
            $this->loadParams($ids);
        }
        return true;
    }

    protected function loadParams($ids)
    {
        $params = (new Query())
            ->select([
                'property'  => 'propertyDesc.name',
                'value'     => 'valueDesc.name',
                'id'        => 'cart_prop.cart_item_id'
            ])
            ->from(['cart_prop' => CartProperty::tableName()])
            ->where(['cart_prop.cart_item_id' => $ids])
            ->leftJoin(
                ['propertyDesc' => PropertyDescription::tableName()],
                'propertyDesc.property_id=cart_prop.property_id AND propertyDesc.language_id=:langId',
                [':langId'=>Config::getLanguage()]
            )
            ->leftJoin(
                ['valueDesc' => PropertyDescription::tableName()],
                'valueDesc.property_id=cart_prop.value_id AND valueDesc.language_id=:langId',
                [':langId'=>Config::getLanguage()]
            )
            ->all();
        //echo '<pre>'; print_r($params); exit;
        foreach($params as $param)
        {
            $id = $param['id'];
            unset($param['id']);
            $this->_data[$id]['params'][] = $param;
        }
    }

    /**
     * @inheritdoc
     */
    public function getMaxItems()
    {
        //todo: change to config param
        return 25;
    }

    /**
     * @param $id
     * @return null|CartItem
     */
    protected function getModel($id)
    {
        $params = [
            'user_id'   => $this->userId,
            'sku_id'    => $id
        ];

        $cartItem = CartItem::find()->where($params)->one();

        return $cartItem;
    }
}