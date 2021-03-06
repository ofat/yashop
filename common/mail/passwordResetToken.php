<?php
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yashop\common\models\User $user
 */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset-password', 'token' => $user->password_reset_token]);
?>

<?=Yii::t('base','Hello')?> <?= Html::encode($user->username) ?>,

<?=Yii::t('user','Follow the link below to reset your password')?>:<br>

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
