<?php
/**
 * @var array $menuTypes
 * @var array $items
 * @var boolean|common\models\widgets\WidgetMenu $menu
 * @var yii\web\View $this
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Widgets'), 'url' => ['/widgets']];
if(!$menu)
{
    $this->title = Yii::t('admin.menu', 'Menu');
} else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('admin.menu', 'Menu'), 'url' => ['/widgets/menu']];
    $this->title = $menu->getName();
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <?php echo $this->render('_sidebar', ['menuTypes' => $menuTypes])?>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=Yii::t('admin.menu', 'Menu items')?>
            </div>
            <div class="panel-body">
                <?php if(empty($items)):?>
                <p><?=Yii::t('admin.menu', 'You should choose menu type.')?></p>
                <?php else:?>
                    <p class="pull-right">
                        <a href="<?=Url::toRoute(['/widgets/menu/add', 'id'=>$menu->id])?>" class="btn btn-sm btn-primary">
                            <?=Yii::t('admin.menu','Add menu')?>
                        </a>
                    </p>
                    <div class="clearfix"></div>
                    <?php echo $this->render('_menu_list', ['items' => $menu->getChildrenTree()]) ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

