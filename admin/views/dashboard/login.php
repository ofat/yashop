<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \common\models\forms\LoginForm $model
 */
$this->title = Yii::t('user','Login');
?>
<div class="dashboard-login">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <h2 class="form-signin-heading"><?= Html::encode($this->title) ?></h2>
        <?= $form->field($model, 'username', [
            'labelOptions' => ['class'=>'hide'],
            'inputOptions' => ['placeholder'=>Yii::t('user','Username'), 'class'=>'form-control']
        ]) ?>
        <?= $form->field($model, 'password', [
            'labelOptions' => ['class'=>'hide'],
            'inputOptions' => ['placeholder'=>Yii::t('user','Password'), 'class'=>'form-control']
        ])->passwordInput() ?>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <?= Html::submitButton(Yii::t('user','Enter'), ['class' => 'btn btn-primary btn-block']) ?>
    <?php ActiveForm::end(); ?>
</div>
