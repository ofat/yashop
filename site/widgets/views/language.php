<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 *
 * @var array $items
 */

use yii\bootstrap\Nav;

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => Yii::t('base','Language'), 'items' => $items]
    ],
]);