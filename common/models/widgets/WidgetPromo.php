<?php

namespace common\models\widgets;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_promo".
 *
 * @property integer $id
 * @property string $ru
 * @property string $en
 * @property string $alias
 *
 * @property WidgetPromoItem[] $widgetPromoItems
 */
class WidgetPromo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_promo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ru', 'en', 'alias'], 'required'],
            [['ru', 'en'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 32],
            [['alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.promo', 'ID'),
            'ru' => Yii::t('admin.promo', 'Ru'),
            'en' => Yii::t('admin.promo', 'En'),
            'alias' => Yii::t('admin.promo', 'Alias'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(WidgetPromoItem::className(), ['promo_id' => 'id'])->orderBy('sort_order ASC');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getAttribute(Yii::$app->language);
    }
}
