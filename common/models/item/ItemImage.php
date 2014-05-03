<?php

namespace yashop\common\models\item;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "item_image".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $image
 *
 * @property Item $item
 */
class ItemImage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'image'], 'required'],
            [['item_id'], 'integer'],
            [['image'], 'string', 'max' => 512]
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
            'image' => Yii::t('payment', 'Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}
