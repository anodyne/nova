<?php

namespace Fuel\Migrations;

class Create_message_recipients
{
	public function up()
	{
		\DBUtil::create_table('message_recipients', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'message_id' => array('type' => 'BIGINT', 'constraint' => 20),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'unread' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('message_recipients');
	}
}