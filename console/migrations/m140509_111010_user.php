<?php

use yii\db\Schema;
use yashop\console\migrations\base\YashopMigration;

class m140509_111010_user extends YashopMigration
{
    protected $tableUser = '{{%user}}';
    protected $tableAddress = '{{%user_address}}';
    protected $tablePayment = '{{%user_payment}}';

    public function safeUp()
    {
        parent::safeUp();

        $this->createTable($this->tableUser, [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->tableOptions);

        $this->createTable($this->tableAddress, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'full_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'zipcode' => Schema::TYPE_STRING . '(32) NOT NULL',
            'country_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'region' => Schema::TYPE_STRING . '(255) NOT NULL',
            'city' => Schema::TYPE_STRING . '(255) NOT NULL',
            'street' => Schema::TYPE_STRING . '(255) NOT NULL',
            'building' => Schema::TYPE_STRING . '(32) NOT NULL',
            'apartment' => Schema::TYPE_STRING . '(32) DEFAULT NULL',
            'phone' => Schema::TYPE_STRING . '(32) NOT NULL',
            'used_count' => Schema::TYPE_SMALLINT . '(5) NOT NULL DEFAULT 0',
            'is_default' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'is_hidden' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0'
        ], $this->tableOptions);
        $this->createIndex('user_id', $this->tableAddress, 'user_id');
        $this->createIndex('country_id', $this->tableAddress, 'country_id');
        $this->addForeignKey('user_address_ibfk_1', $this->tableAddress, 'user_id', $this->tableUser, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('user_address_ibfk_2', $this->tableAddress, 'country_id', '{{%country}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable($this->tablePayment, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'sum' => Schema::TYPE_DECIMAL . '(15,4) NOT NULL',
            'balance' => Schema::TYPE_DECIMAL . '(15,4) NOT NULL',
            'status' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'type' => Schema::TYPE_SMALLINT . '(2) NOT NULL',
            'data' => Schema::TYPE_STRING . '(32) DEFAULT NULL',
            'created' => Schema::TYPE_INTEGER . '(11) NOT NULL'
        ], $this->tableOptions);
        $this->createIndex('user_id', $this->tablePayment, 'user_id');
        $this->addForeignKey('user_payment_ibfk_1', $this->tablePayment, 'user_id', $this->tableUser, 'id', 'CASCADE', 'CASCADE');

        if(!$this->dataImport('user', $this->tableUser))
            return false;
    }

    public function safeDown()
    {
        $this->dropTable($this->tableAddress);
        $this->dropTable($this->tablePayment);
        $this->dropTable($this->tableUser);
    }
}
