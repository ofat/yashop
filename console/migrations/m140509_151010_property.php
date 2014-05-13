<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_151010_property extends YashopMigration
{
    protected $tableProperty = '{{%property}}';
    protected $tableDescription = '{{%property_description}}';

    public function safeUp()
    {
        parent::safeUp();

        $this->createTable($this->tableProperty, [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL'
        ], $this->tableOptions);
        $this->createIndex('parent_id', $this->tableProperty, 'parent_id');
        $this->addForeignKey('property_ibfk_1', $this->tableProperty, 'parent_id', $this->tableProperty, 'id', 'CASCADE', 'CASCADE');

        $this->createTable($this->tableDescription, [
            'id' => Schema::TYPE_PK,
            'property_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'language_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('property_id', $this->tableDescription, 'property_id');
        $this->createIndex('language_id', $this->tableDescription, 'language_id');
        $this->addForeignKey('property_description_ibfk_1', $this->tableDescription, 'property_id', $this->tableProperty, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('property_description_ibfk_2', $this->tableDescription, 'language_id', '{{%language}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable($this->tableDescription);
        $this->dropTable($this->tableProperty);
    }

}