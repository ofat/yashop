<?php

namespace yashop\common\models\cart;

use Yii;
use yashop\common\models\item\ItemSku;
use yashop\common\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cart_item".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sku_id
 * @property integer $num
 * @property string $description
 * @property integer $created_at
 *
 * @property ItemSku $sku
 * @property User $user
 * @property CartProperty[] $properties
 */
class CartItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sku_id', 'num'], 'required'],
            [['user_id', 'sku_id', 'num', 'created_at'], 'integer'],
            [['description'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cart', 'ID'),
            'user_id' => Yii::t('cart', 'User ID'),
            'sku_id' => Yii::t('cart', 'Sku ID'),
            'num' => Yii::t('cart', 'Num'),
            'description' => Yii::t('cart', 'Description'),
            'created_at' => Yii::t('cart', 'Created'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(CartProperty::className(), ['cart_item_id' => 'id']);
    }
}
