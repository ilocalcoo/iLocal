<?php

use yii\db\Migration;

/**
 * Class m190526_051227_create_foreing_keys_event_eventType_eventPhoto_shop
 */
class m190526_051227_create_foreing_keys_event_eventType_eventPhoto_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_event_eventType', 'event', ['eventTypeId'], 'eventType', ['id']);
        $this->addForeignKey('fx_event_eventPhoto', 'event', ['eventPhotoId'], 'eventPhoto', ['id']);
        $this->addForeignKey('fx_event_shop', 'event', ['eventOwnerId'], 'shop', ['shopId']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_event_eventType', 'event');
        $this->dropForeignKey('fx_event_eventPhoto', 'event');
        $this->dropForeignKey('fx_event_shop', 'event');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190526_051227_create_foreing_keys_event_eventType_eventPhoto_shop cannot be reverted.\n";

        return false;
    }
    */
}
