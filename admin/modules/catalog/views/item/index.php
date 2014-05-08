<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yashop\admin\models\CategorySearch $searchModel
 */

$this->title = Yii::t('admin.category', 'Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Catalog'), 'url' => ['/catalog']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="pull-right">
    <?=Html::a(Yii::t('admin.category', 'Add category'), ['/catalog/category/create'], ['class'=>'btn btn-sm btn-primary'])?>
</p>
<div class="category-list">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'description.name',
            'url',
            'description.title',
            'description.meta_keyword',
            'description.meta_desc',
            [
                'class' => '\yii\grid\DataColumn',
                'attribute' => 'is_active',
                'content' => function($model) {
                        $class = $model->is_active ? 'glyphicon-plus' : 'glyphicon-minus';
                        return Html::tag('i','',['class' => 'glyphicon '.$class]);
                    },
                'filter' => ['Нет', 'Да'],
                'contentOptions' => ['class'=>'text-center']
            ],
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