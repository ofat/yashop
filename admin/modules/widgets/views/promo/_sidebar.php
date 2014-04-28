<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 * @var array $promoTypes
 */

use yii\bootstrap\Nav;

?>
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?=Yii::t('admin.promo', 'Promo groups')?>
        </div>
        <div class="panel-body">
            <?php
            echo Nav::widget([
                'options' => ['class'=>'nav-stacked nav-pills'],
                'items' => $promoTypes
            ]);
            ?>
        </div>
    </div>
</div>