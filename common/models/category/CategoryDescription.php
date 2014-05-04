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
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('category', 'ID'),
            'category_id' => Yii::t('category', 'Category ID'),
            'language_id' => Yii::t('category', 'Language ID'),
            'name' => Yii::t('category', 'Name'),
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