<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\modules\item\assets;

use yii\web\AssetBundle;

class ItemAsset extends AssetBundle
{
    public $sourcePath = '@yashop-site/modules/item/assets';
    public $css = [
        'css/item.less'
    ];

    public $js = [
        'js/item.js',
        'js/item.images.js',
        'js/item.count.js',
        'js/item.sku.js'
    ];

    public $depends = [
        'yashop\common\assets\YashopAsset'
    ];

    public $publishOptions = [
        'forceCopy' => true
    ];
}