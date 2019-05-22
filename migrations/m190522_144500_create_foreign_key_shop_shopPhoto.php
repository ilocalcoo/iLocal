<?php

use yii\db\Migration;

/**
 * Class m190522_144500_create_foreign_key_shop_shopPhoto
 */
class m190522_144500_create_foreign_key_shop_shopPhoto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_shop_shopPhoto', 'shop', ['shopPhotoId'], 'shopPhoto', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_shop_shopPhoto', 'shop');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190522_144500_create_foreign_key_shop_shopPhoto cannot be reverted.\n";

        return false;
    }
    */
}
