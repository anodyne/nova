<?php

namespace Fuel\Migrations;

class Create_bans
{
	public function up()
	{
		\DBUtil::create_table('bans', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'level' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => true),
			'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'reason' => array('type' => 'TEXT', 'null' => true),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('bans');
	}
}