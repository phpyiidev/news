<?php

use yii\db\Migration;

/**
 * Class m201005_085549_type_column_text
 * Исправление ошибочного типа данных для поля содержащего текст новости.
 */
class m201005_085549_type_column_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%news}}','text', $this->text()->null()->comment("Текст"));
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%news}}','text', $this->integer()->null()->comment("Текст"));
        return true;
    }
}
