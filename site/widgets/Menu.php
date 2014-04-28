<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace site\widgets;

use common\models\widgets\WidgetMenu;
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
        $items = $menu->getChildrenTree();

        return $this->render('menu',['data'=>$menu->getChildrenTree(), 'type'=>$this->type]);
    }
}