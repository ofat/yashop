<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 *
 * @var yashop\common\models\category\CategoryDescription $model,
 * @var yii\widgets\ActiveForm $form
 * @var integer $i
 */

use yii\helpers\Html;

?>

<?= $form->field($model, "[$i]name") ?>
<?= $form->field($model, "[$i]title") ?>
<?= $form->field($model, "[$i]meta_keyword")->textarea() ?>
<?= $form->field($model, "[$i]meta_desc")->textarea() ?>
<?= $form->field($model, "[$i]text")->textarea() ?>
<?= Html::activeHiddenInput($model, "[$i]language_id") ?>
<?= Html::activeHiddenInput($model, "[$i]category_id") ?>