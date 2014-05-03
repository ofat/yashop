<?php
/**
 * @var yii\web\View $this
 */

use yashop\site\widgets\Menu;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-3">
            <?php echo Menu::widget(['type'=>'categories']) ?>
        </div>
    </div>
</div>
