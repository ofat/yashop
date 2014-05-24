<?php

use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140524_133342_favorite extends YashopMigration
{
    protected $tableItem = '{{%favorite_item}}';

    public function safeUp()
    {
        parent::safeUp();

        $this->createTable($this->tableItem, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'item_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'description' => Schema::TYPE_STRING . '(512) DEFAULT NULL',
            'created_at' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL',
        ], $this->tableOptions);
        $this->createIndex('user_id', $this->tableItem, 'user_id');
        $this->createIndex('item_id', $this->tableItem, 'item_id');
        $this->addForeignKey('favorite_item_ibfk_1', $this->tableItem, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('favorite_item_ibfk_2', $this->tableItem, 'item_id', '{{%item}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable($this->tableItem);
    }
}
