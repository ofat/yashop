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

$this->title = ($model->isNewRecord) ? Yii::t('admin.category', 'Adding category') :
    Yii::t('admin.category', 'Category "{name}"', ['name' => $model->description->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin.category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'parent_id')->dropDownList(Category::getList()) ?>

            <?= $form->field($model, 'url') ?>

            <?= $form->field($model, 'is_active')->checkbox() ?>

            <?php
            $items = [];
            foreach($languages as $i=>$language)
            {
                $items[] = [
                    'label' => $language->name,
                    'content' => $this->render('lang_tab', ['form'=>$form, 'model'=>$description[$language->id], 'i'=>$language->id]),
                    'active' => !$i
                ];
            }
            echo Tabs::widget([
                'items' => $items
            ]);
            ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
