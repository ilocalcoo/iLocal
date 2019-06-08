<?php

use yii\db\Migration;

/**
 * Class m190603_182326_change_columns_user
 */
class m190603_182326_change_columns_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'firstName', 'string NULL');
        $this->alterColumn('{{%user}}', 'lastName', 'string NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'firstName', 'string NOT NULL');
        $this->alterColumn('{{%user}}', 'lastName', 'string NOT NULL');
    }

}
