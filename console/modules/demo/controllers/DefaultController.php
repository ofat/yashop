<?php

namespace yashop\console\modules\demo\controllers;

use yii\console\Controller;
use yii\helpers\ArrayHelper;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->import('widget');
        $this->import('widget_menu_item');
        $this->import('category');
    }

    protected function import($name)
    {
        $data = $this->loadFile($name);
        $this->processData($data, $name);
    }

    protected function processData($data, $name)
    {
        $children = [];
        foreach($data as $key=>$item)
        {
            foreach($item as $attr => $value)
            {
                if(is_array($value)) {
                    if(!isset($children[$attr]))
                        $children[$attr] = [];
                    $children[$attr] = ArrayHelper::merge($children[$attr], $value);
                    unset($data[$key][$attr]);
                }
            }
        }

        $keys = array_keys($data[0]);
        $columns = array_combine($keys, $keys);
        \Yii::$app->db->createCommand()->batchInsert("{{%$name}}", $columns, $data)->execute();

        foreach($children as $key=>$item)
        {
            $this->processData($item, $key);
        }
    }

    protected function loadFile($name)
    {
        $data = include __DIR__ . '/../data/' . $name . '.php';
        return $data;
    }
}
