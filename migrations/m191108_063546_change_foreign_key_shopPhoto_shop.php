<?php

use yii\db\Migration;

/**
 * Class m191108_063546_change_foreign_key_shopPhoto_shop
 */
class m191108_063546_change_foreign_key_shopPhoto_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fx_shopPhoto_shop', 'shopPhoto');
        $this->addForeignKey(
            'fx_shopPhoto_shop',
            'shopPhoto',
            ['shopId'],
            'shop',
            ['shopId'],
            'SET NULL',
            'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_shopPhoto_shop', 'shopPhoto');
        $this->addForeignKey('fx_shopPhoto_shop', 'shopPhoto', ['shopId'], 'shop', ['shopId']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191108_063546_change_foreign_key_shopPhoto_shop cannot be reverted.\n";

        return false;
    }
    */
}
