<?php

use yii\db\Migration;

/**
 * Class m190601_083642_change_columns_event
 */
class m190601_083642_change_columns_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fx_event_eventPhoto', 'event');
        $this->dropColumn('{{%event}}', 'eventPhotoId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%event}}', 'eventPhotoId', 'integer');
        $this->addForeignKey('fx_event_eventPhoto', 'event', ['eventPhotoId'], 'eventPhoto', ['id']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190601_083642_change_columns_event cannot be reverted.\n";

        return false;
    }
    */
}
