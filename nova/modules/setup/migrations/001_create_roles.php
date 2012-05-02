<?php

namespace Fuel\Migrations;

class Create_roles
{
	public function up()
	{
		\DBUtil::create_table('roles', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'inherits' => array('type' => 'TEXT', 'null' => true),
		), array('id'));

		$data = array(
			array(
				'name' => 'Inactive User',
				'desc' => "Inactive users have no privileges within the system. This role is automatically assigned to any user with who has been retired.",
				'inherits' => ''),
			array(
				'name' => 'User',
				'desc' => "Every user in the system starts with these permissions. This role is automatically assigned to any user who is not retired.",
				'inherits' => ''),
			array(
				'name' => 'Active User',
				'desc' => "Every active user in the system has these permissions.",
				'inherits' => '2'),
			array(
				'name' => 'Power User',
				'desc' => "Power users are given more access to pieces of the system to help them assist the game master as necessary.",
				'inherits' => '2,3'),
			array(
				'name' => 'Administrator',
				'desc' => "Like power users, administrators are given higher permissions to the system to help them assist the game master as necessary.",
				'inherits' => '2,3,4'),
			array(
				'name' => 'System Administrator',
				'desc' => "System administrators have complete control over the system. This role should only be assigned to a select few individuals who are trusted to run the game.",
				'inherits' => '2,3,4,5'),
		);

		foreach ($data as $value)
		{
			\DB::insert('roles')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('roles');
	}
}