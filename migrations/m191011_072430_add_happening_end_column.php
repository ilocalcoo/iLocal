<?php

use yii\db\Migration;

/**
 * Class m191011_072430_add_happening_end_column
 */
class m191011_072430_add_happening_end_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('happening', 'end', $this->dateTime()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('happening', 'end');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191011_072430_add_happening_end_column cannot be reverted.\n";

        return false;
    }
    */
}
