<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\console\migrations\base;

use yii\db\Migration;
use yii\helpers\Json;
use Yii;

class YashopMigration extends Migration
{
    /**
     * @var null|string table options
     */
    protected $tableOptions = null;

    /**
     * @var string directory for required data for db
     */
    protected $dataDir = 'data';

    /**
     * @var string full path to data directory
     */
    protected $dataPath;

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
    }

    /**
     * @param $file
     * @param $table
     * @return bool
     */
    protected function dataImport($file, $table)
    {
        $path = $this->getPath($file);
        if (file_exists($path)) {

            echo "adding data $file \n";
            $data = include($path);

            $keys = array_keys($data[0]);
            $columns = array_combine($keys, $keys);
            Yii::$app->db->createCommand()->batchInsert($table, $columns, $data)->execute();

            echo "added ".count($data)." records from $file \n";

            return true;
        } else {
            echo "Cannot load file {$path} \n";
            return false;
        }

    }

    /**
     * Getting full path to data directory
     * @param $file
     * @return string
     */
    protected function getPath($file)
    {
        if(!$this->dataPath)
            $this->dataPath = __DIR__ . '/../'.$this->dataDir;

        return $this->dataPath.'/'.$file.'.php';
    }
}