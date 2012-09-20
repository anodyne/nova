<?php

namespace Fuel\Migrations;

class Create_users
{
	public function up()
	{
		\DBUtil::create_table('users', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::PENDING),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'password' => array('type' => 'VARCHAR', 'constraint' => 96, 'null' => true),
			'character_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'role_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'password_reset_hash' => array('type' => 'VARCHAR', 'constraint' => 24, 'null' => true),
			'temp_password' => array('type' => 'VARCHAR', 'constraint' => 96, 'null' => true),
			'remember_me' => array('type' => 'VARCHAR', 'constraint' => 24, 'null' => true),
			'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => true),
			'leave_date' => array('type' => 'DATETIME', 'null' => true),
			'last_post' => array('type' => 'DATETIME', 'null' => true),
			'last_login' => array('type' => 'DATETIME', 'null' => true),
			'created_at' => array('type' => 'DATETIME', 'null' => true),
			'updated_at' => array('type' => 'DATETIME', 'null' => true),
		), array('id'));

		\DBUtil::create_table('user_loas', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'start' => array('type' => 'DATETIME'),
			'end' => array('type' => 'DATETIME', 'null' => true),
			'duration' => array('type' => 'TEXT', 'null' => true),
			'reason' => array('type' => 'TEXT', 'null' => true),
			'type' => array('type' => 'ENUM', 'constraint' => "'active','loa','eloa'", 'default' => 'loa'),
		), array('id'));

		\DBUtil::create_table('user_preferences', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'key' => array('type' => 'VARCHAR', 'constraint' => 50),
			'value' => array('type' => 'TEXT', 'null' => true),
		), array('id'));

		\DBUtil::create_table('user_suspended', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'login_id' => array('type' => 'VARCHAR', 'constraint' => 50),
			'attempts' => array('type' => 'INT', 'constraint' => 50),
			'ip' => array('type' => 'VARCHAR', 'constraint' => 16),
			'last_attempt_at' => array('type' => 'DATETIME'),
			'suspended_at' => array('type' => 'DATETIME', 'null' => true),
			'unsuspend_at' => array('type' => 'DATETIME', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users');
		\DBUtil::drop_table('user_loas');
		\DBUtil::drop_table('user_preferences');
		\DBUtil::drop_table('user_suspended');
	}
}