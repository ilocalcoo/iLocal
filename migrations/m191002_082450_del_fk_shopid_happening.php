<?php

use yii\db\Migration;

/**
 * Class m191002_082450_del_fk_shopid_happening
 */
class m191002_082450_del_fk_shopid_happening extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fx_happening_shop',
            'happening');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addForeignKey(
            'fx_happening_shop',
            'happening', ['shopId'],
            'shop', ['shopId'],
            'CASCADE','CASCADE');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191002_082450_del_fk_shopid_happening cannot be reverted.\n";

        return false;
    }
    */
}
