<?php
namespace common\models;

use common\models\user\Address;
use common\models\user\Payment;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Security;
use yii\rbac\Item;
use yii\web\IdentityInterface;

use common\models\auth\Assignment;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_NON_ACTIVE = 5;
    const STATUS_ACTIVE = 10;

    /**
     * Creates a new user
     *
     * @param  array       $attributes the attributes given by field => value
     * @return static|null the newly created model, or null on failure
     */
    public static function create($attributes)
    {
        /** @var User $user */
        $user = new static();
        $user->setAttributes($attributes);
        $user->setPassword($attributes['password']);
        $user->generateAuthKey();
        if ($user->save()) {
            $user->setRole(Yii::$app->authManager->defaultRoles[0]);

            return $user;
        } else {
            return null;
        }
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Security::validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],

            ['role', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'E-mail'),
            'status' => Yii::t('user', 'Status'),
            'created_at' => Yii::t('user', 'Registered'),
            'updated_at' => Yii::t('user', 'Updated'),
            'role'  => Yii::t('user', 'Role')
        ];
    }

    /**
     * @return array Array of user statuses
     */
    public static function getStatusesList()
    {
        return [
            self::STATUS_NON_ACTIVE => Yii::t('user', 'Not verified'),
            self::STATUS_ACTIVE => Yii::t('user', 'Active'),
            self::STATUS_DELETED => Yii::t('user', 'Blocked')
        ];
    }

    /**
     * @return array List of available roles
     */
    public static function getRolesList()
    {
        $data = (new Query())
                    ->select('name')
                    ->from('auth_item')
                    ->where('type=:type',[':type'=>Item::TYPE_ROLE])
                    ->all();
        $res = [];
        foreach($data as $record)
        {
            $res[ $record['name'] ] = Yii::t('user', $record['name']);
        }
        return $res;
    }

    /**
     * @return string User status
     */
    public function getStatus()
    {
        return static::getStatusesList()[ $this->status ];
    }

    /**
     * Role relation
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Assignment::className(), ['user_id' => 'id']);
    }

    /**
     * Change role for user
     * @param $roleName
     * @return bool
     */
    public function setRole($roleName)
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole($roleName);

        $r = $auth->revokeAll($this->getId());
        $r = $auth->assign($role, $this->getId()) && $r;

        return $r;
    }

    /**
     * @return string Translated role name
     */
    public function getRoleName()
    {
        return Yii::t('user', $this->role->item_name);
    }

    /**
     * Return all users addresses
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['user_id' => 'id']);
    }

    /**
     * Return count of users addresses
     * @return int
     */
    public function getAddressCount()
    {
        return $this->getAddresses()->count();
    }

    /**
     * Return users payments
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['user_id' => 'id']);
    }

    public function getBalance()
    {
        return (float)$this->getPayments()
            ->select('SUM(sum)')
            ->andWhere(['status'=>[Payment::STATUS_INCREASE, Payment::STATUS_DECREASE]])
            ->scalar();
    }
}
