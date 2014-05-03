<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var array $dataProvider
 * @var yashop\common\models\Language $searchModel
 */

$this->title = Yii::t('admin.language', 'Languages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Settings'), 'url' => ['/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pull-right">
<?=Html::a(Yii::t('admin.language', 'Add language'), ['/settings/language/create'], ['class'=>'btn btn-sm btn-primary'])?>
</p>
<div class="language-list">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'code',
            'name',
            'short_name',
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