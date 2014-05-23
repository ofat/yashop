<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\assets;

use Yii;
use yii\web\AssetBundle;

class YashopAsset extends AssetBundle
{
    public $sourcePath = '@yashop-common/assets/js';

    public $css = [
    ];
    public $js = [
        'yashop.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];

}
