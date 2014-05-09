<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
use yii\helpers\Url;
use yii\helpers\Html;
?>
<ul class="list-group widget-menu-view">
<?php foreach($items as $item):?>
    <li class="list-group-item">
        <div class="widget-menu-item">
            <?=Html::encode($item[Yii::$app->language])?>
            <a href="<?=Url::toRoute(['/widgets/menu/edit', 'menu_id'=>$item['menu_id'],'id'=>$item['id']])?>" class="btn btn-xs btn-info">
                <i class="glyphicon glyphicon-edit"></i>
            </a>
            <a href="<?=Url::toRoute(['/widgets/menu/remove', 'id'=>$item['id']])?>" class="btn btn-xs btn-warning">
                <i class="glyphicon glyphicon-remove"></i>
            </a>
            <a href="<?=Url::toRoute(['/widgets/menu/move', 'dir'=>'up', 'id'=>$item['id']])?>" class="btn btn-xs btn-default">
                <i class="glyphicon glyphicon-arrow-up"></i>
            </a>
            <a href="<?=Url::toRoute(['/widgets/menu/move', 'dir'=>'down', 'id'=>$item['id']])?>" class="btn btn-xs btn-default">
                <i class="glyphicon glyphicon-arrow-down"></i>
            </a>
        </div>
        <?php
        if(isset($item['children']))
            echo $this->render('_menu_list', ['items' => $item['children']]);
        ?>
    </li>
<?php endforeach ?>
</ul>