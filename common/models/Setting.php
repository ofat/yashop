<?php

namespace yashop\common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property string $value_string
 * @property integer $value_integer
 * @property double $value_float
 */
class Setting extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'label'], 'required'],
            [['value_integer'], 'integer'],
            [['value_float'], 'number'],
            [['name'], 'string', 'max' => 32],
            [['label'], 'string', 'max' => 64],
            [['value_string'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.settings', 'ID'),
            'name' => Yii::t('admin.settings', 'Name'),
            'label' => Yii::t('admin.settings', 'Label'),
            'value_string' => Yii::t('admin.settings', 'Value String'),
            'value_integer' => Yii::t('admin.settings', 'Value Integer'),
            'value_float' => Yii::t('admin.settings', 'Value Float'),
        ];
    }
}
