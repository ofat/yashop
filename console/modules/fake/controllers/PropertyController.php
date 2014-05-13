<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\console\modules\fake\controllers;

use yashop\common\models\Property;

class PropertyController extends BaseController
{
    private $tableBase = '{{%property}}';
    private $tableDescription = '{{%property_description}}';

    public function actionIndex()
    {
        $minProperty = 10;
        $maxProperty = 100;
        $minValue = 5;
        $maxValue = 10;

        $languages = $this->getLanguages();
        $faker = $this->getGenerator();

        $countProperty = 0;
        $countValue = 0;

        $list = [];
        for($i=0; $i<rand($minProperty, $maxProperty); $i++) {
            //base property data
            $property = new Property;
            $property->parent_id = null; // type property
            $property->save();
            $countProperty++;

            //property description
            $name = implode(' ', $faker->words( rand(1, 3) ));
            foreach($languages as $lang) {
                $list[] = [
                    $property->id,
                    $lang['id'],
                    $name
                ];
            }
            //property values
            $parent_id = $property->id;
            for($j=0; $j<rand($minValue, $maxValue); $j++) {
                $value = new Property;
                $value->parent_id = $parent_id;
                $value->save();
                $countValue++;

                //value description
                $name = implode(' ', $faker->words( rand(1, 3) ));
                foreach($languages as $lang) {
                    $list[] = [
                        $value->id,
                        $lang['id'],
                        $name
                    ];
                }
            }
        }

        $this->import($this->tableDescription, ['property_id', 'language_id', 'name'], $list);

        echo "Inserted $countProperty properties and $countValue values \n";
    }
}