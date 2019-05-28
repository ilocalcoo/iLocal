<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shopAddress}}`.
 */
class m190520_094126_create_shopAddress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shopAddress}}', [
            'id' => $this->primaryKey(),
            'city' => $this->string()->notNull(),
            'street' => $this->string()->notNull(),
            'houseNumber' => $this->string()->notNull(),
            'housing' => $this->integer(),
            'building' => $this->integer(),
            'latitude' => $this->float(),
            'longitude' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shopAddress}}');
    }
}
