<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
namespace yashop\common\models\item;

use Yii;
use yii\db\ActiveRecord;
use yashop\common\models\Language;

/**
 * This is the model class for table "item_description".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $language_id
 * @property string $title
 * @property string $description
 *
 * @property Language $language
 * @property Item $item
 */
class ItemDescription extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_description';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'language_id', 'title', 'description'], 'required'],
            [['item_id', 'language_id'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('item', 'ID'),
            'item_id' => Yii::t('item', 'Item ID'),
            'language_id' => Yii::t('item', 'Language ID'),
            'title' => Yii::t('item', 'Title'),
            'description' => Yii::t('item', 'Description'),
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
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}