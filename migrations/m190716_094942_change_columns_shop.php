<?php

use yii\db\Migration;

/**
 * Class m190716_094942_change_columns_shop
 */
class m190716_094942_change_columns_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('shop', 'shopMiddleCost', "enum('','1', '2', '3', '4', '5')");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('shop', 'shopMiddleCost', "enum('1', '2', '3', '4', '5')");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190716_094942_change_columns_shop cannot be reverted.\n";

        return false;
    }
    */
}
