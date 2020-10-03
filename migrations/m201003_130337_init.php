<?php

use yii\db\Migration;

/**
 * Class m201003_130337_init
 */
class m201003_130337_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rubrics}}', [
            'id' => $this->primaryKey()->comment("Код"),
            'name' => $this->string(42)->notNull()->comment("Название"),
            'id_parent' => $this->integer()->null()->comment("Код родительской рубрики"),
        ], $tableOptions);
        $this->addCommentOnTable('{{%rubrics}}', 'Рубрики');

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey()->comment("Код"),
            'name' => $this->string(42)->notNull()->comment("Заголовок"),
            'text' => $this->integer()->null()->comment("Текст"),
        ], $tableOptions);
        $this->addCommentOnTable('{{%news}}', 'Новости');

        $this->createTable('{{%news_rubrics}}', [
            'id_new' => $this->integer()->notNull()->comment("Код новости"),
            'id_rubric' => $this->integer()->notNull()->comment("Код рубрики"),
        ], $tableOptions);
        $this->addCommentOnTable('{{%news_rubrics}}', 'Новостные рубрики');

        

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_rubrics}}');
        $this->dropTable('{{%news}}');
        $this->dropTable('{{%rubrics}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201003_130337_init cannot be reverted.\n";

        return false;
    }
    */
}
