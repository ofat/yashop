<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\helpers;

use Yii;
use yii\helpers\ArrayHelper;

class Tree
{
    /**
     * Prepare items for dropdown list
     * @param $data
     * @param string $name_key
     * @param string $parent_key
     * @return array
     */
    public static function getDropDownData($data, $name_key = 'en', $parent_key = 'parent_id')
    {
        $items = [];

        if(empty($data))
            return $items;

        foreach($data as $item)
        {
            $items[ (int)$item[ $parent_key ] ][] = $item;
        }
        $tree = self::createTree($items, $items[0]);

        $items = [0=>''];
        self::getList($items, $tree, 0, $name_key);
        return $items;
    }

    /**
     * Convert flat array to tree
     * @param $list
     * @param $parent
     * @return array
     */
    public static function createTree(&$list, $parent){
        $tree = array();
        foreach($parent as $item)
        {
            if(isset($list[ $item['id'] ])) {
                $item['children'] = self::createTree($list, $list[ $item['id'] ]);
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
     * @param $name_key
     */
    protected static function getList(&$items, $tree, $level, $name_key)
    {
        foreach($tree as $item)
        {
            $name = ArrayHelper::getValue($item, $name_key);
            $items[ $item['id'] ] = str_repeat('--', $level+1) . ' ' . $name;
            if(!isset($item['children']))
                continue;

            self::getList($items, $item['children'], $level+1, $name_key);
        }
    }

    /**
     * Return last level of children
     * @param $items
     * @return array
     */
    public static function getChildren($items)
    {
        $children = [];
        foreach($items as $item)
        {
            if(isset($item['children']))
                $children = ArrayHelper::merge($children, self::getChildren($item['children']));
            else
                $children[] = $item;
        }
        return $children;
    }

}