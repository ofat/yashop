<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yashop\admin\models\ItemSearch $searchModel
 */

$this->title = Yii::t('admin.item', 'Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Catalog'), 'url' => ['/catalog']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="pull-right">
    <?=Html::a(Yii::t('admin.item', 'Add item'), ['/catalog/item/create'], ['class'=>'btn btn-sm btn-primary'])?>
</p>
<div class="category-list">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'description.name',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a(Yii::t('yii', 'View'), $url, ['class'=>'btn btn-sm btn-default']);
                    }
                ],
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>