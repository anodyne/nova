<?php

namespace Fuel\Migrations;

class Create_users_suspended
{
	public function up()
	{
		\DBUtil::create_table('users_suspended', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'login_id' => array('type' => 'VARCHAR', 'constraint' => 50),
			'attempts' => array('type' => 'INT', 'constraint' => 50),
			'ip' => array('type' => 'VARCHAR', 'constraint' => 16),
			'last_attempt_at' => array('type' => 'BIGINT', 'constraint' => 20),
			'suspended_at' => array('type' => 'BIGINT', 'constraint' => 20),
			'unsuspend_at' => array('type' => 'BIGINT', 'constraint' => 20),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users_suspended');
	}
}