<?php

namespace yashop\site\tests\unit\models;

use yashop\site\tests\unit\DbTestCase;
use yashop\common\tests\fixtures\UserFixture;
use yashop\site\models\ResetPasswordForm;

class ResetPasswordFormTest extends DbTestCase
{

    use \Codeception\Specify;

    public function testResetPassword()
    {
        $this->specify('wrong reset token', function () {
            $this->setExpectedException('\Exception', 'Wrong password reset token.');
            new ResetPasswordForm('notexistingtoken_1391882543');
        });

        $this->specify('not correct token', function () {
            $this->setExpectedException('yii\base\InvalidParamException', 'Password reset token cannot be blank.');
            new ResetPasswordForm('');
        });
    }

    public function fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@site/tests/unit/fixtures/data/user.php'
            ],
        ];
    }
}
