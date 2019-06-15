<?php

use yii\db\Migration;

/**
 * Class m190611_044235_add_columns_shopAddress
 */
class m190611_044235_add_columns_userAddress extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%userAddress}}', 'latitude', $this->float());
        $this->addColumn('{{%userAddress}}', 'longitude', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%userAddress}}', 'latitude');
        $this->dropColumn('{{%userAddress}}', 'longitude');
    }
}
