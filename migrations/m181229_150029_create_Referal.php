<?php

use yii\db\Migration;

/**
 * Class m181229_150029_create_Referal
 */
class m181229_150029_create_Referal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('referal', [
            'id' => $this->primaryKey(),
            'id_referal' => $this->integer(),
            'id_invited' => $this->integer(),
            'created_at' => $this->dateTime()
        ]);

        $this->insert('referal', [

            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Drop table referal\n";
        $this->dropTable('referal');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181229_150029_create_Referal cannot be reverted.\n";

        return false;
    }
    */
}
