<?php

use yii\db\Migration;

class m170816_112852_product extends Migration
{
    public function safeUp() {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('product', [
            'id'     => $this->primaryKey(),
            'name'   => $this->string(256)->notNull(),
            'price'  => $this->money(10, 2),
            'status' =>"ENUM('active', 'not_active') NOT NULL DEFAULT 'active'",
        ], $tableOptions);
    }

    public function safeDown() {
        $this->dropTable('product');
    }
}
