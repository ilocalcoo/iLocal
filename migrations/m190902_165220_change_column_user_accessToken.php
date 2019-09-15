<?php

use yii\db\Migration;

/**
 * Class m190902_165220_change_column_user_accessToken
 */
class m190902_165220_change_column_user_accessToken extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'accessToken', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'accessToken', 'string');
    }

}
