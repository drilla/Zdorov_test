<?php

use yii\db\Migration;

class m170910_182045_fk_order_product extends Migration
{
    public function safeUp() {
        $this->addForeignKey('fk_order_product', 'order', 'product_id', 'product', 'id', 'SET NULL', 'SET NULL');
    }

    public function safeDown() {
        $this->dropForeignKey('fk_order_product', 'order');
    }
}
