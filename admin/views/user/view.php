<?php

use common\helpers\Base;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\User $model
 */

$this->title = Yii::t('user', 'User ID {id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="row">
        <div class="col-md-3">
            <h4 class="page-header">Общая информация</h4>
            <?php $form = ActiveForm::begin() ?>
            <?=
            $form->field($model, 'username', [
                'template' => "{label}\n{hint}",
                'hintOptions' => ['class' => 'form-control-static']
            ])->hint(Html::encode($model->username))?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'status')->dropDownList(User::getStatusesList()) ?>
            <?= $form->field($model, 'role[item_name]')->dropDownList(User::getRolesList()) ?>
            <?=
            $form->field($model, 'created_at', [
                'template' => "{label}\n{hint}",
                'hintOptions' => ['class' => 'form-control-static']
            ])->hint(Base::formatDate($model->created_at))?>
            <?=
            $form->field($model, 'updated_at', [
                'template' => "{label}\n{hint}",
                'hintOptions' => ['class' => 'form-control-static']
            ])->hint(Base::formatDate($model->updated_at))?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
