<?php
/**
 * @var array $promoTypes
 * @var array $listPromo
 * @var common\models\widgets\WidgetPromo $promo
 * @var common\models\widgets\WidgetPromoItem $model
 * @var yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Widgets'), 'url' => ['/widgets']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin.promo', 'Promo'), 'url' => ['/widgets/promo']];
$this->params['breadcrumbs'][] = ['label' => $promo->getAttribute(Yii::$app->language), 'url' => ['/widgets/promo/index', 'id'=>$promo->id]];
$this->title = ($model->isNewRecord) ? Yii::t('admin.promo', 'Adding promo item') : Yii::t('admin.promo', 'Editing promo item');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <?php echo $this->render('_sidebar', ['promoTypes' => $promoTypes])?>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=Html::encode($this->title)?>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($model, 'promo_id')->dropDownList($listPromo) ?>
                    <?= $form->field($model, 'item_id') ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

