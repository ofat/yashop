<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
use yii\db\Schema;

class m140509_110000_settings extends \yii\db\Migration
{
    protected $tableCountry = '{{%country}}';
    protected $tableCurrency = '{{%currency}}';
    protected $tableLanguage = '{{%language}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        /**
         * @todo: change ru/en columns to country_description table
         */
        $this->createTable($this->tableCountry, [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING . '(3) NOT NULL',
            'ru' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'en' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'is_active' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 1',
            'is_main' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'sort_order' => Schema::TYPE_SMALLINT . '(3) NOT NULL DEFAULT 0'
        ], $tableOptions);
        $this->createIndex('code', $this->tableCountry, 'code', true);

        $this->createTable($this->tableCurrency, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'mask' => Schema::TYPE_STRING . '(128) NOT NULL',
            'is_active' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 1',
            'is_default' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'is_main' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'sort_order' => Schema::TYPE_SMALLINT . '(2) NOT NULL DEFAULT 1',
            'rate' => Schema::TYPE_DECIMAL . '(15,4) NOT NULL DEFAULT \'1.0000\'',
        ], $tableOptions);

        $this->createTable($this->tableLanguage, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'short_name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'code' => Schema::TYPE_STRING . '(16) NOT NULL',
            'is_active' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 1',
            'is_default' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'sort_order' => Schema::TYPE_SMALLINT . '(2) NOT NULL DEFAULT 0'
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable($this->tableCountry);
        $this->dropTable($this->tableCurrency);
        $this->dropTable($this->tableLanguage);
    }
}