<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yashop\common\models\Country $model
 */

$this->title = ($model->isNewRecord) ? Yii::t('admin.country', 'Adding country') : Yii::t('admin.country', 'Country {code}', ['code' => $model->code]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin.country', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'code')->textInput(['maxlength' => 3]) ?>

            <?= $form->field($model, 'is_active')->checkbox() ?>

            <?= $form->field($model, 'is_main')->checkbox() ?>

            <?= $form->field($model, 'sort_order')->textInput() ?>

            <?= $form->field($model, 'ru')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'en')->textInput(['maxlength' => 255]) ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
