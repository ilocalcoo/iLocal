<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%eventPhoto}}`.
 */
class m190526_051018_create_eventPhoto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%eventPhoto}}', [
            'id' => $this->primaryKey(),
            'photo1' => $this->string(),
            'photo2' => $this->string(),
            'photo3' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%eventPhoto}}');
    }
}
