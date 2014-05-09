<?php

use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_152045_widget_menu extends YashopMigration
{

    protected $tableMenu = '{{%widget_menu}}';
    protected $tableItem = '{{%widget_menu_item}}';

    public function safeUp()
    {
        parent::safeUp();

        $this->createTable($this->tableMenu, [
            'id' => Schema::TYPE_PK,
            'ru' => Schema::TYPE_STRING . '(255) NOT NULL',
            'en' => Schema::TYPE_STRING . '(255) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(32) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('alias', $this->tableMenu, 'alias', true);

        $this->createTable($this->tableItem, [
            'id' => Schema::TYPE_PK,
            'menu_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'parent_id' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL',
            'ru' => Schema::TYPE_STRING . '(255) NOT NULL',
            'en' => Schema::TYPE_STRING . '(255) NOT NULL',
            'url' => Schema::TYPE_STRING . '(255) NOT NULL',
            'sort_order' => Schema::TYPE_SMALLINT . '(3) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('menu_id', $this->tableItem, 'menu_id');
        $this->createIndex('parent_id', $this->tableItem, 'parent_id');

        $this->addForeignKey('widget_menu_item_ibfk_1', $this->tableItem, 'menu_id', $this->tableMenu, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('widget_menu_item_ibfk_2', $this->tableItem, 'parent_id', $this->tableItem, 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable($this->tableItem);
        $this->dropTable($this->tableMenu);
    }
}
