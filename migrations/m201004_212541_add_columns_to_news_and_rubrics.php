<?php

use yii\db\Migration;

/**
 * Class m201004_212541_add_columns_to_news_and_rubrics
 * Миграция для добавление полей с информацией о создании/изменении записей. Данные поля используются поведениями,
 * которые автоматически сохраняют информацию о времени создания/изменения записи, а так же о пользователе
 * создавшим/изменившим запись
 */
class m201004_212541_add_columns_to_news_and_rubrics extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'created_by', $this->integer()->null()->comment("Создал"));
        $this->addColumn('{{%news}}', 'updated_by', $this->integer()->null()->comment("Изменил"));
        $this->addColumn('{{%news}}', 'created_at', $this->integer()->null()->comment("Создано"));
        $this->addColumn('{{%news}}', 'updated_at', $this->integer()->null()->comment("Изменено"));

        $this->addColumn('{{%rubrics}}', 'created_by', $this->integer()->null()->comment("Создал"));
        $this->addColumn('{{%rubrics}}', 'updated_by', $this->integer()->null()->comment("Изменил"));
        $this->addColumn('{{%rubrics}}', 'created_at', $this->integer()->null()->comment("Создано"));
        $this->addColumn('{{%rubrics}}', 'updated_at', $this->integer()->null()->comment("Изменено"));

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%news}}', 'created_by');
        $this->dropColumn('{{%news}}', 'updated_by');
        $this->dropColumn('{{%news}}', 'created_at');
        $this->dropColumn('{{%news}}', 'updated_at');

        $this->dropColumn('{{%rubrics}}', 'created_by');
        $this->dropColumn('{{%rubrics}}', 'updated_by');
        $this->dropColumn('{{%rubrics}}', 'created_at');
        $this->dropColumn('{{%rubrics}}', 'updated_at');

        return true;
    }
}
