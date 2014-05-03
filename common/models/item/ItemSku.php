<?php

namespace yashop\common\models\item;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "item_sku".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $num
 * @property string $price
 * @property string $promo_price
 * @property string $image
 * @property string $property_str
 *
 * @property ItemProperty[] $itemProperties
 * @property Item $item
 */
class ItemSku extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_sku';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'num', 'price', 'property_str'], 'required'],
            [['item_id', 'num'], 'integer'],
            [['price', 'promo_price'], 'number'],
            [['image', 'property_str'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('payment', 'ID'),
            'item_id' => Yii::t('payment', 'Item ID'),
            'num' => Yii::t('payment', 'Num'),
            'price' => Yii::t('payment', 'Price'),
            'promo_price' => Yii::t('payment', 'Promo Price'),
            'image' => Yii::t('payment', 'Image'),
            'property_str' => Yii::t('payment', 'Property Str'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemProperties()
    {
        return $this->hasMany(ItemProperty::className(), ['item_sku_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}
