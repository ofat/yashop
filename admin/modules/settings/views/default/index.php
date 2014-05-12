<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \yashop\common\models\Setting[] $settings
 * @var \yashop\admin\models\forms\SettingForm[] $models
 */

$this->title = Yii::t('admin.settings', 'Basic settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-default-index">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php $form = ActiveForm::begin() ?>
            <?php foreach($models as $i=>$model):?>
            <?= $form->field($model, "[$i]value") ?>
            <?php endforeach ?>

            <div class="form-actions">
                <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
