<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop}}`.
 */
class m190509_113535_create_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop}}', [
            'shopId' => $this->primaryKey(),
            'shopShortName' => $this->string(20)->notNull(),
            'shopFullName' => $this->string()->notNull(),
            'shopPhoto' => $this->string()->notNull(),
            'shopTypeId' => $this->integer()->notNull(),
            'shopPhone' => $this->string(20)->notNull(),
            'shopWeb' => $this->string()->notNull(),
            'shopCostMin' => $this->integer()->notNull(),
            'shopCostMax' => $this->integer()->notNull(),
            'shopMiddleCost' => "enum('1', '2', '3', '4', '5')",
            'shopAgregator' => $this->string()->notNull(),
            'shopStatus' => $this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop}}');
    }
}
