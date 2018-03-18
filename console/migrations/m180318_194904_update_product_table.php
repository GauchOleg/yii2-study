<?php

use yii\db\Migration;

/**
 * Class m180318_194904_update_product_table
 */
class m180318_194904_update_product_table extends Migration
{

    public function up()
    {
        $this->addColumn('{{%product}}','date',$this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('{{%product}}','date');
    }
}
