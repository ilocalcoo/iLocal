<?php

use yii\db\Migration;

/**
 * Class m190524_131602_create_foreign_key_shopPhoto_shop
 */
class m190524_131602_create_foreign_key_shopPhoto_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_shopPhoto_shop', 'shopPhoto', ['shopId'], 'shop', ['shopId']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_shopPhoto_shop', 'shopPhoto');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190524_131602_create_foreign_key_shopPhoto_shop cannot be reverted.\n";

        return false;
    }
    */
}
