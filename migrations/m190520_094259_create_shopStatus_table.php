<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shopStatus}}`.
 */
class m190520_094259_create_shopStatus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shopStatus}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shopStatus}}');
    }
}
