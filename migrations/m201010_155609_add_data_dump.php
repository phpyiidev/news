<?php

use yii\db\Migration;

/**
 * Class m201010_155609_add_data_dump
 * Миграция для загрузки начальных данных в БД из файла.
 */
class m201010_155609_add_data_dump extends Migration
{
    public $maxSqlOutputLength = 100;
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(
            file_get_contents(__DIR__ . '/data/news.sql')
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление всех записей в таблицах
        $this->delete('news_rubrics');
        $this->delete('news');
        $this->delete('rubrics');

        return true;
    }
}
