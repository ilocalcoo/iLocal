<?php

use yii\db\Migration;

/**
 * Class m190610_080654_change_columns_event
 */
class m190610_080654_change_columns_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%event}}', 'creatorId', $this->integer());
        $this->alterColumn('{{%event}}', 'title', 'string NULL');
        $this->alterColumn('{{%event}}', 'shortDesc', 'string NULL');
        $this->alterColumn('{{%event}}', 'fullDesc', 'text NULL');
        $this->alterColumn('{{%event}}', 'begin', 'string NULL');
        $this->alterColumn('{{%event}}', 'end', 'string NULL');
        $this->addForeignKey('fk_event_user', 'event', 'creatorId', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_event_user', 'event');
        $this->dropColumn('{{%event}}', 'creatorId');
        $this->alterColumn('{{%event}}', 'title', 'string NOT NULL');
        $this->alterColumn('{{%event}}', 'shortDesc', 'string NOT NULL');
        $this->alterColumn('{{%event}}', 'fullDesc', 'text NOT NULL');
        $this->alterColumn('{{%event}}', 'begin', 'string NOT NULL');
        $this->alterColumn('{{%event}}', 'end', 'string NOT NULL');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190610_080654_change_columns_event cannot be reverted.\n";

        return false;
    }
    */
}
