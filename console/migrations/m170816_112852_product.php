<?php

use yii\db\Migration;

class m170816_112852_product extends Migration
{
    public function safeUp()
    {
        $this->createTable('product', [
            'id'     => $this->primaryKey(),
            'name'   => $this->string(256)->notNull(),
            'price'  => $this->money(2,2),
            'status' => $this->boolean()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('product');
    }
}
