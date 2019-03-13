<?php

use yii\db\Migration;

class m170710_081924_photo extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%photo}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string()->notNull(),
            'person' => $this->string()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%photo}}');
    }
}
