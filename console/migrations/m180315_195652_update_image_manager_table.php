<?php

use yii\db\Migration;

/**
 * Class m180315_195652_update_image_manager_table
 */
class m180315_195652_update_image_manager_table extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%image_manager}}','sort',$this->smallInteger(3));
    }

    public function down()
    {
        $this->dropColumn('{{%image_manager}}','sort');
    }
}
