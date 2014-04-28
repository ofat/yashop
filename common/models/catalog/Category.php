<?php

namespace common\models\catalog;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $ru
 * @property string $en
 * @property string $url
 *
 * @property Item[] $items
 */
class Category extends \yii\db\ActiveRecord
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
            [['parent_id', 'ru', 'en', 'url'], 'required'],
            [['parent_id'], 'integer'],
            [['ru', 'en', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('payment', 'ID'),
            'parent_id' => Yii::t('payment', 'Parent ID'),
            'ru' => Yii::t('payment', 'Ru'),
            'en' => Yii::t('payment', 'En'),
            'url' => Yii::t('payment', 'Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['category_id' => 'id']);
    }
}
