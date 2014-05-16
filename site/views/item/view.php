<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 * @var yii\web\View $this
 * @var yashop\site\models\ItemView $item
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yashop\common\helpers\Base;
$this->title = $item->title;
$this->registerMetaTag(['name' => 'description', 'content' => $item->meta_desc]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $item->meta_keyword]);
$this->params['breadcrumbs'][] = $item->name;
?>

<div class="row item-main">
    <div class="col-md-4 item-image-block">
        <div id="small-images">
            <?php foreach($item->images as $image):?>
                <a rel="preload" href="<?=$image?>">
                    <img src="http://cdn.yashop/items/<?=$image?>" alt="" width="40" height="40">
                </a>
            <?php endforeach ?>
        </div>
        <div id="main-image">
            <a href="<?=$item->image?>">
                <img src="http://cdn.yashop/items/<?=$item->image?>" width="300" alt="">
            </a>
        </div>
    </div>
    <div class="col-md-8">
        <div id="item_id" data-value="<?=$item->id?>"></div>
        <h2 class="title"><?=$item->name?></h2>
        <div class="price" id="price">
            <?=$item->getPrice()?>
        </div>
        <form class="form-horizontal">
            <?= $this->render('_input_params', ['params' => $item->inputParams]) ?>
            <div class="form-group">
                <label class="col-md-3 control-label">В наличии:</label>
                <div class="col-md-9">
                    <p class="form-control-static" id="item-count"><?=$item->num?> шт.</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Количество:</label>
                <div class="col-md-9 item-count-controls">
                    <a href="#" id="item-smaller" class="btn btn-default"><i class="glyphicon glyphicon-minus"></i></a>
                    <input id="num" class="form-control" type="text" value="1">
                    <a href="#" id="item-bigger" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
                    <div class="item-total pull-left">
                        x&nbsp;
                        <span id="price-per-one"><?=Base::formatMoney($item->price)?></span>
                        &nbsp;=&nbsp;
                        <span class="total" id="item-total"><?=Base::formatMoney($item->price)?></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4 col-md-offset-3">
                    <button type="button" id="add-to-cart" class="btn btn-primary">Добавить в корзину</button>
                </div>
                <div class="col-md-5">
                    <button type="button" class="btn btn-default">Добавить в избранное</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row item-data">
    <div class="col-md-10 col-md-offset-1">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Характеристики товара</a></li>
            <li><a href="#desc" data-toggle="tab">Описание</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane" id="desc">
                <?=HtmlPurifier::process($item->description)?>
            </div>
            <div class="tab-pane active" id="tab1">
                <table class="table table-striped tcart">
                    <tbody>
                    <?php foreach($item->params as $property => $value):?>
                        <tr>
                            <th><?=Html::encode($property)?>:</th>
                            <td><?=implode(', ',$value)?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>