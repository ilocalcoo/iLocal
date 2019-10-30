<?php

use yii\db\Migration;

/**
 * Class m191011_071941_add_happeningType_data
 */
class m191011_071941_add_happeningType_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('happeningType',['type','name'],[
            ['show','Шоу'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('happeningType',['type' => 'show']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191011_071941_add_happeningType_data cannot be reverted.\n";

        return false;
    }
    */
}
