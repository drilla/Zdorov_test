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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170909_125805_user_email cannot be reverted.\n";

        return false;
    }
    */
}
