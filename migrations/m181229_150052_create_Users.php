<?php

use yii\db\Migration;

/**
 * Class m181229_150052_create_Users
 */
class m181229_150052_create_Users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('User', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'password' => $this->string(),
            'email' => $this->string(),
            'created_at' => $this->dateTime()
        ]);

        $this->addForeignKey(
            'FK-referal-id_referal',
            'referal',
            'id_referal',
            'user',
            'id'
        );

        $this->addForeignKey(
            'FK-referal-id_invited',
            'referal',
            'id_invited',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Drop FK...\n";
        $this->dropForeignKey('FK-referal-id_referal', 'referal');
        $this->dropForeignKey('FK-referal-id_invited', 'referal');

        $this->dropTable('User');
        echo "Drop Table User.\n";



        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181229_150052_create_Users cannot be reverted.\n";

        return false;
    }
    */
}
