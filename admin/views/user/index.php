<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yashop\common\models\User;
use yii\jui\DatePickerAsset;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yashop\admin\models\UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-list">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email:email',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->getStatus();
                },
                'filter' => User::getStatusesList()
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'role.item_name',
                'value' => function($data) {
                    return $data->getRoleName();
                },
                'filter' => User::getRolesList()
            ],
            'created_at:date',
            'updated_at:date',
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
