<?php

namespace yashop\common\models\item;

use Yii;
use yii\db\ActiveRecord;
use yashop\common\models\catalog\Category;

/**
 * This is the model class for table "item".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $image
 * @property string $price
 * @property string $promo_price
 * @property integer $num
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property Category $category
 * @property ItemImage[] $itemImages
 * @property ItemProperty[] $itemProperties
 * @property ItemSku[] $itemSkus
 */
class Item extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'image', 'price', 'num', 'updated_at', 'created_at'], 'required'],
            [['category_id', 'num', 'updated_at', 'created_at'], 'integer'],
            [['price', 'promo_price'], 'number'],
            [['title_ru', 'title_en', 'image'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('payment', 'ID'),
            'category_id' => Yii::t('payment', 'Category ID'),
            'image' => Yii::t('payment', 'Image'),
            'price' => Yii::t('payment', 'Price'),
            'promo_price' => Yii::t('payment', 'Promo Price'),
            'num' => Yii::t('payment', 'Num'),
            'updated_at' => Yii::t('payment', 'Updated At'),
            'created_at' => Yii::t('payment', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemImages()
    {
        return $this->hasMany(ItemImage::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemProperties()
    {
        return $this->hasMany(ItemProperty::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemSkus()
    {
        return $this->hasMany(ItemSku::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemDescription()
    {
        /**
         * todo: change lang id from config
         */
        return $this->hasOne(ItemDescription::className(), ['item_id' => 'id', 'language_id' => 2]);
    }
}
