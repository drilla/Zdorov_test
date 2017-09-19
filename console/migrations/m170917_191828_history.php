<?php

use yii\db\Migration;

class m170917_191828_history extends Migration
{
    public function safeUp()
    {

        /**
         * К истории не делаем внешних ключей, чтобы небыло никаких ее изменений.
         */
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('order_history',
            [
                'id'         => $this->primaryKey(),
                'user_id'    => $this->integer()->null(),
                'order_id'   => $this->integer(),
                'old_values' => $this->string(512),
                'new_values' => $this->string(512),
                'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
            ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('order_history');
    }
}
