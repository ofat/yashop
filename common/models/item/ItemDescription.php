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
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $meta_desc
 * @property string $meta_keyword
 *
 * @property Item $item
 * @property Language $language
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
            [['item_id', 'language_id', 'name', 'description'], 'required'],
            [['item_id', 'language_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'meta_desc', 'meta_keyword'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.item', 'ID'),
            'item_id' => Yii::t('admin.item', 'Item ID'),
            'language_id' => Yii::t('admin.item', 'Language ID'),
            'name' => Yii::t('admin.item', 'Name'),
            'title' => Yii::t('admin.item', 'Title'),
            'description' => Yii::t('admin.item', 'Description'),
            'meta_desc' => Yii::t('admin.item', 'Meta Desc'),
            'meta_keyword' => Yii::t('admin.item', 'Meta Keyword'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
