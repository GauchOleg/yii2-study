<?php

use yii\db\Migration;

/**
 * Class m180314_193558_create_table_image_manager
 */
class m180314_193558_create_table_image_manager extends Migration
{

    public function up()
    {
        $this->createTable('{{%image_manager}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull(),
            'class' => $this->string(150)->notNull(),
            'item_id' => $this->integer(),
            'alt' => $this->string(150)->notNull(),

        ]);
    }

    public function down()
    {
        $this->dropTable('{{%image_manager}}');
    }
}
