<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yashop\common\models\Currency $model
 */

$this->title = ($model->isNewRecord) ? Yii::t('admin.currency', 'Adding currency') : Yii::t('admin.currency', 'Currency {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin.currency', 'Currencies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

            <?= $form->field($model, 'mask')->textInput(['maxlength' => 128]) ?>

            <?= $form->field($model, 'rate')->textInput() ?>

            <?= $form->field($model, 'is_active')->checkbox() ?>

            <?= $form->field($model, 'is_default')->checkbox(['disabled'=>'disabled']) ?>
            <?= $form->field($model, 'is_main')->checkbox(['disabled'=>'disabled']) ?>

            <?= $form->field($model, 'sort_order')->input('number') ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
