<?php

use yii\db\Migration;

class m170816_072804_versus_facemash extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%versus}}', 'facemash_id', $this->integer()->notNull());
        $this->addForeignKey('{{%fk-versus-facemash_id}}', '{{%versus}}', 'facemash_id', '{{%facemash}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-versus-facemash_id}}', '{{%versus}}');
        $this->dropColumn('{{%versus}}', 'facemash_id');
    }
}
