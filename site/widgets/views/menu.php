<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 * @var array $data
 */

use yii\helpers\Html;

?>
<ul class="sidebar-nav categories-block" id="categoriesMenu">
    <?php foreach($data as $k=>$item):?>
        <li data-submenu-id="submenu-<?=$k?>">
            <a href="#" data-toggle="dropdown">
                <?=$item['label']?>
            </a>
            <div class="dropdown-col col-md-9 col-xs-8 col-lg-10 col-lg-offset-2 col-xs-offset-4 col-md-offset-3">
                <div class="dropdown-menu-block" id="submenu-<?=$k?>">
                    <?php foreach($item['items'] as $j=>$item2):?>
                        <div class="menu-block<?=(empty($item2['items']))?' no-childs':''?>">
                            <h3 class="header"><a href="<?=CHtml::normalizeUrl($item2['url'])?>"><?=$item2['label']?></a></h3>
                            <ul>
                                <?php foreach($item2['items'] as $i=>$item3):?>
                                    <li<?=($i>19)?' class="hide cat-hidden"':''?>>
                                        <a href="<?=CHtml::normalizeUrl($item3['url'])?>"><?=$item3['label']?></a>
                                    </li>
                                <?php endforeach ?>
                                <?php if(count($item2['items'])>20):?>
                                    <li><a href="#" class="catShowMore">показать больше</a></li>
                                <?php endif ?>
                            </ul>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>