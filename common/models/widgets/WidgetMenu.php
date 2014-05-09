<?php

namespace yashop\common\models\widgets;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_menu".
 *
 * @property integer $id
 * @property string $ru
 * @property string $en
 * @property string $alias
 *
 * @property WidgetMenuItem[] $widgetMenuItems
 */
class WidgetMenu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ru', 'en', 'alias'], 'required'],
            [['ru', 'en'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('widget', 'ID'),
            'ru' => Yii::t('widget', 'Ru'),
            'en' => Yii::t('widget', 'En'),
            'alias' => Yii::t('widget', 'Alias'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(WidgetMenuItem::className(), ['menu_id' => 'id']);
    }

    /**
     * Get tree of menu items
     * @return array
     */
    public function getChildrenTree()
    {
        $data = $this->getItems()->orderBy('sort_order ASC')->asArray()->all();
        $items = [];

        if(empty($data))
            return $items;

        foreach($data as $item)
        {
            $items[ (int)$item['parent_id'] ][] = $item;
        }

        return $this->createTree($items, $items[0]);
    }

    /**
     * Get menu items for dropdown list
     * @return array
     */
    public function getChildrenList()
    {
        $data = $this->getItems()->orderBy('sort_order ASC')->asArray()->all();
        $items = [];

        if(empty($data))
            return $items;

        foreach($data as $item)
        {
            $items[ (int)$item['parent_id'] ][] = $item;
        }
        $tree = $this->createTree($items, $items[0]);

        $items = [0=>''];
        $this->getList($items, $tree, 0);
        return $items;
    }

    /**
     * Convert flat array to tree
     * @param $list
     * @param $parent
     * @return array
     */
    protected function createTree(&$list, $parent){
        $tree = array();
        foreach($parent as $item)
        {
            if(isset($list[ $item['id'] ])) {
                $item['children'] = $this->createTree($list, $list[ $item['id'] ]);
            }
            $tree[] = $item;
        }
        return $tree;
    }

    /**
     * Get hierarchical array from tree. For dropdown list
     * @param $items
     * @param $tree
     * @param $level
     */
    protected function getList(&$items, $tree, $level)
    {
        foreach($tree as $item)
        {
            $items[ $item['id'] ] = str_repeat('--', $level+1) . ' ' . $item[ Yii::$app->language ];
            if(!isset($item['children']))
                continue;

            $this->getList($items, $item['children'], $level+1);
        }
    }
}
