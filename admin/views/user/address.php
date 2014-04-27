<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

use common\helpers\Base;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\User $userModel
 * @var yii\data\ActiveDataProvider $data
 */

$this->title = Yii::t('address', 'User\'s ID {id} addresses',['id'=>$userModel->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'User ID {id}', ['id' => $userModel->id]), 'url' => ['view','id'=>$userModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-address">
    <h3 class="page-header">
        <?=Html::encode($this->title)?>
    </h3>
    <div class="row">
        <?php foreach($data->getModels() as $address):?>
        <div class="col-md-4">
            <div class="well<?=($address->is_default)?' active':''?>">
                <strong><?=$address->full_name?></strong>
                <p><?=$address->zipcode.', '.$address->country->{Yii::$app->language}.', '.$address->region.', '.$address->city?></p>
                <p>
                    <?=$address->street.', '.$address->building?><?=($address->apartment) ? '-'.$address->apartment : ''?>
                </p>
                <p><?=Yii::t('address','tel.')?>: <?=$address->phone?></p>
                <div class="btn-group">
                    <?php if($address->is_hidden):?>
                        <p class="label label-warning"><?=Yii::t('address','Deleted')?></p>
                    <?php endif ?>
                    <?php if($address->is_default):?>
                        <p class="label label-info"><?=Yii::t('address','Default')?></p>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
