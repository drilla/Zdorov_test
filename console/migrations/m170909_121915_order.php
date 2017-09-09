<?php

use yii\db\Migration;

class m170909_121915_order extends Migration
{
    public function safeUp()
    {
        $this->renameTable('product_request', 'order');
    }

    public function safeDown()
    {
        $this->renameTable('order', 'product_request');
    }
}
