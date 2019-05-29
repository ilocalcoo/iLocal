<?php

use yii\db\Migration;

/**
 * Class m190523_195201_add_columns_user
 */
class m190523_195201_add_columns_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'username', $this->string()->notNull());
        $this->addColumn('{{%user}}', 'auth_key', $this->string()->notNull());
        $this->addColumn('{{%user}}', 'password_reset_token', $this->string()->notNull());
        $this->addColumn('{{%user}}', 'updated_at', $this->integer()->notNull());

        $this->dropForeignKey('fx_user_userAddress', 'user');
        $this->alterColumn('{{%user}}', 'userAddressId', 'integer NULL');
        $this->addForeignKey('fx_user_userAddress', 'user', ['userAddressId'], 'userAddress', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'username');
        $this->dropColumn('{{%user}}', 'auth_key');
        $this->dropColumn('{{%user}}', 'password_reset_token');
        $this->dropColumn('{{%user}}', 'updated_at');

        $this->dropForeignKey('fx_user_userAddress', 'user');
        $this->alterColumn('{{%user}}', 'userAddressId', 'integer NOT NULL');
        $this->addForeignKey('fx_user_userAddress', 'user', ['userAddressId'], 'userAddress', ['id']);
    }

}
