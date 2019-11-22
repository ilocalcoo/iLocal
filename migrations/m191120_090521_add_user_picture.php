<?php

use yii\db\Migration;

/**
 * Class m191120_090521_add_user_picture
 */
class m191120_090521_add_user_picture extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'picture', $this->string(512)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'picture');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191120_090521_add_user_picture cannot be reverted.\n";

        return false;
    }
    */
}
