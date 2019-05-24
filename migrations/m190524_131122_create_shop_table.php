<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop}}`.
 */
class m190524_131122_create_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop}}', [
            'shopId' => $this->primaryKey(),
            'creatorId' => $this->integer()->notNull(),
            'shopActive' => $this->boolean()->defaultValue(1),
            'shopShortName' => $this->string(20)->notNull(),
            'shopFullName' => $this->string()->notNull(),
            'shopTypeId' => $this->integer()->notNull(),
            'shopPhone' => $this->string(20)->notNull(),
            'shopWeb' => $this->string()->notNull(),
            'shopAddressId' => $this->integer()->notNull(),
            'shopCostMin' => $this->integer()->notNull(),
            'shopCostMax' => $this->integer()->notNull(),
            'shopMiddleCost' => "enum('1', '2', '3', '4', '5')",
            'shopWorkTime' => $this->string(),
            'shopAgregator' => $this->string()->notNull(),
            'shopDescription' => $this->string(),
            'shopRating' => $this->integer(),
            'shopStatusId' => $this->integer()->notNull(),
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
