<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190509_201250_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'lastName' => $this->string()->notNull(),
            'firstName' => $this->string()->notNull(),
            'middleName' => $this->string(),
            'email' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'userAddressId' => $this->integer()->notNull(),
            'fb' => $this->string(),
            'vk' => $this->string(),
            'accessToken' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
