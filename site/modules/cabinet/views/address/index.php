<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $data
 */

use yii\helpers\Url;
use common\models\user\Address;

$this->title = Yii::t('cabinet','Addresses');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-address">
    <a href="<?=Url::toRoute(['/cabinet/profile/address/add'])?>" class="btn btn-primary pull-right">Добавить адрес</a>
    <div class="clearfix"></div>
    <div class="row">
        <?php if(!$data->count):?>
            <div class="col-md-12">
                <p>
                    <?=Yii::t('address','You can add up to {count} different addresses.',['count'=>Address::getMaxPerUser()])?><br>
                    <?=Yii::t('address','You can choose address while ordering.')?>
                </p>
            </div>
        <?php else: foreach($data->getModels() as $address):?>
            <div class="col-md-4">
                <div class="well<?=($address->is_default)?' active':''?>">
                    <strong><?=$address->full_name?></strong>
                    <p><?=$address->zipcode.', '.$address->country->{Yii::$app->language}.', '.$address->region.', '.$address->city?></p>
                    <p>
                        <?=$address->street.', '.$address->building?><?=($address->apartment) ? '-'.$address->apartment : ''?>
                    </p>
                    <p><?=Yii::t('address','tel.')?>: <?=$address->phone?></p>
                    <div class="btn-group">
                        <a href="<?=Url::toRoute(['/cabinet/profile/address/edit', 'id'=>$address->id])?>" class="btn btn-xs btn-warning">
                            <?=Yii::t('base','Edit')?>
                        </a>
                        <a href="<?=Url::toRoute(['/cabinet/profile/address/remove', 'id'=>$address->id])?>" class="btn btn-xs btn-danger">
                            <?=Yii::t('base','Remove')?>
                        </a>
                        <?php if($address->is_default):?>
                            <p class="btn btn-xs btn-info"><?=Yii::t('address','Default')?></p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
