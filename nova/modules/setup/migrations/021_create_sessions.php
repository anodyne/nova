<?php

namespace Fuel\Migrations;

class Create_sessions
{
	public function up()
	{
		\DBUtil::create_table('sessions', array(
			'session_id' => array('type' => 'VARCHAR', 'constraint' => 40),
			'previous_id' => array('type' => 'VARCHAR', 'constraint' => 40),
			'user_agent' => array('type' => 'TEXT'),
			'ip_hash' => array('type' => 'CHAR', 'constraint' => 32),
			'created' => array('type' => 'INT', 'constraint' => 11),
			'updated' => array('type' => 'INT', 'constraint' => 11),
			'payload' => array('type' => 'LONGTEXT'),
		), array('session_id'));

		//\DBUtil::create_index('sessions', 'previous_id');
	}

	public function down()
	{
		\DBUtil::drop_table('sessions');
	}
}