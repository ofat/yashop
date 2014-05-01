<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $name
 * @property string $mask
 * @property integer $is_active
 * @property integer $is_default
 * @property integer $is_main
 * @property integer $sort_order
 * @property string $rate
 */
class Currency extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'mask'], 'required'],
            [['is_active', 'is_default', 'is_main'], 'integer'],
            [['rate'], 'number'],
            [['name', 'mask'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.currency', 'ID'),
            'name' => Yii::t('admin.currency', 'Name'),
            'mask' => Yii::t('admin.currency', 'Mask'),
            'is_active' => Yii::t('base', 'Is active'),
            'is_default' => Yii::t('base', 'Is default'),
            'is_main' => Yii::t('base', 'Is main'),
            'rate' => Yii::t('admin.currency', 'Rate'),
            'sort_order' => Yii::t('base', 'Sort order')
        ];
    }
}
