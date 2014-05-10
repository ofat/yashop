<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\widgets;

use yashop\common\models\widgets\WidgetMenu;
use yii\base\Widget;

class Menu extends Widget
{
    /**
     * @var string Menu alias
     */
    public $type;

    public function run()
    {
        /**
         * @var WidgetMenu $menu
         */
        $menu = WidgetMenu::find()->where(['alias'=>$this->type])->one();
        if(!$menu)
            return false;

        $items = $menu->getChildrenTree();

        return $this->render('menu',['data'=>$menu->getChildrenTree(), 'type'=>$this->type]);
    }
}