<?php

namespace Fuel\Migrations;

class Create_messages
{
	public function up()
	{
		\DBUtil::create_table('messages', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'date' => array('type' => 'BIGINT', 'constraint' => 20),
			'subject' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'content' => array('type' => 'TEXT', 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('messages');
	}
}