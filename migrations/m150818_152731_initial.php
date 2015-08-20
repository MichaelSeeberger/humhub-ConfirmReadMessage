<?php
/**
 * Created by: Michael Seeberger
 * Date: 18.08.15
 * Time: 15:27
 */

class m150818_152731_initial extends EDbMigration {
    public function up()
    {
        $this->createTable('confirm_read_message', array(
            'id' => 'pk',
            'message' => 'TEXT NOT NULL',
            'created_at' => 'datetime NOT NULL',
            'created_by' => 'int(11) NOT NULL',
            'updated_at' => 'datetime NOT NULL',
            'updated_by' => 'int(11) NOT NULL',
        ));

        $this->createTable('confirm_read_message_user', array(
            'id' => 'pk',
            'confirm_read_message_id' => 'int(11) NOT NULL',
            'created_at' => 'datetime NOT NULL',
            'created_by' => 'int(11) NOT NULL',
            'updated_at' => 'datetime NOT NULL',
            'updated_by' => 'int(11) NOT NULL',
        ));
    }

    public function down()
    {
        echo "m150818_152731_initial does not support migration down.\n";
        return false;
    }
}
