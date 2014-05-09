<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yashop\common\models\category\Category;

/**
 * @var yii\web\View $this
 * @var yashop\common\models\category\Category $model
 * @var yashop\common\models\category\CategoryDescription[] $description
 * @var yashop\common\models\Language[] $languages
 */

$this->title = ($model->isNewRecord) ? Yii::t('admin.item', 'Adding item') :
    Yii::t('admin.category', 'Item "{name}"', ['name' => $model->description->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin.item', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'category_id')->dropDownList(Category::getList()) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
