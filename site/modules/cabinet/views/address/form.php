<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 *
 * @var yii\web\View $this
 * @var common\models\user\Address $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Country;

$this->title = ($model->isNewRecord) ? Yii::t('address','Adding address') : Yii::t('address','Editing address');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cabinet','Account'), 'url' => ['/cabinet']];;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cabinet','Addresses'), 'url' => ['/cabinet/profile/address']];;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-address-form">
    <h3><?= Html::encode($this->title) ?></h3>

    <div class="row">
        <div class="col-md-5">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'full_name') ?>
            <?= $form->field($model, 'country_id')->dropDownList(Country::getList()) ?>
            <?= $form->field($model, 'zipcode') ?>
            <?= $form->field($model, 'region') ?>
            <?= $form->field($model, 'city') ?>
            <?= $form->field($model, 'street') ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'building') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'apartment') ?>
                </div>
            </div>
            <?= $form->field($model, 'phone') ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('base','Save'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>