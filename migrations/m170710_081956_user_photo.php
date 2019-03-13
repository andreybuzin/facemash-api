<?php

use yii\db\Migration;

class m170710_081956_user_photo extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user_photo}}', [
            'photo_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull()
        ], $tableOptions);
        $this->addPrimaryKey('pk_user_photo', '{{%user_photo}}', ['photo_id', 'user_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_photo}}');
    }
}
