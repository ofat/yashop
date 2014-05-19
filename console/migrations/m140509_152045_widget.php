<?php

use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_152045_widget extends YashopMigration
{

    protected $tableWidget = '{{%widget}}';
    protected $tableDescription = '{{%widget_description}}';
    protected $tableMenu = '{{%widget_menu_item}}';
    protected $tableMenuDescription = '{{%widget_menu_description}}';
    protected $tablePromo = '{{%widget_promo_item}}';

    public function safeUp()
    {
        parent::safeUp();

        $this->createTable($this->tableWidget, [
            'id' => Schema::TYPE_PK,
            'type_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(32) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('alias_type', $this->tableWidget, ['alias', 'type_id'], true);

        $this->createTable($this->tableDescription, [
            'id' => Schema::TYPE_PK,
            'widget_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'language_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'description' => Schema::TYPE_STRING . '(512) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('widget_id', $this->tableDescription, 'widget_id');
        $this->createIndex('language_id', $this->tableDescription, 'language_id');
        $this->addForeignKey('widget_description_ibfk_1', $this->tableDescription, 'widget_id', $this->tableWidget, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('widget_description_ibfk_2', $this->tableDescription, 'language_id', '{{%language}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable($this->tableMenu, [
            'id' => Schema::TYPE_PK,
            'widget_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'parent_id' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL',
            'url' => Schema::TYPE_STRING . '(255) NOT NULL',
            'sort_order' => Schema::TYPE_SMALLINT . '(3) DEFAULT 0'
        ], $this->tableOptions);
        $this->createIndex('widget_id', $this->tableMenu, 'widget_id');
        $this->createIndex('parent_id', $this->tableMenu, 'parent_id');
        $this->addForeignKey('widget_menu_item_ibfk_1', $this->tableMenu, 'widget_id', $this->tableWidget, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('widget_menu_item_ibfk_2', $this->tableMenu, 'parent_id', $this->tableMenu, 'id', 'CASCADE', 'CASCADE');

        $this->createTable($this->tableMenuDescription, [
            'id' => Schema::TYPE_PK,
            'item_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'language_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) DEFAULT NULL'
        ], $this->tableOptions);
        $this->createIndex('item_id', $this->tableMenuDescription, 'item_id');
        $this->createIndex('language_id', $this->tableMenuDescription, 'language_id');
        $this->addForeignKey('widget_menu_description_ibfk_1', $this->tableMenuDescription, 'item_id', $this->tableMenu, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('widget_menu_description_ibfk_2', $this->tableMenuDescription, 'language_id', '{{%language}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable($this->tablePromo, [
            'id' => Schema::TYPE_PK,
            'widget_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'item_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'sort_order' => Schema::TYPE_SMALLINT . '(3) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('widget_id', $this->tablePromo, 'widget_id');
        $this->createIndex('item_id', $this->tablePromo, 'item_id');
        $this->addForeignKey('widget_promo_item_ibfk_1', $this->tablePromo, 'widget_id', $this->tableWidget, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('widget_promo_item_ibfk_2', $this->tablePromo, 'item_id', '{{%item}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable($this->tablePromo);
        $this->dropTable($this->tableMenuDescription);
        $this->dropTable($this->tableMenu);
        $this->dropTable($this->tableWidget);
    }
}
