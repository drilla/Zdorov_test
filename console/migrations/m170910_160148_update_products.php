<?php

use yii\db\Migration;

class m170910_160148_update_products extends Migration
{
    public function safeUp()
    {
        $this->insert('product', ['name' => 'Чай', 'price' => 29.99, 'status' => 'active']);
        $this->insert('product', ['name' => 'Кофе', 'price' => 130, 'status' => 'active']);
        $this->insert('product', ['name' => 'Сахар', 'price' => 38.99, 'status' => 'active']);
        $this->insert('product', ['name' => 'Хлеб', 'price' => 20, 'status' => 'active']);
        $this->insert('product', ['name' => 'Пылесос', 'price' => 1229, 'status' => 'active']);
    }

    public function safeDown()
    {
        $this->delete('product');
    }
}
