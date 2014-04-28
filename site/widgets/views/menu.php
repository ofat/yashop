<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 * @var array $data
 */

use yii\helpers\Html;

?>
<ul class="menu-nav widget-menu" id="<?=$type?>Menu">
    <?php foreach($data as $k=>$item):?>
        <li>
            <a href="<?=Html::encode($item['url'])?>">
                <?=Html::encode($item[Yii::$app->language])?>
            </a>
            <?php
            if(isset($item['children']))
                echo $this->render('_menu_children', ['items'=>$item['children']]);
            ?>
        </li>
    <?php endforeach; ?>
</ul>