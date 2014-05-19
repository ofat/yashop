<?php

namespace yashop\common\models\widgets;

use Yii;
use yii\db\ActiveRecord;
use yashop\common\models\Language;

/**
 * This is the model class for table "widget_description".
 *
 * @property integer $id
 * @property integer $widget_id
 * @property integer $language_id
 * @property string $name
 * @property string $description
 *
 * @property Language $language
 * @property Widget $widget
 */
class WidgetDescription extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_description}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id', 'language_id', 'name', 'description'], 'required'],
            [['widget_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 512],
            [['widget_id'], 'unique'],
            [['language_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.widget', 'ID'),
            'widget_id' => Yii::t('admin.widget', 'Widget ID'),
            'language_id' => Yii::t('admin.widget', 'Language ID'),
            'name' => Yii::t('admin.widget', 'Name'),
            'description' => Yii::t('admin.widget', 'Description'),
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
    public function getWidget()
    {
        return $this->hasOne(Widget::className(), ['id' => 'widget_id']);
    }
}
