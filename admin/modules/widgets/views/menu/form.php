<?php
/**
 * @var array $menuTypes
 * @var array $listMenu
 * @var yashop\common\models\widgets\Widget $menu
 * @var yashop\common\models\widgets\WidgetMenuItem $model
 * @var yashop\common\models\widgets\WidgetMenuDescription[] $description
 * @var yashop\common\models\Language[] $languages
 * @var yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Widgets'), 'url' => ['/widgets']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin.menu', 'Menu'), 'url' => ['/widgets/menu']];
$this->params['breadcrumbs'][] = ['label' => $menu->description->name, 'url' => ['/widgets/menu/index', 'id'=>$menu->id]];
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
                    <?= $form->field($model, 'widget_id')->dropDownList($listMenu) ?>
                    <?= $form->field($model, 'url') ?>
                    <?= $form->field($model, 'parent_id')->dropDownList($menu->getMenuList()) ?>
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
    </div>
</div>

