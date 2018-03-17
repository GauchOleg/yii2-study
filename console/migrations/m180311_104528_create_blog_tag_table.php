<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog_tag`.
 */
class m180311_104528_create_blog_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_tag}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        $this->createIndex('blog_id','{{%blog_tag}}','blog_id');
        $this->createIndex('tag_id','{{%blog_tag}}','tag_id');

        $this->addForeignKey('blog_id_fk','{{%blog_tag}}','blog_id','{{%blog}}','id');
        $this->addForeignKey('tag_id_fk','{{%blog_tag}}','tag_id','{{%tag}}','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('blog_tag');
    }
}
