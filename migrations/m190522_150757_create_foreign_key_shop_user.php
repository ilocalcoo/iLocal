<?php

use yii\db\Migration;

/**
 * Class m190522_150757_create_foreign_key_shop_user
 */
class m190522_150757_create_foreign_key_shop_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_shop_user', 'shop', ['creatorId'], 'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_shop_user', 'shop');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190522_150757_create_foreign_key_shop_user cannot be reverted.\n";

        return false;
    }
    */
}
