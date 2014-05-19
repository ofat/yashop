<?php

namespace yashop\common\models;

use yashop\common\helpers\Config;
use Yii;
use yashop\common\models\item\ItemProperty;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "property".
 *
 * @property integer $id
 * @property integer $parent_id
 *
 * @property ItemProperty[] $itemProperties
 * @property PropertyDescription $description
 */
class Property extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['parent_id', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.property', 'ID'),
            'parent_id' => Yii::t('admin.property', 'Parent id'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemProperties()
    {
        return $this->hasMany(ItemProperty::className(), ['value_id' => 'id']);
    }

    public function getDescription()
    {
        return $this->hasOne(PropertyDescription::className(), ['property_id' => 'id'])->where(['language_id' => Config::getLanguage()]);
    }
}
