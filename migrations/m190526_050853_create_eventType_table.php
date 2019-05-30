<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%eventType}}`.
 */
class m190526_050853_create_eventType_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%eventType}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%eventType}}');
    }
}
