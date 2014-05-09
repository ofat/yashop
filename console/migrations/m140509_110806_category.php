<?php

use yii\db\Schema;

class m140509_110806_category extends \yii\db\Migration
{
    
    protected $tableCategory = '{{%category}}';
    protected $tableDescription = '{{%category_description}}';
    
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
        }

        $this->createTable($this->tableCategory, [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'url' => Schema::TYPE_STRING . '(255) NOT NULL',
            'is_active' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 1',
        ], $tableOptions);

        $this->createIndex('parent_id', $this->tableCategory, 'parent_id');
        $this->createIndex('url', $this->tableCategory, 'url');
        $this->addForeignKey('category_ibfk_1', $this->tableCategory, 'parent_id', $this->tableCategory, 'id', 'CASCADE', 'CASCADE');

        $this->createTable($this->tableDescription, [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'language_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'text' => Schema::TYPE_TEXT,
            'title' => Schema::TYPE_STRING,
            'meta_desc' => Schema::TYPE_STRING . '(255)',
            'meta_keyword' => Schema::TYPE_STRING . '(255)'
        ], $tableOptions);

        $this->createIndex('language_id', $this->tableDescription, 'language_id');
        $this->createIndex('category_id', $this->tableDescription, 'category_id');
        $this->addForeignKey('category_description_ibfk_1', $this->tableDescription, 'category_id', $this->tableCategory, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('category_description_ibfk_2', $this->tableDescription, 'language_id', '{{%language}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable($this->tableDescription);
        $this->dropTable($this->tableCategory);
    }
}
