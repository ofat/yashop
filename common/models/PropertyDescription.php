<?php

namespace yashop\common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "property_description".
 *
 * @property integer $id
 * @property integer $property_id
 * @property integer $language_id
 * @property string $name
 *
 * @property Language $language
 * @property Property $property
 */
class PropertyDescription extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_description';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'language_id', 'name'], 'required'],
            [['property_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.property', 'ID'),
            'property_id' => Yii::t('admin.property', 'Property ID'),
            'language_id' => Yii::t('admin.property', 'Language ID'),
            'name' => Yii::t('admin.property', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
}
