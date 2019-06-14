<?php

use yii\db\Migration;

/**
 * Class m190611_082011_change_columns_shop
 */
class m190611_082011_change_columns_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%shop}}', 'shopAddressId', $this->integer());
        $this->alterColumn('{{%shop}}', 'shopStatusId', $this->integer()->defaultValue(2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_shop_shopStatus', 'shop');
        $this->alterColumn('{{%shop}}', 'shopStatusId', $this->integer()->notNull());
        $this->addForeignKey('fx_shop_shopStatus', 'shop', 'shopStatusId', 'shopStatus', 'id');
        $this->dropForeignKey('fx_shop_shopAddress', 'shop');
        $this->alterColumn('{{%shop}}', 'shopAddressId', $this->integer()->notNull());
        $this->addForeignKey('fx_shop_shopAddress', 'shop', 'shopAddressId', 'shopAddress', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_082011_change_columns_shop cannot be reverted.\n";

        return false;
    }
    */
}
