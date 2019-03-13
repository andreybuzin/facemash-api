<?php

use yii\db\Migration;

class m170728_183628_photo_rank extends Migration
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
