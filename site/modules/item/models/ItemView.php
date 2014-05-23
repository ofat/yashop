<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\modules\item\models;

use yashop\common\helpers\Base;
use yashop\common\helpers\Config;
use yashop\common\models\item\ItemDescription;
use yashop\common\models\item\ItemProperty;
use yashop\common\models\item\ItemSku;
use yashop\common\models\PropertyDescription;
use Yii;
use yashop\common\models\item\ItemImage;
use yashop\common\models\item\Item;
use yii\db\Query;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;

class ItemView extends Item
{
    const SIZE_PROPERTY = 'property';
    const SIZE_THUMBNAIL = 'thumbnail';
    const SIZE_MAIN = 'main';
    const SIZE_FULL = 'full';

    /**
     * @var int Item ID
     */
    protected $_id;

    /**
     * @var string Item name
     */
    public $name;

    /**
     * @var string Item html title
     */
    public $title;

    /**
     * @var string Item description
     */
    public $description;

    /**
     * @var string Item html meta description
     */
    public $meta_desc;

    /**
     * @var string Item html meta keywords
     */
    public $meta_keyword;

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
            ->select(['base.*', 'desc.*'])
            ->from([
                'base' => Item::tableName(),
            ])
            ->where(['base.id'=>$this->_id])
            ->leftJoin(['desc' => ItemDescription::tableName()], 'desc.item_id = base.id')
            ->one();

        if(empty($base))
            throw new NotFoundHttpException(Yii::t('yii','The requested page does not exist.'));

        $this->title = $base['title'];
        $this->name = $base['name'];
        $this->description = $base['description'];
        $this->meta_desc = $base['meta_desc'];
        $this->meta_keyword = $base['meta_keyword'];
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
        $langId = Config::getLanguage();

        $this->params = (new Query())
            ->select([
                'property'  => 'propertyDesc.name',
                'value'     => 'valueDesc.name',
                'is_input',
                'param.property_id',
                'param.value_id',
                'image'
            ])
            ->from(['param'=>ItemProperty::tableName()])
            ->where(['param.item_id'=>$this->_id])
            ->leftJoin(
                ['propertyDesc' => PropertyDescription::tableName()],
                'propertyDesc.property_id=param.property_id AND propertyDesc.language_id=:langId',
                [':langId'=>$langId]
            )
            ->leftJoin(
                ['valueDesc' => PropertyDescription::tableName()],
                'valueDesc.property_id=param.value_id AND valueDesc.language_id=:langId',
                [':langId' => $langId]
            )
            ->all();

        return $this;
    }

    /**[
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
                'image' => $param['image'],
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
        $sku = (new Query())
            ->select('id,num,price,promo_price,property_str')
            ->from(ItemSku::tableName())
            ->where(['item_id'=>$this->_id])
            ->all();

        foreach($sku as $data)
        {
            $prop_str = $data['property_str'];
            unset($data['property_str']);
            $data['num'] = Yii::t('item', '{n, plural, =0{no} other{# pcs.}}', ['n'=>$data['num']]);
            $this->sku[$prop_str] = $data;
        }

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

    public function getPrice()
    {
        if($this->priceMin != $this->priceMax)
        {
            return Yii::t('item', 'от {price}', ['price' => Base::formatMoney($this->priceMin)]);
        }

        return Base::formatMoney($this->priceMin);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param $image
     * @param string $size
     * @return string
     */
    public static function getImagePath($image, $size = self::SIZE_FULL)
    {
        /**
         * @todo: Change sizes to config params
         */
        $sizes = [
            'main' => [390,390],
            'thumbnail' => [40,40],
            'property' => [30,30],
            'full' => [0,0]
        ];
        $url = Yii::$app->params['staticUrl'].'/items/';

        list($width, $height) = $sizes[ $size ];
        $ext = pathinfo($image, PATHINFO_EXTENSION);

        if($size == self::SIZE_FULL)
            return $url.$image;
        else
            return $url.$image.'_'.$width.'x'.$height.'.'.$ext;
    }
}