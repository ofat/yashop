<?php

namespace yashop\common\models\user;

use Yii;
use yashop\common\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_payment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $sum
 * @property string $balance
 * @property integer $status
 * @property integer $type
 * @property string $data
 * @property integer $created
 *
 * @property User $user
 */
class Payment extends ActiveRecord
{

    const STATUS_INCREASE = 1;
    const STATUS_DECREASE = 2;
    const STATUS_CHECK = 3;
    const STATUS_REMOVED = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sum', 'balance', 'status', 'type', 'created'], 'required'],
            [['user_id', 'status', 'type', 'created'], 'integer'],
            [['sum', 'balance'], 'number'],
            [['data'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('payment', 'ID'),
            'user_id' => Yii::t('payment', 'User ID'),
            'sum' => Yii::t('payment', 'Sum'),
            'balance' => Yii::t('payment', 'Balance'),
            'status' => Yii::t('payment', 'Status'),
            'type' => Yii::t('payment', 'Type'),
            'data' => Yii::t('payment', 'Data'),
            'created' => Yii::t('payment', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
