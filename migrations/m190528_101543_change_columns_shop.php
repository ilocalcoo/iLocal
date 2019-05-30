<?php

use yii\db\Migration;

/**
 * Class m190528_101543_change_columns_shop
 */
class m190528_101543_change_columns_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('shop', 'shopPhone', 'string NULL');
        $this->alterColumn('shop', 'shopWeb', 'string NULL');
        $this->alterColumn('shop', 'shopCostMin', 'string NULL');
        $this->alterColumn('shop', 'shopCostMax', 'string NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('shop', 'shopPhone', 'string NOT NULL');
        $this->alterColumn('shop', 'shopWeb', 'string NOT NULL');
        $this->alterColumn('shop', 'shopCostMin', 'string NOT NULL');
        $this->alterColumn('shop', 'shopCostMax', 'string NOT NULL');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190528_101543_change_columns_shop cannot be reverted.\n";

        return false;
    }
    */
}
