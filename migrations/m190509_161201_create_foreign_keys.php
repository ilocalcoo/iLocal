<?php

use yii\db\Migration;

/**
 * Class m190509_161201_create_foreign_keys
 */
class m190509_161201_create_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_shop_shopType', 'shop', ['shopTypeId'], 'shopType', ['id']);
        $this->addForeignKey('fx_shopAddress_shop', 'shopAddress', ['shopId'], 'shop', ['shopId']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_shop_shopType', 'shop');
        $this->dropForeignKey('fx_shopAddress_shop', 'shopAddress');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190509_161201_create_foreign_keys cannot be reverted.\n";

        return false;
    }
    */
}
