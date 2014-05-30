<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\console\modules\demo\components;

use yii\console\Controller;
use yii\helpers\Html;

class DemoController extends Controller
{
    protected $dataDir = 'data';

    protected $delimiter = ',';

    protected $file;

    protected function loadFile($name)
    {
        echo "Start read file {$name} \n";

        $filename = $this->getPath($name);
        if(!file_exists($filename))
            echo "Cannot load file {$filename} \n";

        $this->file = fopen($filename, "r");
        return true;
    }

    protected function getLine()
    {
        return fgetcsv($this->file, null, $this->delimiter);
    }

    protected function getPath($name)
    {
        return dirname(__DIR__) . '/' . $this->dataDir . '/' . $name;
    }

    protected function getUrl($name)
    {
        $name = trim(strtolower( Html::decode($name) ));
        $url = strtr($name, [
            ' ' => '-',
            '&' => '-',
            '.' => '',
            ',' => '-',
            '/' => '-'
        ]);
        return strtr($url, [
            '--' => '-',
            '---' => '-'
        ]);
    }
}