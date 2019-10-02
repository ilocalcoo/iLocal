<?php

use yii\db\Migration;

/**
 * Class m191002_085302_change_column_begin_happening
 */
class m191002_085302_change_column_begin_happening extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('happening', 'begin', $this->dateTime()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('happening', 'begin', $this->timestamp()->null());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191002_085302_change_column_begin_happening cannot be reverted.\n";

        return false;
    }
    */
}
