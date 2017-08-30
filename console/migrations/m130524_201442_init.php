<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status'     => "ENUM('not_active', 'active', 'deleted') NOT NULL DEFAULT 'not_active'",
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
