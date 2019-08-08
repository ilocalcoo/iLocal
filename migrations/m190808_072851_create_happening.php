<?php

use yii\db\Migration;

/**
 * Class m190808_072851_create_happening
 */
class m190808_072851_create_happening extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('happening', [
            'id' => $this->primaryKey(),
            'shopId' => $this->integer()->notNull(),
            'creatorId' => $this->integer()->notNull(),
            'title'=>$this->string(150)->notNull(),
            'description'=>$this->text(),
            'address'=>$this->string(256)->notNull(),
            'price' => $this->float(),
            'begin'=>$this->date(),
            'createdOn'=>$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updatedOn'=>$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fx_happening_user',
            'happening', ['creatorId'],
            'user', ['id'],
            'CASCADE','CASCADE');
        $this->addForeignKey(
            'fx_happening_shop',
            'happening', ['shopId'],
            'shop', ['shopId'],
            'CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('happening');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190808_072851_create_happening cannot be reverted.\n";

        return false;
    }
    */
}
