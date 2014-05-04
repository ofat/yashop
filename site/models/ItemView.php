<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\models;

use yashop\common\models\item\ItemDescription;
use yashop\common\models\item\ItemProperty;
use yashop\common\models\item\ItemSku;
use yashop\common\models\Property;
use Yii;
use yashop\common\models\item\ItemImage;
use yashop\common\models\item\Item;
use yii\db\Query;
use yii\web\NotFoundHttpException;

class ItemView extends Item
{
    /**
     * @var int Item ID
     */
    private $_id;

    /**
     * @var string Item title
     */
    public $title;

    /**
     * @var array Item images
     */
    public $images = [];

    /**
     * @var array Item params
     */
    public $params = [];

    /**
     * @param array Item input params
     */
    public $inputParams = [];

    /**
     * @var array Item Sku
     */
    public $sku = [];

    /**
     * @var float Min price
     */
    public $priceMin = PHP_INT_MAX;

    /**
     * @var float Max price
     */
    public $priceMax;

    /**
     * @var float Min promo price
     */
    public $promoPriceMin;

    /**
     * @var float Max promo price
     */
    public $promoPriceMax;


    public function __construct($id)
    {
        $this->_id = $id;
    }

    /**
     * Load all item data
     * @return ItemView|bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function load()
    {
        $this
            ->loadBase()
            ->loadImages()
            ->loadParams()
            ->prepareInputParams()
            ->prepareParams()
            ->loadSku()
            ->getSkuInfo();

        return $this;
    }

    /**
     * Loading base item data
     * @return $this
     * @throws \yii\web\NotFoundHttpException
     */
    protected  function loadBase()
    {
        $base = (new Query())
            ->select(['base.*', 'desc.title'])
            ->from([
                'base' => Item::tableName(),
            ])
            ->where(['base.id'=>$this->_id])
            ->leftJoin(['desc' => ItemDescription::tableName()], 'desc.item_id = base.id')
            ->one();

        if(empty($base))
            throw new NotFoundHttpException(Yii::t('yii','The requested page does not exist.'));

        $this->title = $base['title'];
        $this->setAttributes($base);

        return $this;
    }

    /**
     * Loading item images
     * @return $this
     */
    protected function loadImages()
    {
        $data = (new Query())
            ->select('image')
            ->from(ItemImage::tableName())
            ->where(['item_id'=>$this->_id])
            ->all();

        foreach($data as $item)
        {
            $this->images[] = $item['image'];
        }

        return $this;
    }

    /**
     * Loading all item params
     * @return $this
     */
    protected function loadParams()
    {
        $lang = Yii::$app->language;

        $this->params = (new Query())
            ->select([
                'property'  => 'property.'.$lang,
                'value'     => 'value.'.$lang,
                'is_input',
                'property_id',
                'value_id'
            ])
            ->from(['param'=>ItemProperty::tableName()])
            ->where(['item_id'=>$this->_id])
            ->leftJoin(['property' => Property::tableName()], 'property.id = param.property_id')
            ->leftJoin(['value' => Property::tableName()], 'value.id = param.value_id')
            ->all();

        return $this;
    }

    /**
     * Preparing input params
     * @return $this
     */
    protected function prepareInputParams()
    {
        foreach($this->params as $param)
        {
            if(!$param['is_input'])
                continue;

            $param_id = $param['property_id'];
            if(!isset($this->inputParams[$param_id]))
                $this->inputParams[$param_id] = [
                    'name' => $param['property'],
                    'id' => $param_id,
                    'items' => []
                ];

            $this->inputParams[$param_id]['items'][] = [
                'name' => $param['value'],
                'id' => $param['value_id']
            ];
        }

        return $this;
    }

    /**
     * Preparing item params for table view
     * @return $this;
     */
    protected function prepareParams()
    {
        $data = $this->params;
        $this->params = [];
        foreach($data as $item)
        {
            $key = $item['property'];
            if(!isset($this->params[ $key ]))
                $this->params[$key] = [];

            $this->params[$key][] = $item['value'];
        }
        return $this;
    }

    /**
     * Loading item sku
     * @return $this
     */
    protected function loadSku()
    {
        $this->sku = (new Query())
            ->select('id,num,price,promo_price,image,property_str')
            ->from(ItemSku::tableName())
            ->where(['item_id'=>$this->_id])
            ->all();

        return $this;
    }

    /**
     * Preparing sku info for getting min/max prices
     * @return $this
     */
    protected function getSkuInfo()
    {
        foreach($this->sku as $sku)
        {
            if($sku['price'] > $this->priceMax)
                $this->priceMax = $sku['price'];

            if($sku['price'] < $this->priceMin)
                $this->priceMin = $sku['price'];

            if($sku['promo_price'] > $this->promoPriceMax)
                $this->promoPriceMax = $sku['promo_price'];

            if($sku['promo_price'] < $this->promoPriceMin)
                $this->promoPriceMin = $sku['promo_price'];
        }

        return $this;
    }
}