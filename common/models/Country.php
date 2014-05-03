<?php

namespace yashop\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $code
 * @property string $ru
 * @property string $en
 * @property integer $is_active
 * @property integer $is_main
 * @property integer $sort_order
 *
 * @property UserAddress[] $userAddresses
 */
class Country extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['is_active', 'is_main', 'sort_order'], 'integer'],
            [['code'], 'string', 'max' => 3],
            [['ru', 'en'], 'string', 'max' => 255],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin.country', 'ID'),
            'code' => Yii::t('admin.country', 'Code'),
            'ru' => Yii::t('admin.country', 'Russian name'),
            'en' => Yii::t('admin.country', 'English name'),
            'is_active' => Yii::t('admin.country', 'Is active'),
            'is_main' => Yii::t('admin.country', 'Is main'),
            'sort_order' => Yii::t('admin.country', 'Sort Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses()
    {
        return $this->hasMany(UserAddress::className(), ['country_id' => 'id']);
    }

    /**
     * Changing main country
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            static::updateAll(['is_main'=>0]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Switch off/on list of countries
     * @param $models
     * @return \yii\db\Command
     */
    public static function setActive($models, $active)
    {
        return Yii::$app->db->createCommand()->update(static::tableName(),['is_active'=>(int)$active],['id'=>$models])->execute();
    }

    /**
     * Switch off/on all countries
     * @param $models
     * @return \yii\db\Command
     */
    public static function setActiveAll($active)
    {
        return Yii::$app->db->createCommand()->update(static::tableName(),['is_active'=>(int)$active])->execute();
    }

    public static function getList()
    {
        $data = [];
        foreach(static::findAll(['is_active'=>1]) as $country)
        {
            $data[ $country->id ] = $country->{Yii::$app->language};
        }
        return $data;
    }
}
