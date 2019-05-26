<?php

use app\models\Event;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%event}}`.
 */
class m190522_122050_create_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'active' => $this->boolean()->defaultValue(Event::STATUS_ACTIVE),
            'isEventTop' => $this->boolean()->defaultValue(Event::MARK_AS_NOT_TOP),
            'eventOwnerId' => $this->integer()->notNull(),
            'eventTypeId' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'eventPhotoId' => $this->integer(),
            'shortDesc' => $this->string()->notNull(),
            'fullDesc' => $this->text()->notNull(),
            'begin' => $this->date()->notNull(),
            'end' => $this->date()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');
    }
}
