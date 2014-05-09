<?php

use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_163854_auth extends YashopMigration
{
    protected $tableItem = '{{%auth_item}}';
    protected $tableRule = '{{%auth_rule}}';
    protected $tableAssign = '{{%auth_assignment}}';
    protected $tableChild = '{{%auth_item_child}}';

    public function safeUp()
    {
        parent::safeUp();

        $this
            ->createRule()
            ->createItem()
            ->createAssign()
            ->createChild();
    }

    public function down()
    {
        $this->dropTable($this->tableChild);
        $this->dropTable($this->tableAssign);
        $this->dropTable($this->tableItem);
        $this->dropTable($this->tableRule);
    }

    protected function createRule()
    {
        $this->createTable($this->tableRule, [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL',
        ], $this->tableOptions);
        $this->addPrimaryKey('name', $this->tableRule, 'name');

        return $this;
    }

    protected function createItem()
    {
        $this->createTable($this->tableItem, [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'type' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'rule_name' => Schema::TYPE_STRING . '(64) DEFAULT NULL',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL',
            'updated_at' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL',
        ], $this->tableOptions);
        $this->addPrimaryKey('name', $this->tableItem, 'name');
        $this->createIndex('rule_name', $this->tableItem, 'rule_name');
        $this->createIndex('type', $this->tableItem, 'type');
        $this->addForeignKey('auth_item_ibfk_1', $this->tableItem, 'rule_name', $this->tableRule, 'name', 'SET NULL', 'CASCADE');

        return $this;
    }

    protected function createAssign()
    {
        $this->createTable($this->tableAssign, [
            'item_name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL'
        ], $this->tableOptions);
        $this->addPrimaryKey('auth_assignment_pk', $this->tableAssign, ['item_name', 'user_id']);
        $this->createIndex('user_id', $this->tableAssign, 'user_id');
        $this->addForeignKey('auth_assignment_ibfk_1', $this->tableAssign, 'item_name', $this->tableItem, 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('auth_assignment_ibfk_2', $this->tableAssign, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        return $this;
    }

    protected function createChild()
    {
        $this->createTable($this->tableChild, [
            'parent' => Schema::TYPE_STRING . '(64) NOT NULL',
            'child' => Schema::TYPE_STRING . '(64) NOT NULL'
        ], $this->tableOptions);
        $this->addPrimaryKey('auth_item_child_pk', $this->tableChild, ['parent', 'child']);
        $this->createIndex('child', $this->tableChild, 'child');
        $this->addForeignKey('auth_item_child_ibfk_1', $this->tableChild, 'parent', $this->tableItem, 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('auth_item_child_ibfk_2', $this->tableChild, 'child', $this->tableItem, 'name', 'CASCADE', 'CASCADE');

        return $this;
    }
}
