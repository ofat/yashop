<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_110000_settings extends YashopMigration
{
    protected $tableCountry = '{{%country}}';
    protected $tableCurrency = '{{%currency}}';
    protected $tableLanguage = '{{%language}}';
    protected $tableSettings = '{{%settings}}';

    public function safeUp()
    {
        parent::safeUp();

        $this
            ->createSettings()
            ->createCountry()
            ->createCurrency()
            ->createLanguage();

        if(!$this->dataImport('settings', $this->tableSettings))
            return false;

        if(!$this->dataImport('country', $this->tableCountry))
            return false;

        if(!$this->dataImport('currency', $this->tableCurrency))
            return false;

        if(!$this->dataImport('language', $this->tableLanguage))
            return false;
    }

    public function safeDown()
    {
        $this->dropTable($this->tableSettings);
        $this->dropTable($this->tableCountry);
        $this->dropTable($this->tableCurrency);
        $this->dropTable($this->tableLanguage);
    }

    protected function createSettings()
    {
        $this->createTable($this->tableSettings, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(32) NOT NULL',
            'label' => Schema::TYPE_STRING . '(64) NOT NULL',
            'value_string' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'value_integer' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'value_float' => Schema::TYPE_FLOAT . ' DEFAULT NULL'
        ], $this->tableOptions);

        return $this;
    }

    protected function createCountry()
    {
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
        ], $this->tableOptions);
        $this->createIndex('code', $this->tableCountry, 'code', true);

        return $this;
    }

    protected function createCurrency()
    {
        $this->createTable($this->tableCurrency, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'mask' => Schema::TYPE_STRING . '(128) NOT NULL',
            'is_active' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 1',
            'is_default' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'is_main' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'sort_order' => Schema::TYPE_SMALLINT . '(2) NOT NULL DEFAULT 1',
            'rate' => Schema::TYPE_DECIMAL . '(15,4) NOT NULL DEFAULT \'1.0000\'',
        ], $this->tableOptions);

        return $this;
    }

    protected function createLanguage()
    {
        $this->createTable($this->tableLanguage, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'short_name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'code' => Schema::TYPE_STRING . '(16) NOT NULL',
            'is_active' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 1',
            'is_default' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'sort_order' => Schema::TYPE_SMALLINT . '(2) NOT NULL DEFAULT 0'
        ], $this->tableOptions);

        return $this;
    }
}