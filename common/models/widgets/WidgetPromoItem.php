<?php

namespace yashop\common\models\widgets;

use yashop\common\models\item\Item;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_promo_item".
 *
 * @property integer $id
 * @property integer $promo_id
 * @property integer $item_id
 * @property integer $sort_order
 *
 * @property Item $item
 * @property WidgetPromo $promo
 */
class WidgetPromoItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_promo_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promo_id', 'item_id', 'sort_order'], 'required'],
            [['promo_id', 'item_id', 'sort_order'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.promo', 'ID'),
            'promo_id' => Yii::t('admin.promo', 'Promo group'),
            'item_id' => Yii::t('admin.promo', 'Item ID'),
            'sort_order' => Yii::t('admin.promo', 'Sort Order'),
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
    public function getPromo()
    {
        return $this->hasOne(WidgetPromo::className(), ['id' => 'promo_id']);
    }
}
