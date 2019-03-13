<?php

use yii\db\Migration;

class m170816_072505_facemash extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%facemash}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'user_id' => $this->integer()
        ], $tableOptions);
        $this->addForeignKey('{{%fk-facemash-user_id}}', '{{%facemash}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-facemash-user_id}}', '{{%facemash}}');
        $this->dropTable('{{%facemash}}');
    }
}
