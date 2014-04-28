<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

use yii\bootstrap\Nav;

/**
 * @var yii\web\View $this
 */
?>

<div class="row">
    <div class="col-md-3">
        <?php
        echo Nav::widget([
            'options' => [
                'class' => 'nav-pills nav-stacked'
            ],
            'items' => [
                [
                    'label' => Yii::t('cabinet','Dashboard'),
                    'url' => ['/cabinet'],
                ],
                [
                    'label' => Yii::t('cabinet','Profile'),
                    'items' => [
                        ['label' => Yii::t('cabinet','Change password'), 'url' => ['/cabinet/profile/password']],
                        ['label' => Yii::t('cabinet','Change e-mail'), 'url' => ['/cabinet/profile/email']],
                        ['label' => Yii::t('cabinet','Addresses'), 'url' => ['/cabinet/profile/address']],
                    ],
                ],
                [
                    'label' => Yii::t('payment','Payments'),
                    'items' => [
                        ['label' => Yii::t('payment','Deposit'), 'url' => ['/cabinet/balance/payment']],
                        ['label' => Yii::t('payment','History'), 'url' => ['/cabinet/balance']],
                        ['label' => Yii::t('payment','Withdraw'), 'url' => ['/cabinet/balance/withdraw']]
                    ],
                ],
            ],
        ]);
        ?>
    </div>
    <div class="col-md-9">
        <?= $content ?>
    </div>
</div>