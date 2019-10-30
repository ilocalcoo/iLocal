<?php

use yii\db\Migration;

/**
 * Class m190923_174239_add_happeningType_data
 */
class m190923_174239_add_happeningType_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('happeningType',['type','name'],[
            ['food','Еда'],
            ['child','Дети'],
            ['sport','Спорт'],
            ['city','Город'],
            ['fair','Ярмарка'],
            ['creation','Творчество'],
            ['theatre','Театр'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('happeningType');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_174239_add_happeningType_data cannot be reverted.\n";

        return false;
    }
    */
}
