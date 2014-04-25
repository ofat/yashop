<?php
/**
 * Change email form
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace site\modules\cabinet\models\forms;

use yii\base\Model;
use Yii;

use common\models\User;

class ChangeEmailForm extends Model
{
    private $_user = false;

    public $oldEmail;
    public $newEmail;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['oldEmail', 'filter', 'filter'=>'trim'],
            ['oldEmail', 'required'],
            ['oldEmail', 'email'],
            ['oldEmail', 'isCurrentEmail'],

            ['newEmail', 'filter', 'filter'=>'trim'],
            ['newEmail', 'required'],
            ['newEmail', 'email'],
            [
                'newEmail',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('user','This email address has already been taken.'),
                'targetAttribute' => 'email'
            ],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password', 'isCurrentPassword']
        ];
    }

    public function attributeLabels()
    {
        return [
            'oldEmail' => Yii::t('cabinet.profile','Old e-mail'),
            'newEmail' => Yii::t('cabinet.profile','New e-mail'),
            'password' => Yii::t('user','Password')
        ];
    }

    /**
     * Check entered old email with current email
     */
    public function isCurrentEmail($attribute) {
        $user = $this->getUser();
        if ($this->$attribute != $user->email) {
            $this->addError($attribute, Yii::t('cabinet.profile', 'Entered wrong old e-mail'));
        }
    }

    /**
     * Check entered password with current password
     */
    public function isCurrentPassword($attribute) {
        $user = $this->getUser();
        if (!$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, Yii::t('cabinet.profile', 'Entered wrong password'));
        }
    }

    /**
     * Change user email
     * @return boolean Result of saving model
     */
    public function changeEmail()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->email = $this->newEmail;
            return $user->update();
        }

        return null;
    }

    /**
     * Returning current user model
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(Yii::$app->getUser()->id);
        }

        return $this->_user;
    }

}