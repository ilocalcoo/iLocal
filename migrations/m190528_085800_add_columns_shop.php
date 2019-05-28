<?php

use yii\db\Migration;

/**
 * Class m190528_085800_add_columns_shop
 */
class m190528_085800_add_columns_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('shop', 'shopShortDescription', $this->string());
        $this->addColumn('shop', 'shopFullDescription', $this->string());
        $this->addColumn('shop', 'shopRating', $this->integer());
        $this->dropColumn('shop', 'shopPhotoId');
        $this->alterColumn('shop', 'shopFullName', 'string NULL');
        $this->alterColumn('shop', 'shopAgregator', 'string NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('shop', 'shopShortDescription');
        $this->dropColumn('shop', 'shopFullDescription');
        $this->dropColumn('shop', 'shopRating');
        $this->addColumn('shop', 'shopPhotoId', $this->integer());
        $this->alterColumn('shop', 'shopFullName', 'string NOT NULL');
        $this->alterColumn('shop', 'shopAgregator', 'string NOT NULL');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190528_085800_add_columns_shop cannot be reverted.\n";

        return false;
    }
    */
}
