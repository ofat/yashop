<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\controllers;

use yashop\common\models\Country;
use Yii;
use yii\web\Controller;

class DevController extends Controller
{
    public function actionCountry()
    {
        $url = 'http://www.artlebedev.ru/tools/country-list/xml/';
        $data = simplexml_load_file($url);

        $i = 0;
        foreach($data->country as $item)
        {
            $country = new Country;
            $country->ru = (string)$item->name;
            $country->en = (string)$item->english;
            $country->code = (string)$item->alpha3;
            $country->sort_order = $i;
            if(!$country->save())
                print_r($country->getErrors());
            echo $country->id.' - '.$country->ru.'<br>';
            $i++;
        }
    }
}