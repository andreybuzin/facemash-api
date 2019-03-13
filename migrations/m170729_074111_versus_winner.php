<?php

use yii\db\Migration;

class m170729_074111_versus_winner extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%versus}}', 'winner_id', $this->integer()->notNull());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%versus}}', 'winner_id');
    }
}
