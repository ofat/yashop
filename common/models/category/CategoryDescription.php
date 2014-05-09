<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
namespace yashop\common\models\category;

use Yii;
use yii\db\ActiveRecord;
use yashop\common\models\Language;

/**
 * This is the model class for table "category_description".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $language_id
 * @property string $name
 * @property string $text
 * @property string $title
 * @property string $meta_desc
 * @property string $meta_keyword
 *
 * @property Category $category
 * @property Language $language
 */
class CategoryDescription extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_description';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'language_id', 'name'], 'required'],
            [['category_id', 'language_id'], 'integer'],
            [['text'], 'string'],
            [['name', 'title', 'meta_desc', 'meta_keyword'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.category', 'ID'),
            'category_id' => Yii::t('admin.category', 'Category ID'),
            'language_id' => Yii::t('admin.category', 'Language ID'),
            'name' => Yii::t('admin.category', 'Name'),
            'text' => Yii::t('admin.category', 'Description'),
            'title' => Yii::t('admin.category', 'HTML Title'),
            'meta_desc' => Yii::t('admin.category', 'Meta-description'),
            'meta_keyword' => Yii::t('admin.category', 'Meta-keyword'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}