<?php

namespace yashop\common\models\widgets;

use Yii;
use yii\db\ActiveRecord;
use yashop\common\models\Language;

/**
 * This is the model class for table "widget_menu_description".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $language_id
 * @property string $name
 * @property string $title
 *
 * @property Language $language
 * @property WidgetMenuItem $item
 */
class WidgetMenuDescription extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_menu_description}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'language_id', 'name'], 'required'],
            [['item_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.widget', 'ID'),
            'item_id' => Yii::t('admin.widget', 'Item ID'),
            'language_id' => Yii::t('admin.widget', 'Language ID'),
            'name' => Yii::t('admin.widget', 'Name'),
            'title' => Yii::t('admin.widget', 'Title'),
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
    public function getItem()
    {
        return $this->hasOne(WidgetMenuItem::className(), ['id' => 'item_id']);
    }
}
