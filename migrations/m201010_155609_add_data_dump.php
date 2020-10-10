<?php

use yii\db\Migration;

/**
 * Class m201010_155609_add_data_dump
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
            file_get_contents(__DIR__ . '\..\data\news.sql')
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('news_rubrics');
        $this->delete('news');
        $this->delete('rubrics');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201010_155609_add_data_dump cannot be reverted.\n";

        return false;
    }
    */
}
