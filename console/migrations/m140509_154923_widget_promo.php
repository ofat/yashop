<?php

use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_154923_widget_promo extends YashopMigration
{
    protected $tablePromo = '{{%widget_promo}}';
    protected $tableItem = '{{%widget_promo_item}}';

    public function safeUp()
    {
        parent::safeUp();

        $this->createTable($this->tablePromo, [
            'id' => Schema::TYPE_PK,
            'ru' => Schema::TYPE_STRING . '(255) NOT NULL',
            'en' => Schema::TYPE_STRING . '(255) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(32) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('alias', $this->tablePromo, 'alias', true);

        $this->createTable($this->tableItem, [
            'id' => Schema::TYPE_PK,
            'promo_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'item_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'sort_order' => Schema::TYPE_SMALLINT . '(3) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('promo_id', $this->tableItem, 'promo_id');
        $this->createIndex('item_id', $this->tableItem, 'item_id');
        $this->addForeignKey('widget_promo_item_ibfk_1', $this->tableItem, 'promo_id', $this->tablePromo, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('widget_promo_item_ibfk_2', $this->tableItem, 'item_id', '{{%item}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable($this->tableItem);
        $this->dropTable($this->tablePromo);
    }
}
