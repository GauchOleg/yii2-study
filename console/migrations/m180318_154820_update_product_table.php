<?php

use yii\db\Migration;

/**
 * Class m180318_154820_update_product_table
 */
class m180318_154820_update_product_table extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%product}}', 'sklad_id', $this->integer()->notNull());

        $this->createIndex('sklad_id','{{%product}}','sklad_id');
        $this->addForeignKey('sklad_id','{{%product}}','sklad_id','{{%sklad}}','id');
    }

    public function down()
    {
        $this->dropForeignKey('sklad_id','{{%product}}');
        $this->dropColumn('{{%product}}', 'sklad_id');
    }
}
