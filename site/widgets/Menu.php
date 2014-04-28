<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace site\widgets;

use yii\base\Widget;

class Menu extends Widget
{
    public function run()
    {
        return $this->render('menu',['data'=>[]]);
    }
}