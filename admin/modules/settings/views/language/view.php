<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yashop\common\models\Country $model
 */

$this->title = ($model->isNewRecord) ? Yii::t('admin.language', 'Adding language') : Yii::t('admin.language', 'Language "{code}"', ['code' => $model->code]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin.country', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'code')->textInput(['maxlength' => 5]) ?>

            <?= $form->field($model, 'is_active')->checkbox() ?>

            <?= $form->field($model, 'is_default')->checkbox() ?>

            <?= $form->field($model, 'sort_order')->input('number') ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'short_name')->textInput(['maxlength' => 128]) ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
