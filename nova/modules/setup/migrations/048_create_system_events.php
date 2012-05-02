<?php

namespace Fuel\Migrations;

class Create_system_events
{
	public function up()
	{
		\DBUtil::create_table('system_events', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'ip' => array('type' => 'VARCHAR', 'constraint' => 16),
			'user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'character_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'content' => array('type' => 'TEXT'),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('system_events');
	}
}