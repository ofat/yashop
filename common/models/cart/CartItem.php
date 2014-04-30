<?php

namespace common\models\cart;

use Yii;

/**
 * This is the model class for table "cart_item".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $user_id
 * @property integer $sku_id
 * @property integer $num
 * @property string $description
 * @property integer $created
 *
 * @property ItemSku $sku
 * @property Item $item
 * @property User $user
 * @property CartProperty[] $cartProperties
 */
class CartItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'user_id', 'sku_id', 'num', 'created'], 'required'],
            [['item_id', 'user_id', 'sku_id', 'num', 'created'], 'integer'],
            [['description'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cart', 'ID'),
            'item_id' => Yii::t('cart', 'Item ID'),
            'user_id' => Yii::t('cart', 'User ID'),
            'sku_id' => Yii::t('cart', 'Sku ID'),
            'num' => Yii::t('cart', 'Num'),
            'description' => Yii::t('cart', 'Description'),
            'created' => Yii::t('cart', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSku()
    {
        return $this->hasOne(ItemSku::className(), ['id' => 'sku_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartProperties()
    {
        return $this->hasMany(CartProperty::className(), ['cart_item_id' => 'id']);
    }
}
