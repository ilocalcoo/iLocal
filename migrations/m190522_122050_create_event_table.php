<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event}}`.
 */
class m190522_122050_create_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'shopId' => $this->integer()->notNull(),
            'eventTypeId' => $this->integer()->notNull(),
            'shortDesc' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');
    }
}
