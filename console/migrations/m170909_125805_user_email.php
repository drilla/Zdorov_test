<?php

use yii\db\Migration;

class m170909_125805_user_email extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'email', $this->string(256)->notNull());

    }

    public function safeDown()
    {
        $this->dropColumn('user', 'email');
    }
}
