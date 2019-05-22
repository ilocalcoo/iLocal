<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shopPhoto}}`.
 */
class m190522_143116_create_shopPhoto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shopPhoto}}', [
            'id' => $this->primaryKey(),
            'shopPhoto1' => $this->string(),
            'shopPhoto2' => $this->string(),
            'shopPhoto3' => $this->string(),
            'shopPhoto4' => $this->string(),
            'shopPhoto5' => $this->string(),
            'shopPhoto6' => $this->string(),
            'shopPhoto7' => $this->string(),
            'shopPhoto8' => $this->string(),
            'shopPhoto9' => $this->string(),
            'shopPhoto10' => $this->string(),
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
