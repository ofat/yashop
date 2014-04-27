<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var admin\models\CountrySearch $searchModel
 */

$this->title = Yii::t('admin.country', 'Countries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Settings'), 'url' => ['/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>

<form action="<?=Url::toRoute(['/settings/country/switch'])?>" method="get">

<?=Html::a(Yii::t('admin.country', 'Add country'), ['/settings/country/create'], ['class'=>'btn btn-sm btn-primary'])?>

<div class="pull-right">
    <?=Html::submitButton(Yii::t('base', 'Switch on'), ['class'=>'btn btn-sm btn-info', 'name'=>'type', 'value'=>'on'])?>
    <?=Html::submitButton(Yii::t('base', 'Switch off'), ['class'=>'btn btn-sm btn-warning', 'name'=>'type', 'value'=>'off'])?>
</div>

<div class="user-list">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'id',
            'code',
            'ru',
            'en',
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

</form>
