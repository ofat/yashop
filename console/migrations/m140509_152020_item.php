<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_152020_item extends YashopMigration
{
    protected $tableItem = '{{%item}}';
    protected $tableDescription = '{{%item_description}}';
    protected $tableImage = '{{%item_image}}';
    protected $tableProperty = '{{%item_property}}';
    protected $tableSku = '{{%item_sku}}';

    public function safeUp()
    {
        parent::safeUp();

        $this
            ->createItem()
            ->createDescription()
            ->createImage()
            ->createProperty()
            ->createSku();
    }

    public function safeDown()
    {
        $this->dropTable($this->tableDescription);
        $this->dropTable($this->tableSku);
        $this->dropTable($this->tableImage);
        $this->dropTable($this->tableProperty);
        $this->dropTable($this->tableItem);
    }

    protected function createItem()
    {
        $this->createTable($this->tableItem, [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'image' => Schema::TYPE_STRING . '(255) NOT NULL',
            'price' => Schema::TYPE_DECIMAL . '(15,4) NOT NULL',
            'promo_price' => Schema::TYPE_DECIMAL . '(15,4) DEFAULT NULL',
            'num' => Schema::TYPE_SMALLINT . '(5) NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('category_id', $this->tableItem, 'category_id');
        $this->addForeignKey('item_ibfk_1', $this->tableItem, 'category_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');

        return $this;
    }

    protected function createDescription()
    {
        $this->createTable($this->tableDescription, [
            'id' => Schema::TYPE_PK,
            'item_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'language_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'title' => Schema::TYPE_STRING . '(512) DEFAULT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'meta_desc' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'meta_keyword' => Schema::TYPE_STRING . '(255) DEFAULT NULL'
        ], $this->tableOptions);
        $this->createIndex('item_id', $this->tableDescription, 'item_id');
        $this->createIndex('language_id', $this->tableDescription, 'language_id');
        $this->addForeignKey('item_description_ibfk_1', $this->tableDescription, 'item_id', $this->tableItem, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('item_description_ibfk_2', $this->tableDescription, 'language_id', '{{%language}}', 'id');

        return $this;
    }

    protected function createImage()
    {
        $this->createTable($this->tableImage, [
            'id' => Schema::TYPE_PK,
            'item_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'image' => Schema::TYPE_STRING . '(255) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('item_id', $this->tableImage, 'item_id');
        $this->addForeignKey('item_image_ibfk_1', $this->tableImage, 'item_id', $this->tableItem, 'id', 'CASCADE', 'CASCADE');

        return $this;
    }

    protected function createProperty()
    {
        $this->createTable($this->tableProperty, [
            'id' => Schema::TYPE_PK,
            'item_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'property_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'value_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'is_input' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'image' => Schema::TYPE_STRING . '(255) DEFAULT NULL'
        ], $this->tableOptions);
        $this->createIndex('item_id', $this->tableProperty, 'item_id');
        $this->createIndex('property_id', $this->tableProperty, 'property_id');
        $this->createIndex('value_id', $this->tableProperty, 'value_id');
        $this->addForeignKey('item_property_ibfk_1', $this->tableProperty, 'item_id', $this->tableItem, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('item_property_ibfk_2', $this->tableProperty, 'property_id', '{{%property}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('item_property_ibfk_3', $this->tableProperty, 'value_id', '{{%property}}', 'id', 'CASCADE', 'CASCADE');

        return $this;
    }

    protected function createSku()
    {
        $this->createTable($this->tableSku, [
            'id' => Schema::TYPE_PK,
            'item_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'num' => Schema::TYPE_SMALLINT . '(5) NOT NULL',
            'price' => Schema::TYPE_DECIMAL . '(15,4) NOT NULL',
            'promo_price' => Schema::TYPE_DECIMAL . '(15,4) DEFAULT NULL',
            'image' => Schema::TYPE_STRING . '(512) DEFAULT NULL',
            'property_str' => Schema::TYPE_STRING . '(512) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('item_id', $this->tableSku, 'item_id');
        $this->addForeignKey('item_sku_ibfk_1', $this->tableSku, 'item_id', $this->tableItem, 'id', 'CASCADE', 'CASCADE');

        return $this;
    }
}