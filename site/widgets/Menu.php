<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\widgets;

use yashop\common\models\widgets\Widget as WidgetMenu;
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

        return $this->render('menu',['data'=>$menu->getMenuTree(), 'type'=>$this->type]);
    }
}