<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shopFiles}}`.
 */
class m191112_061330_create_shopFiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('shopFiles', [
            'id' => $this->primaryKey(),
            'shopId' => $this->integer(),
            'shopFile' => $this->string(),
        ]);
        $this->addForeignKey(
            'fx_shopFile_shop',
            'shopFiles',
            ['shopId'],
            'shop',
            ['shopId'],
            'SET NULL',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_shopFile_shop', 'shopFiles');
        $this->dropTable('shopFiles');
    }
}
