<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_shop}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%shop}}`
 */
class m190611_170831_create_junction_table_for_user_and_shop_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_shop}}', [
            'user_id' => $this->integer(),
            'shop_id' => $this->integer(),
            'PRIMARY KEY(user_id, shop_id)',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_shop-user_id}}',
            '{{%user_shop}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_shop-user_id}}',
            '{{%user_shop}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `shop_id`
        $this->createIndex(
            '{{%idx-user_shop-shop_id}}',
            '{{%user_shop}}',
            'shop_id'
        );

        // add foreign key for table `{{%shop}}`
        $this->addForeignKey(
            '{{%fk-user_shop-shop_id}}',
            '{{%user_shop}}',
            'shop_id',
            '{{%shop}}',
            'shopId',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_shop-user_id}}',
            '{{%user_shop}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_shop-user_id}}',
            '{{%user_shop}}'
        );

        // drops foreign key for table `{{%shop}}`
        $this->dropForeignKey(
            '{{%fk-user_shop-shop_id}}',
            '{{%user_shop}}'
        );

        // drops index for column `shop_id`
        $this->dropIndex(
            '{{%idx-user_shop-shop_id}}',
            '{{%user_shop}}'
        );

        $this->dropTable('{{%user_shop}}');
    }
}
