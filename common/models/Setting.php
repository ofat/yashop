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
 *
 * @property string|integer|float $value
 * @property string $type
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

    /**
     * @return float|int|string
     */
    public function getValue()
    {
        if(!is_null($this->value_string))
            return $this->value_string;

        if(!is_null($this->value_integer))
            return $this->value_integer;

        if(!is_null($this->value_float))
            return $this->value_float;
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        switch($this->type)
        {
            case 'integer':
                $this->value_integer = $value;
                break;
            case 'float':
                $this->value_float = $value;
                break;
            case 'string':
            default:
                $this->value_string = $value;
        }
    }

    /**
     * @return string
     */
    public function getType()
    {
        if(!is_null($this->value_string))
            return 'string';

        if(!is_null($this->value_integer))
            return 'integer';

        if(!is_null($this->value_float))
            return 'float';
    }
}
