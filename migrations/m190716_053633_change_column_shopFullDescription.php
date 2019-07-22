<?php

use yii\db\Migration;

/**
 * Class m190716_053633_change_column_shopFullDescription
 */
class m190716_053633_change_column_shopFullDescription extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%shop}}', 'shopFullDescription', $this->string(1500));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%shop}}', 'shopFullDescription', $this->string());
    }

}
