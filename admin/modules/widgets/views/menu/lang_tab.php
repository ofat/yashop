<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 *
 * @var yashop\common\models\widgets\WidgetMenuDescription $model,
 * @var yii\widgets\ActiveForm $form
 * @var integer $i
 */

use yii\helpers\Html;

?>

<?= $form->field($model, "[$i]name") ?>
<?= $form->field($model, "[$i]title") ?>
<?= Html::activeHiddenInput($model, "[$i]language_id") ?>
<?= Html::activeHiddenInput($model, "[$i]item_id") ?>