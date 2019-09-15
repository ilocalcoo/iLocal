<?php

use yii\db\Migration;

/**
 * Class m190814_083624_add_happening_columns
 */
class m190814_083624_add_happening_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('happening', 'happeningTypeId', $this->integer()->notNull());
        $this->addForeignKey(
            'fx_happening_type',
            'happening', ['happeningTypeId'],
            'happeningType', ['id'],
            'CASCADE','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fx_happening_type',
            'happening'
        );
        $this->dropColumn('happening', 'happeningTypeId');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190814_083624_add_happening_columns cannot be reverted.\n";

        return false;
    }
    */
}
