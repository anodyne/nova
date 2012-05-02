<?php

namespace Fuel\Migrations;

class Create_applications
{
	public function up()
	{
		\DBUtil::create_table('applications', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'email' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'user_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'character_name' => array('type' => 'TEXT', 'null' => true),
			'position' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'date' => array('type' => 'BIGINT', 'constraint' => 20),
			'action' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'message' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('applications');
	}
}