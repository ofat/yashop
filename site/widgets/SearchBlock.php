<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
namespace yashop\site\widgets;

use yii\base\Widget;

class SearchBlock extends Widget
{
    public function run()
    {
        return $this->render('search_block');
    }
}