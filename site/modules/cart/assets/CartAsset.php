<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\modules\cart\assets;

use yii\web\AssetBundle;

class CartAsset extends AssetBundle
{
    public $sourcePath = '@yashop-site/modules/cart/assets';
    public $css = [
        'css/cart.less'
    ];

    public $js = [

    ];

    public $depends = [
        'yashop\common\assets\YashopAsset'
    ];

    public $publishOptions = [
        'forceCopy' => true
    ];
}