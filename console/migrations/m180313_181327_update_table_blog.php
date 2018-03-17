<?php

use yii\db\Migration;

/**
 * Class m180313_181327_update_table_blog
 */
class m180313_181327_update_table_blog extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%blog}}','image','string');
    }

    public function down()
    {
        $this->dropColumn('{{%blog}}','image','string');
    }
}
