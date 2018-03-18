<?php

use yii\db\Migration;

/**
 * Class m180318_140550_create_table_product
 */
class m180318_140550_create_table_product extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%product}}',[
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'cost' => $this->integer(),
            'type_id' => $this->integer()->notNull(),
            'text' => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%product}}');
    }
}
