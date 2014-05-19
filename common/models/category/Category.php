<?php

namespace yashop\common\models\category;

use yashop\common\helpers\Config;
use yashop\common\helpers\Tree;
use Yii;
use yii\db\ActiveRecord;

use yashop\common\models\item\Item;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $url
 * @property integer $is_active
 *
 * @property CategoryDescription $description
 * @property CategoryDescription[] $allDescription
 * @property Item[] $items
 */
class Category extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'is_active'], 'integer'],
            [['url'], 'required'],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.category', 'ID'),
            'parent_id' => Yii::t('admin.category', 'Parent category'),
            'url' => Yii::t('admin.category', 'URL'),
            'is_active' => Yii::t('base', 'Is active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescription()
    {
        return $this->hasOne(CategoryDescription::className(), ['category_id' => 'id'])->where(['language_id' => Config::getLanguage()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllDescription()
    {
        return $this->hasMany(CategoryDescription::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['category_id' => 'id']);
    }

    public static function getList()
    {
        $data = static::find()->where('is_active=1')->with('description')->asArray()->all();
        return Tree::getDropDownData($data,'description.name');
    }
}