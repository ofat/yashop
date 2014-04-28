<?php

namespace common\models\widgets;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_menu_item".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $parent_id
 * @property string $ru
 * @property string $en
 * @property string $url
 * @property integer $sort_order
 *
 * @property WidgetMenuItem $parent
 * @property WidgetMenuItem[] $widgetMenuItems
 * @property WidgetMenu $menu
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
            [['menu_id', 'ru', 'en', 'url', 'sort_order'], 'required'],
            [['menu_id', 'parent_id', 'sort_order'], 'integer'],
            [['ru', 'en', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('widget', 'ID'),
            'menu_id' => Yii::t('admin.menu', 'Menu type'),
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
    public function getMenu()
    {
        return $this->hasOne(WidgetMenu::className(), ['id' => 'menu_id']);
    }
}
