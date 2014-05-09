<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_151010_property extends YashopMigration
{
    protected $tableProperty = '{{%property}}';

    public function safeUp()
    {
        parent::safeUp();

        $this->createTable($this->tableProperty, [
            'id' => Schema::TYPE_PK,
            'ru' => Schema::TYPE_STRING . '(512) DEFAULT NULL',
            'en' => Schema::TYPE_STRING . '(512) DEFAULT NULL',
            'type' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
        ], $this->tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable($this->tableProperty);
    }

}