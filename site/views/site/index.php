<?php
/**
 * @var yii\web\View $this
 */

use site\widgets\Menu;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-3">
            <?php echo Menu::widget(['type'=>'categories']) ?>
        </div>
    </div>
</div>
