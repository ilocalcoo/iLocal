<?php

use yii\db\Migration;

/**
 * Class m190809_083003_create_happening_photo
 */
class m190809_083003_create_happening_photo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('happeningPhoto', [
            'id' => $this->primaryKey(),
            'happeningId' => $this->integer()->notNull(),
            'happeningPhoto' => $this->string()->notNull(),
        ]);
        $this->addForeignKey(
            'fx_happening_photo',
            'happeningPhoto', ['happeningId'],
            'happening', ['id'],
            'CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('happeningPhoto');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190809_083003_create_happening_photo cannot be reverted.\n";

        return false;
    }
    */
}
