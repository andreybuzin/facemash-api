<?php

use yii\db\Migration;

class m170826_085157_photo_facemash extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%photo}}', 'facemash_id', $this->integer());
        $this->addForeignKey('{{%fk-photo-facemash_id}}', '{{%photo}}', 'facemash_id', '{{%facemash}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-photo-facemash_id}}', '{{%photo}}');
        $this->dropColumn('{{%photo}}', 'facemash_id');
    }
}
