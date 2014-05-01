<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var array $dataProvider
 * @var common\models\Language $searchModel
 */

$this->title = Yii::t('admin.currency', 'Currencies');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Settings'), 'url' => ['/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pull-right">
<?=Html::a(Yii::t('admin.currency', 'Add currency'), ['/settings/currency/create'], ['class'=>'btn btn-sm btn-primary'])?>
</p>
<div class="currency-list">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'mask:html',
            'rate',
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
                'class' => '\yii\grid\DataColumn',
                'attribute' => 'is_default',
                'content' => function($model) {
                        $class = $model->is_default ? 'glyphicon-plus' : 'glyphicon-minus';
                        return Html::tag('i','',['class' => 'glyphicon '.$class]);
                    },
                'filter' => ['Нет', 'Да'],
                'contentOptions' => ['class'=>'text-center']
            ],
            [
                'class' => '\yii\grid\DataColumn',
                'attribute' => 'is_main',
                'content' => function($model) {
                        $class = $model->is_main ? 'glyphicon-plus' : 'glyphicon-minus';
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