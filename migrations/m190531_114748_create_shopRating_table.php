<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shopRating}}`.
 */
class m190531_114748_create_shopRating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shopRating}}', [
            'userId' => $this->primaryKey(),
            'shopId' => $this->primaryKey(),
            'rating' => $this->integer()->notNull()->defaultValue('0'),
        ]);
        $this->addForeignKey('fk-shopRating_shop', 'shopRating', 'shopId', 'shop', 'shopId');
        $this->addForeignKey('fk-shopRating_user', 'shopRating', 'userId', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-shopRating_shop', 'shopRating');
        $this->dropForeignKey('fk-shopRating_user', 'shopRating');
        $this->dropTable('{{%shopRating}}');
    }
}
