<?php

use yii\db\Migration;

class m170804_141804_photo_rank extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%photo}}', 'rank', $this->integer()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%photo}}', 'rank');
    }
}
