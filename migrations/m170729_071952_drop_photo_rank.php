<?php

use yii\db\Migration;

class m170729_071952_drop_photo_rank extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%photo}}', 'rank');
    }

    public function safeDown()
    {
        $this->addColumn('{{%photo}}', 'rank', $this->integer()->notNull()->defaultValue(0));
    }
}

