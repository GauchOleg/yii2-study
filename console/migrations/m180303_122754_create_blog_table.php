<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog`.
 */
class m180303_122754_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
            'text' => $this->text(),
            'url' => $this->string(150)->notNull(),
            'status_id' => $this->tinyInteger(1)->defaultValue(1),
            'sort' => $this->tinyInteger(2)->defaultValue(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog}}');
    }
}
