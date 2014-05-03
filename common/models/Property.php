<?php

namespace yashop\common\models;

use Yii;
use yashop\common\models\item\ItemProperty;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "property".
 *
 * @property integer $id
 * @property string $ru
 * @property string $en
 * @property integer $type
 *
 * @property ItemProperty[] $itemProperties
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
            [['type'], 'required'],
            [['type'], 'integer'],
            [['ru', 'en'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('payment', 'ID'),
            'ru' => Yii::t('payment', 'Ru'),
            'en' => Yii::t('payment', 'En'),
            'type' => Yii::t('payment', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemProperties()
    {
        return $this->hasMany(ItemProperty::className(), ['value_id' => 'id']);
    }
}
