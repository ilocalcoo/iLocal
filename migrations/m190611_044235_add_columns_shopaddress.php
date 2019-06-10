<?php

use yii\db\Migration;

/**
 * Class m190611_044235_add_columns_shopaddress
 */
class m190611_044235_add_columns_shopaddress extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%useraddress}}', 'latitude', $this->float());
        $this->addColumn('{{%useraddress}}', 'longitude', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%useraddress}}', 'latitude');
        $this->dropColumn('{{%useraddress}}', 'longitude');
    }
}
