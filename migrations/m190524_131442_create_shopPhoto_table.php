<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shopPhoto}}`.
 */
class m190524_131442_create_shopPhoto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shopPhoto}}', [
            'id' => $this->primaryKey(),
            'shopId' => $this->integer(),
            'shopPhoto' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shopPhoto}}');
    }
}
