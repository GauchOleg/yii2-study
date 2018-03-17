<?php

use yii\db\Migration;

/**
 * Class m180311_180634_update_table_blog
 */
class m180311_180634_update_table_blog extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%blog}}','date_create',$this->dateTime());
        $this->addColumn('{{%blog}}','date_update',$this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('{{%blog}}','date_create');
        $this->dropColumn('{{%blog}}','date_update');
    }
}
