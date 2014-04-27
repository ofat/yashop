<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \site\modules\cabinet\models\forms\ChangeEmailForm $model
 */
$this->title = Yii::t('cabinet.profile','Changing e-mail');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-profile-email">
    <h3><?= Html::encode($this->title) ?></h3>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'email-form']); ?>
            <?= $form->field($model, 'oldEmail') ?>
            <?= $form->field($model, 'newEmail') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('base','Save'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>