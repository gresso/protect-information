<?php

use yii\db\Schema;
use yii\db\Migration;

class m150703_074325_Users extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('user', [
            'id' => 'pk',
            'email' => 'string UNIQUE',
            'pasw' => 'string',
            'authKey'=>'string',
            'accessToken'=>'string',
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('user');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
