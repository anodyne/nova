<?php

namespace Fuel\Migrations;

class Create_users
{
	public function up()
	{
		\DBUtil::create_table('users', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'status' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'pending'),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'password' => array('type' => 'VARCHAR', 'constraint' => 96, 'null' => true),
			'character_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'role_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'join_date' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'leave_date' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'last_post' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'last_login' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'password_reset_hash' => array('type' => 'VARCHAR', 'constraint' => 24, 'null' => true),
			'temp_password' => array('type' => 'VARCHAR', 'constraint' => 96, 'null' => true),
			'remember_me' => array('type' => 'VARCHAR', 'constraint' => 24, 'null' => true),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users');
	}
}