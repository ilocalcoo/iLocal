<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%userAddress}}`.
 */
class m190509_204701_create_userAddress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%userAddress}}', [
            'id' => $this->primaryKey(),
            'city' => $this->string()->notNull(),
            'street' => $this->string()->notNull(),
            'houseNumber' => $this->string()->notNull(),
            'housing' => $this->integer(),
            'building' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%userAddress}}');
    }
}
