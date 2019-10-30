<?php

use yii\db\Migration;

/**
 * Class m190923_175535_change_happening_shopId_fk
 */
class m190923_175535_change_happening_shopId_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('happening', 'shopId', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190923_175535_change_happening_shopId_fk cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_175535_change_happening_shopId_fk cannot be reverted.\n";

        return false;
    }
    */
}
