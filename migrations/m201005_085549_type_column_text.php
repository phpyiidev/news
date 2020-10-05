<?php

use yii\db\Migration;

/**
 * Class m201005_085549_type_column_text
 */
class m201005_085549_type_column_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%news}}','text', $this->text()->null()->comment("Текст"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201005_085549_type_column_text cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201005_085549_type_column_text cannot be reverted.\n";

        return false;
    }
    */
}
