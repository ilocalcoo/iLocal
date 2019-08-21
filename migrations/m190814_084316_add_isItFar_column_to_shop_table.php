<?php

use yii\db\Migration;

/**
 * Handles adding isItFar to table `{{%shop}}`.
 */
class m190814_084316_add_isItFar_column_to_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop}}', 'isItFar', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop}}', 'isItFar');
    }
}
