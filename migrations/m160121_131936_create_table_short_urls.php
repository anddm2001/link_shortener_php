<?php

use yii\db\Schema;
use yii\db\Migration;

class m160121_131936_create_table_short_urls extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%short_urls}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'long_url' => Schema::TYPE_TEXT . ' NOT NULL',
            'short_url' => Schema::TYPE_STRING . '(5) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'counter' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ], $tableOptions);

        $this->createTable('{{%user_info}}', [
            'id' => Schema::TYPE_PK,
            'short_url_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_platform' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'user_agent' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'user_refer' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'user_ip' => Schema::TYPE_STRING . ' NOT NULL',
            'user_country' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'user_city' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('FK_short_url', '{{%short_urls}}', 'short_url', true);
        $this->createIndex('FK_user_id', '{{%short_urls}}', 'user_id');
        $this->createIndex('FK_short_url_id', '{{%user_info}}', 'short_url_id');
        $this->addForeignKey(
            'FK_short_url_id', '{{%user_info}}', 'short_url_id', '{{%short_urls}}', 'id', 'CASCADE', 'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%user_info}}');
        $this->dropTable('{{%short_urls}}');
    }
}