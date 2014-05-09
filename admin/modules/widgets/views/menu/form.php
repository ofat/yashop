<?php
/**
 * @var array $menuTypes
 * @var array $listMenu
 * @var yashop\common\models\widgets\WidgetMenu $menu
 * @var yashop\common\models\widgets\WidgetMenuItem $model
 * @var yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Widgets'), 'url' => ['/widgets']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin.menu', 'Menu'), 'url' => ['/widgets/menu']];
$this->params['breadcrumbs'][] = ['label' => $menu->getAttribute(Yii::$app->language), 'url' => ['/widgets/menu/index', 'id'=>$menu->id]];
$this->title = ($model->isNewRecord) ? Yii::t('admin.menu', 'Adding menu item') : Yii::t('admin.menu', 'Editing menu item');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <?php echo $this->render('_sidebar', ['menuTypes' => $menuTypes])?>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=Html::encode($this->title)?>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($model, 'menu_id')->dropDownList($listMenu) ?>
                    <?= $form->field($model, 'ru') ?>
                    <?= $form->field($model, 'en') ?>
                    <?= $form->field($model, 'url') ?>
                    <?= $form->field($model, 'parent_id')->dropDownList($menu->getChildrenList()) ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

