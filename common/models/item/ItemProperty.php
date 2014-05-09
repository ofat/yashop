<?php

namespace yashop\common\models\item;

use Yii;
use yashop\common\models\Property;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "item_property".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $property_id
 * @property integer $value_id
 * @property integer $is_input
 *
 * @property Item $item
 * @property Property $property
 * @property Property $value
 */
class ItemProperty extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'property_id', 'value_id'], 'required'],
            [['item_id', 'property_id', 'value_id', 'is_input'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.item', 'ID'),
            'item_id' => Yii::t('admin.item', 'Item ID'),
            'property_id' => Yii::t('admin.item', 'Property ID'),
            'value_id' => Yii::t('admin.item', 'Value ID'),
            'is_input' => Yii::t('admin.item', 'Is Input'),
        ];
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
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValue()
    {
        return $this->hasOne(Property::className(), ['id' => 'value_id']);
    }
}
