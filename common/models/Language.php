<?php

namespace yashop\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property string $code
 * @property integer $is_active
 * @property integer $is_default
 * @property integer $sort_order
 */
class Language extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_name', 'code'], 'required'],
            [['is_active', 'is_default', 'sort_order'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['short_name'], 'string', 'max' => 128],
            [['code'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.language', 'ID'),
            'name' => Yii::t('admin.language', 'Name'),
            'short_name' => Yii::t('admin.language', 'Short name'),
            'code' => Yii::t('admin.language', 'Code'),
            'is_active' => Yii::t('base', 'Is active'),
            'is_default' => Yii::t('base', 'Is default'),
            'sort_order' => Yii::t('base', 'Sort order'),
        ];
    }

    public static function getActive()
    {
        return static::find()->where('is_active=1')->all();
    }
}
