<?php

use yii\db\Migration;

/**
 * Class m190601_085205_create_foreign_key_eventPhoto_event
 */
class m190601_085205_create_foreign_key_eventPhoto_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_eventPhoto_event', 'eventPhoto', ['eventId'], 'event', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_eventPhoto_event', 'eventPhoto');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190601_085205_create_foreign_key_eventPhoto_event cannot be reverted.\n";

        return false;
    }
    */
}
