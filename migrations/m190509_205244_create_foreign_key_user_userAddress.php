<?php

use yii\db\Migration;

/**
 * Class m190509_205244_create_foreign_key_user_userAddress
 */
class m190509_205244_create_foreign_key_user_userAddress extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_user_userAddress', 'user', ['userAddressId'], 'userAddress', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_user_userAddress', 'user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190509_205244_create_foreign_key_user_userAddress cannot be reverted.\n";

        return false;
    }
    */
}
