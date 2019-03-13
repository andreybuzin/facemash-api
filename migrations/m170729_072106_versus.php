<?php

use yii\db\Migration;

class m170729_072106_versus extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%versus}}', [
            'id' => $this->primaryKey(),
            'photo1_id' => $this->integer()->notNull(),
            'photo2_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()
        ], $tableOptions);
        $this->addForeignKey('{{%fk-versus-user_id}}', '{{%versus}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-versus-user_id}}', '{{%versus}}');
        $this->dropTable('{{%versus}}');
    }
}
