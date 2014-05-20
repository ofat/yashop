<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\widgets;

use yii\base\Widget;
use yashop\common\models\Language as Model;

class Language extends Widget
{
    public function run()
    {
        $languages = Model::getActive();
        $items = [];
        foreach($languages as $language)
        {
            $items[] = [
                'label' => $language->name,
                'url' => ['/site/language', 'id'=>$language->id]
            ];
        }
        return $this->render('language', ['items' => $items]);
    }
}