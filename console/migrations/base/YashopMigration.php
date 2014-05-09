<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\console\migrations\base;

use yii\db\Migration;

class YashopMigration extends Migration
{
    /**
     * @var null|string table options
     */
    protected $tableOptions = null;

    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
    }
}