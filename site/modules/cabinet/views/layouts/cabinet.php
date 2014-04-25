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