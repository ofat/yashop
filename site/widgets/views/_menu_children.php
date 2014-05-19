<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

use yii\helpers\Html;

?>
<ul class="widget-menu-children">
    <?php foreach($items as $item):?>
    <li>
        <a href="<?=Html::encode($item['url'])?>">
            <?=Html::encode($item['description']['name'])?>
        </a>
    </li>
        <?php
        if(isset($item['children']))
            echo $this->render('_menu_children', ['items'=>$item['children']]);
        ?>
    <?php endforeach ?>
</ul>