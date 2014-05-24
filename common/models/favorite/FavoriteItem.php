<?php

namespace yashop\common\models\favorite;

use Yii;
use yii\db\ActiveRecord;
use yashop\common\models\User;
use yashop\common\models\item\Item;

/**
 * This is the model class for table "favorite_item".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $item_id
 * @property string $description
 * @property integer $created_at
 *
 * @property Item $item
 * @property User $user
 */
class FavoriteItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favorite_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'item_id'], 'required'],
            [['user_id', 'item_id', 'created_at'], 'integer'],
            [['description'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('favorite', 'ID'),
            'user_id' => Yii::t('favorite', 'User ID'),
            'item_id' => Yii::t('favorite', 'Item ID'),
            'description' => Yii::t('favorite', 'Description'),
            'created_at' => Yii::t('favorite', 'Created At'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
