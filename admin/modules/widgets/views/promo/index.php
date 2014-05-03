<?php
/**
 * @var array $promoTypes
 * @var array $items
 * @var boolean|yashop\common\models\widgets\WidgetPromo $promo
 * @var yii\web\View $this
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Widgets'), 'url' => ['/widgets']];
if(!$promo)
{
    $this->title = Yii::t('admin.promo', 'Promo group');
} else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('admin.promo', 'Promo'), 'url' => ['/widgets/promo']];
    $this->title = $promo->getName();
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <?php echo $this->render('_sidebar', ['promoTypes' => $promoTypes])?>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=Yii::t('admin.promo', 'Promo items')?>
            </div>
            <div class="panel-body">
                <?php if(empty($items)):?>
                <p><?=Yii::t('admin.promo', 'You should choose promo group.')?></p>
                <?php else:?>
                    <p class="pull-right">
                        <a href="<?=Url::toRoute(['/widgets/promo/add', 'id'=>$promo->id])?>" class="btn btn-sm btn-primary">
                            <?=Yii::t('admin.promo','Add item')?>
                        </a>
                    </p>
                    <div class="clearfix"></div>
                    <div class="row">
                        <?php foreach($promo->items as $item):?>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <a href="<?=Yii::$app->urlManagerSite->createAbsoluteUrl(['item/view', 'id'=>$item->item->id])?>">
                                        <img src="<?=Yii::$app->urlManagerSite->createAbsoluteUrl($item->item->image)?>" alt="">
                                    </a>
                                    <div class="btn-group">
                                        <a href="<?=Url::toRoute(['/widgets/promo/move', 'dir'=>'up', 'id'=>$item->id])?>" class="btn btn-default">
                                            <i class="glyphicon glyphicon-arrow-left"></i>
                                        </a>
                                        <a href="<?=Url::toRoute(['/widgets/promo/remove', 'id'=>$item->id])?>" class="btn btn-warning">
                                            <?=Yii::t('base', 'Remove')?>
                                        </a>
                                        <a href="<?=Url::toRoute(['/widgets/promo/move', 'dir'=>'down', 'id'=>$item->id])?>" class="btn btn-default">
                                            <i class="glyphicon glyphicon-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </ul>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

