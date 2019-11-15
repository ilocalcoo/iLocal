<?php

use yii\db\Migration;

/**
 * Class m191115_065619_add_happenings_active_column
 */
class m191115_065619_add_happenings_active_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('happening', 'active', $this->integer(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('happening', 'active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191115_065619_add_happenings_active_column cannot be reverted.\n";

        return false;
    }
    */
}
