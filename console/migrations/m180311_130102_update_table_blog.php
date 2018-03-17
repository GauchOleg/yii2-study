<?php

use yii\db\Migration;

/**
 * Class m180311_130102_update_table_blog
 */
class m180311_130102_update_table_blog extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%blog}}','user_id',$this->integer()->defaultValue(1));
    }

    public function down()
    {
        $this->dropColumn('{{%blog}}','user_id');
    }
}
