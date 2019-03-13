<?php

use yii\db\Migration;

class m190313_073319_sample_data extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('{{%facemash}}', ['id', 'name'], [
            [1, 'Кофе'], 
            [2, 'Девоньки']
        ]);

        $this->batchInsert('{{%photo}}', ['person', 'link', 'facemash_id'], [
            ['Американо', 'amerikano.jpeg', 1],
            ['Капучино', 'kapuchino.jpeg', 1],
            ['Латте', 'latte.jpeg', 1],
            ['Мокко', 'mokko.jpeg', 1],
            ['Раф', 'raf.jpeg', 1],
            ['Гляссе', 'glyasse.jpeg', 1],
            ['Аня', 'girl1.jpeg', 2],
            ['Даша', 'girl2.jpeg', 2],
            ['Маша', 'girl3.jpeg', 2],
            ['Настя', 'girl4.jpeg', 2],
            ['Кристина', 'girl5.jpeg', 2],
            ['Ксения', 'girl6.jpeg', 2],
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%facemash}}', ['id' => 1]);
        $this->delete('{{%facemash}}', ['id' => 2]);
    }
}
