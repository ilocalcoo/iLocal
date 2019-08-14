<?php

use yii\db\Migration;

/**
 * Class m190814_131357_add_columns_happening
 */
class m190814_131357_add_columns_happening extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('happening', 'happeningPhoto', $this->integer()->notNull());
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
        echo "m190814_131357_add_columns_happening cannot be reverted.\n";

        return false;
    }
    */
}
