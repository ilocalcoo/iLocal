<?php

use yii\db\Migration;

/**
 * Class m190809_082943_create_user_happening
 */
class m190809_082943_create_user_happening extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('userHappening', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'happeningId' => $this->integer()->notNull(),
            'createdOn'=>$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updatedOn'=>$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('userHappening');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190809_082943_create_user_happening cannot be reverted.\n";

        return false;
    }
    */
}
