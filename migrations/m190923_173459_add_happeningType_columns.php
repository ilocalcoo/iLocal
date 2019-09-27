<?php

use yii\db\Migration;

/**
 * Class m190923_173459_add_happeningType_columns
 */
class m190923_173459_add_happeningType_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('happeningType', 'name', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('happeningType', 'name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_173459_add_happeningType_columns cannot be reverted.\n";

        return false;
    }
    */
}
