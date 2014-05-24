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
use yashop\common\models\PropertyDescription;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Cookie;

/**
 * Class for operations with guest cart
 * Class CartGuest
 * @package yashop\common\models\cart
 */
class CartGuest extends CartBase
{
    /**
     * @var string
     */
    protected $cookieName = 'yashop_cart';

    /**
     * @var int Period for saving data in cookie. Default: 10 days
     */
    protected $cookiePeriod = 864000;

    /**
     * @inheritdoc
     */
    public function add($sku_id, $num, $props, $description = false)
    {
        $sku = ItemSku::find()->where(['id'=>$sku_id])->one();

        if(!$sku)
            return false;

        $cart = $this->getCart();

        //check if we have record with same parameters
        if(isset($cart[ $sku_id ]))
        {
            $cart[$sku_id]['num'] += $num;
        }
        else
        {
            $cart[$sku_id] = array(
                'sku_id'        => $sku_id,
                'num'           => $num,
                'description'   => '',
                'params'        => Json::encode($props),
                'created_at'    => time()
            );
        }

        return $this->saveCart($cart);
    }

    /**
     * @inheritdoc
     */
    public function remove($sku_ids)
    {
        $cart = $this->getCart();
        foreach($sku_ids as $sku_id)
            unset($cart[$sku_id]);

        return $this->saveCart($cart);
    }

    /**
     * @inheritdoc
     */
    public function editData($sku_id, $data)
    {
        $cart = $this->getCart();
        if(isset($cart[$sku_id])) {
            $cart[$sku_id] = ArrayHelper::merge($cart[$sku_id], $data);
        }

        return $this->saveCart($cart);
    }

    /**
     * @inheritdoc
     */
    public function editParams($sku_id, $new_id, $props)
    {
        $cart = $this->getCart();
        if(isset($cart[$sku_id])) {
            $item = $cart[$sku_id];
            unset($cart[$sku_id]);
            $item['params'] = Json::encode($props);
            $item['sku_id'] = $new_id;
            $cart[$new_id] = $item;
        }

        return $this->saveCart($cart);
    }

    public function getParams($sku_id)
    {
        $cart = $this->getCart();
        if(isset($cart[$sku_id]))
            return Json::decode($cart[$sku_id]['params']);
        else
            return [];
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        return $this->saveCart([]);
    }

    /**
     * @inheritdoc
     */
    public function load($withParams = false)
    {
        $cart = $this->getCart();
        $data = (new Query())
            ->select('item_desc.name, item.image, item_sku.price AS base_price, item_sku.promo_price')
            ->addSelect('item_sku.image AS sku_image, item_sku.id, item_sku.item_id')
            ->from([
                'item_sku' => ItemSku::tableName()
            ])
            ->where(['item_sku.id' => array_keys($cart)])
            ->leftJoin(['item' => Item::tableName()], 'item.id=item_sku.item_id')
            ->leftJoin(
                ['item_desc' => ItemDescription::tableName()],
                'item_desc.item_id = item_sku.item_id AND item_desc.language_id=:langId',
                [':langId'=>Config::getLanguage()]
            )
            ->all();
        //echo '<pre>'; print_r($data); exit;
        $this->_sum = 0;
        $this->_count = 0;

        $ids = [];
        foreach($data as $k=>$item)
        {
            $id = $item['id'];

            $image = $item['sku_image'] ? $item['sku_image'] : $item['image'];
            $data[$k]['image'] = $image;
            unset($item['sku_image']);

            $price = $item['promo_price'] ? $item['promo_price'] : $item['base_price'];
            $item['price'] = $price;
            $item['params'] = [];
            $item = ArrayHelper::merge($item, $cart[$id]);
            $this->_data[$id] = $item;

            $ids[] = $id;
            $this->_sum += Base::getPrice($item['num'], $price, false);
            $this->_count += $item['num'];
        }

        if($withParams) {
            $this->loadParams();
        }

        uasort($this->_data, function($a, $b){
            return $a['created_at'] < $b['created_at'];
        });

        return true;
    }

    protected function loadParams()
    {
        $properties = [];
        foreach($this->_data as $k=>$item)
        {
            $params = Json::decode($item['params']);
            $this->_data[$k]['params'] = $params;
            $properties = ArrayHelper::merge($properties, array_keys($params), array_values($params));
        }
        $property = (new Query())
            ->select([
                'propertyDesc.name',
                'propertyDesc.property_id'
            ])
            ->distinct(true)
            ->from(['propertyDesc' => PropertyDescription::tableName()])
            ->where(['propertyDesc.property_id' => $properties])
            ->all();
        $properties = ArrayHelper::map($property, 'property_id', 'name');
        foreach($this->_data as $k=>$item)
        {
            $params = [];
            foreach($item['params'] as $pid=>$vid)
            {
                $params[] = [
                    'property' => $properties[$pid],
                    'property_id' => $pid,
                    'value' => $properties[$vid],
                    'value_id' => $vid
                ];
            }
            $this->_data[$k]['params'] = $params;
        }
    }

    /**
     * @inheritdoc
     */
    public function getMaxItems()
    {
        return 10;
    }

    /**
     * Get cart data from cookie
     * @return array
     */
    protected function getCart()
    {
        $cookie = Yii::$app->request->cookies->getValue( $this->cookieName );
        if(!$cookie) {
            $data = [];
        } else {
            $data = Json::decode($cookie);
        }

        $cart = array();
        foreach($data as $item)
        {
            $cart[ $item['sku_id'] ] = $item;
        }
        return $cart;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function saveCart($data)
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => $this->cookieName,
            'value' => Json::encode($data),
            'expire' => time() + $this->cookiePeriod
        ]));
        return true;
    }
}