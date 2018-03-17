<?php

use yii\db\Migration;

/**
 * Class m180303_123121_update_blog_table
 */
class m180303_123121_update_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('sort','{{%blog}}','sort');
        $this->createIndex('status','{{%blog}}','status_id');
    }

    public function down()
    {
        $this->dropIndex('sort','{{%blog}}');
        $this->dropIndex('status','{{%blog}}');
    }
}
