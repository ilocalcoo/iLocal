<?php

use yii\db\Migration;

/**
 * Class m190601_084312_change_columns_eventPhoto
 */
class m190601_084312_change_columns_eventPhoto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%eventPhoto}}', 'photo1');
        $this->dropColumn('{{%eventPhoto}}', 'photo2');
        $this->dropColumn('{{%eventPhoto}}', 'photo3');
        $this->addColumn('{{%eventPhoto}}', 'eventPhoto', 'string not null');
        $this->addColumn('{{%eventPhoto}}', 'eventId', 'integer not null');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%eventPhoto}}', 'eventPhoto');
        $this->dropColumn('{{%eventPhoto}}', 'eventId');
        $this->addColumn('{{%eventPhoto}}', 'photo1', 'string');
        $this->addColumn('{{%eventPhoto}}', 'photo2', 'string');
        $this->addColumn('{{%eventPhoto}}', 'photo3', 'string');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190601_084312_change_columns_eventPhoto cannot be reverted.\n";

        return false;
    }
    */
}
