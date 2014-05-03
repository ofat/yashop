<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 * @var yii\web\View $this
 * @var yashop\site\models\ItemView $item
 */

use yii\helpers\Html;
$this->title = 'Item';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-10 col-sm-9">
        <div class="item-main">
            <div class="row">
                <div class="col-md-5 col-sm-5 item-image-block">
                    <div id="small-images">
                        <?php foreach($item->images as $image):?>
                            <a rel="preload" href="<?=$image?>">
                                <img src="<?=$image?>" alt="" width="40" height="40">
                            </a>
                        <?php endforeach ?>
                    </div>
                    <div id="main-image">
                        <a href="<?=$item->image?>">
                            <img src="<?=$item->image?>" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-md-7 col-sm-7">
                    <div id="item_id" data-value="<?=$item->id?>"></div>
                    <div class="price" id="price">
                        <?=$item->price?>
                    </div>
                    <h5 class="title"><?=$item->title?></h5>
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
                            <div class="col-md-8 item-count-controls">
                                <a href="#" id="item-smaller" class="btn btn-default"><i class="icon icon-minus"></i></a>
                                <input id="num" class="form-control" type="text" value="1">
                                <a href="#" id="item-bigger" class="btn btn-default"><i class="icon icon-plus"></i></a>
                                <div class="item-total">
                                    x&nbsp;&nbsp;<span id="price-per-one"><?=$item->price?></span>
                                    &nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;<span class="total" id="item-total"><?=$item->price?></span>
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
        </div>
    </div>
    <div class="col-md-2 col-sm-3 hidden-xs">
    </div>
</div>
<div class="row item-data">
            <div class="col-md-3 col-sm-4 hidden-xs seller-cats"></div>
            <div class="col-md-9 col-sm-8">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">Характеристики товара</a></li>
                    <li><a href="#desc" data-toggle="tab">Описание</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane" id="desc">

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