<?php

use yii\db\Migration;

/**
 * Class m190520_094527_create_foreign_keys
 */
class m190520_094527_create_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_shop_shopType', 'shop', ['shopTypeId'], 'shopType', ['id']);
        $this->addForeignKey('fx_shop_shopAddress', 'shop', ['shopAddressId'], 'shopAddress', ['id']);
        $this->addForeignKey('fx_shop_shopStatus', 'shop', ['shopStatusId'], 'shopStatus', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_shop_shopType', 'shop');
        $this->dropForeignKey('fx_shop_shopAddress', 'shop');
        $this->dropForeignKey('fx_shop_shopStatus', 'shop');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190520_094527_create_foreign_keys cannot be reverted.\n";

        return false;
    }
    */
}
