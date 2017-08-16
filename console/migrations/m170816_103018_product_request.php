<?php

use yii\db\Migration;

class m170816_103018_product_request extends Migration
{
    public function safeUp()
    {
        $this->createTable('product_request', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'client_name' => $this->string(256)->notNull(),
            'client_phone' => $this->string(64)->notNull(),
            'client_comment' => $this->text(),
            'status' => "ENUM('new', 'accepted','rejected','discarded') NOT NULL DEFAULT 'new'",
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('product_request');
    }
}
