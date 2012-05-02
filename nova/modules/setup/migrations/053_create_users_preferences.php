<?php

namespace Fuel\Migrations;

class Create_users_preferences
{
	public function up()
	{
		\DBUtil::create_table('users_preferences', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'key' => array('type' => 'VARCHAR', 'constraint' => 50),
			'value' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users_preferences');
	}
}