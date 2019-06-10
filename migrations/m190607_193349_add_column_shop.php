<?php

use yii\db\Migration;

/**
 * Class m190607_193349_add_column_shop
 */
class m190607_193349_add_column_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('shop', 'shopLinkPdf', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('shop', 'shopLinkPdf');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190607_193349_add_column_shop cannot be reverted.\n";

        return false;
    }
    */
}
