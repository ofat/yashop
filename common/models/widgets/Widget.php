<?php

namespace yashop\common\models\widgets;

use yashop\common\helpers\Tree;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $alias
 *
 * @property WidgetDescription $description
 * @property WidgetDescription[] $allDescription
 * @property WidgetMenuItem[] $menuItems
 * @property WidgetPromoItem[] $promoItems
 */
class Widget extends ActiveRecord
{
    const TYPE_MENU = 1;
    const TYPE_PROMO = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'alias'], 'required'],
            [['type_id'], 'integer'],
            [['alias'], 'string', 'max' => 32],
            [['alias', 'type_id'], 'unique', 'targetAttribute' => ['alias', 'type_id'], 'message' => 'The combination of Type ID and Alias has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.widget', 'ID'),
            'type_id' => Yii::t('admin.widget', 'Type ID'),
            'alias' => Yii::t('admin.widget', 'Alias'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescription()
    {
        /**
         * @todo: change lang id to config
         */
        return $this->hasOne(WidgetDescription::className(), ['widget_id'=>'id'])->where(['language_id' => 2]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllDescription()
    {
        return $this->hasMany(WidgetDescription::className(), ['widget_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(WidgetMenuItem::className(), ['widget_id' => 'id'])->with('description');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromoItems()
    {
        return $this->hasMany(WidgetPromoItem::className(), ['widget_id' => 'id']);
    }

    public function getMenuTree()
    {
        $data = $this->getMenuItems()->orderBy('sort_order ASC')->asArray()->all();
        $items = [];

        if(empty($data))
            return $items;

        foreach($data as $item)
        {
            $items[ (int)$item['parent_id'] ][] = $item;
        }

        return Tree::createTree($items, $items[0]);
    }

    public function getMenuList()
    {
        $data = $this->getMenuItems()->orderBy('sort_order ASC')->asArray()->all();

        return Tree::getDropDownData($data, 'description.name');
    }
}
