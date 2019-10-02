<?php

use yii\db\Migration;

/**
 * Class m191002_072808_happening_address_columns
 */
class m191002_072808_happening_address_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('happening', 'latitude', $this->float()->null());
        $this->addColumn('happening', 'longitude', $this->float()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('happening', 'latitude');
        $this->dropColumn('happening', 'longitude');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191002_072808_happening_address_columns cannot be reverted.\n";

        return false;
    }
    */
}
