<?php

namespace yashop\common\models\cart;

use Yii;

/**
 * This is the model class for table "cart_property".
 *
 * @property integer $id
 * @property integer $cart_item_id
 * @property integer $property_id
 * @property integer $value_id
 *
 * @property Property $value
 * @property CartItem $cartItem
 * @property Property $property
 */
class CartProperty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart_property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart_item_id', 'property_id', 'value_id'], 'required'],
            [['cart_item_id', 'property_id', 'value_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cart', 'ID'),
            'cart_item_id' => Yii::t('cart', 'Cart Item ID'),
            'property_id' => Yii::t('cart', 'Property ID'),
            'value_id' => Yii::t('cart', 'Value ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValue()
    {
        return $this->hasOne(Property::className(), ['id' => 'value_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartItem()
    {
        return $this->hasOne(CartItem::className(), ['id' => 'cart_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
}
