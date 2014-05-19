<?php

namespace yashop\common\models\widgets;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_menu_item".
 *
 * @property integer $id
 * @property integer $widget_id
 * @property integer $parent_id
 * @property string $url
 * @property integer $sort_order
 *
 * @property WidgetMenuItem $parent
 * @property WidgetMenuItem[] $widgetMenuItems
 * @property Widget $widget
 * @property WidgetMenuDescription $description
 * @property WidgetMenuDescription[] $allDescription
 */
class WidgetMenuItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id', 'url'], 'required'],
            [['widget_id', 'parent_id', 'sort_order'], 'integer'],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('widget', 'ID'),
            'widget_id' => Yii::t('admin.menu', 'Menu type'),
            'parent_id' => Yii::t('admin.menu', 'Parent menu item'),
            'ru' => Yii::t('base', 'Russian'),
            'en' => Yii::t('base', 'English'),
            'url' => Yii::t('admin.menu', 'Url'),
            'sort_order' => Yii::t('admin.menu', 'Sort order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(WidgetMenuItem::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(WidgetMenuItem::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidget()
    {
        return $this->hasOne(Widget::className(), ['id' => 'widget_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllDescription()
    {
        return $this->hasMany(WidgetMenuDescription::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescription()
    {
        /**
         * @todo: make language from config
         */
        return $this->hasOne(WidgetMenuDescription::className(), ['item_id' => 'id'])->where(['language_id' => 2]);
    }
}
