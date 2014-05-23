<?php

use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_170322_cart extends YashopMigration
{
    protected $tableItem = '{{%cart_item}}';
    protected $tableProperty = '{{%cart_property}}';

    public function safeUp()
    {
        parent::safeUp();

        $this->createTable($this->tableItem, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'sku_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'num' => Schema::TYPE_SMALLINT . '(8) NOT NULL',
            'description' => Schema::TYPE_STRING . '(512) DEFAULT NULL',
            'created_at' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL',
        ], $this->tableOptions);
        $this->createIndex('user_id', $this->tableItem, 'user_id');
        $this->createIndex('sku_id', $this->tableItem, 'sku_id');
        $this->addForeignKey('cart_item_ibfk_1', $this->tableItem, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('cart_item_ibfk_2', $this->tableItem, 'sku_id', '{{%item_sku}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable($this->tableProperty, [
            'id' => Schema::TYPE_PK,
            'cart_item_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'property_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'value_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
        ], $this->tableOptions);
        $this->createIndex('cart_item_id', $this->tableProperty, 'cart_item_id');
        $this->createIndex('property_id', $this->tableProperty, 'property_id');
        $this->createIndex('value_id', $this->tableProperty, 'value_id');

        $this->addForeignKey('cart_property_ibfk_1', $this->tableProperty, 'cart_item_id', $this->tableItem, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('cart_property_ibfk_2', $this->tableProperty, 'property_id', '{{%property}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('cart_property_ibfk_3', $this->tableProperty, 'value_id', '{{%property}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable($this->tableProperty);
        $this->dropTable($this->tableItem);
    }
}
