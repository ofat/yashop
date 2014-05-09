<?php

namespace yashop\common\models\user;

use Yii;
use yii\db\ActiveRecord;
use yashop\common\models\Country;
use yashop\common\models\User;

/**
 * This is the model class for table "user_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $full_name
 * @property string $zipcode
 * @property integer $country_id
 * @property string $region
 * @property string $city
 * @property string $street
 * @property string $building
 * @property string $apartment
 * @property string $phone
 * @property integer $used_count
 * @property integer $is_default
 * @property integer $is_hidden
 *
 * @property Country $country
 * @property User $user
 */
class Address extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'full_name', 'zipcode', 'country_id', 'region', 'city', 'street', 'building', 'phone'], 'required'],
            [['user_id', 'country_id', 'used_count', 'is_default', 'is_hidden'], 'integer'],
            [['full_name', 'region', 'city', 'street'], 'string', 'max' => 255],
            [['zipcode', 'building', 'apartment', 'phone'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('address', 'ID'),
            'user_id' => Yii::t('address', 'User ID'),
            'full_name' => Yii::t('address', 'Full name'),
            'zipcode' => Yii::t('address', 'Zip code'),
            'country_id' => Yii::t('address', 'Country'),
            'region' => Yii::t('address', 'Region'),
            'city' => Yii::t('address', 'City'),
            'street' => Yii::t('address', 'Street'),
            'building' => Yii::t('address', 'Building'),
            'apartment' => Yii::t('address', 'Apartment'),
            'phone' => Yii::t('address', 'Phone'),
            'used_count' => Yii::t('address', 'Used times'),
            'is_default' => Yii::t('address', 'Is default'),
            'is_hidden' => Yii::t('address', 'Is deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Return count of user's address
     * @param $id
     * @return int
     */
    public static function getCountByUser($id)
    {
        return static::find()->where(['user_id'=>$id])->count();
    }

    /**
     * Get max allowed addresses per user
     * @todo: make this config param
     * @return int
     */
    public static function getMaxPerUser()
    {
        return (int)Yii::$app->params['userMaxAddress'];
    }
}
