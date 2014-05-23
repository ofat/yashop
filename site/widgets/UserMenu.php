<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
namespace yashop\site\widgets;

use Yii;
use yii\bootstrap\Nav;
use yashop\common\helpers\Base;

class UserMenu extends Nav
{
    public $options = ['class' => 'navbar-nav navbar-right'];

    public function run()
    {
        $menuItems = [];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => Yii::t('user','Login'), 'url' => ['/user/login']];
            $menuItems[] = ['label' => Yii::t('user','Signup'), 'url' => ['/user/register']];
        } else {
            $menuItems[] = ['label' => Yii::t('cabinet','Account'), 'url' => ['/cabinet']];
            $menuItems[] = [
                'label' => Yii::t('user','Logout').' (' . Yii::$app->user->identity->username . ' | '.Base::getCurrentBalance().' )',
                'url' => ['/user/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }

        $this->items = $menuItems;

        return parent::run();
    }
}