<?php

use yii\db\Migration;

/**
 * Class m190809_083014_create_happening_type
 */
class m190809_083014_create_happening_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('happeningType', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('happeningType');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190809_083014_create_happening_type cannot be reverted.\n";

        return false;
    }
    */
}
