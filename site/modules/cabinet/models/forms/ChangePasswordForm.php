<?php
/**
 * Changing user password
 *
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace site\modules\cabinet\models\forms;

use Yii;
use yii\base\Model;

use common\models\User;

class ChangePasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['oldPassword', 'required'],
            ['oldPassword', 'string', 'min' => 6],
            ['oldPassword', 'isCurrentPassword'],

            ['newPassword', 'required'],
            ['newPassword', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oldPassword' => Yii::t('cabinet.profile', 'Old password'),
            'newPassword' => Yii::t('cabinet.profile', 'New password')
        ];
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

    /**
     * Changing user password
     * @return bool|null
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->setPassword($this->newPassword);
            return $user->update() > 0;
        }

        return null;
    }
}