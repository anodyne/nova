<?php

namespace Fuel\Migrations;

class Create_roles_tasks
{
	public function up()
	{
		\DBUtil::create_table('roles_tasks', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'role_id' => array('type' => 'INT', 'constraint' => 11),
			'task_id' => array('type' => 'INT', 'constraint' => 11),
		), array('id'));

		$data = array(
			2 => array(1, 2, 3, 6),
			3 => array(14, 11, 18, 23, 33, 9, 20, 25, 88, 90, 37),
			4 => array(91, 12, 15, 28, 38),
			5 => array(21, 26, 31, 92, 94, 16, 17, 13, 7, 35, 36, 39),
			6 => array(4, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 89),
		);

		foreach ($data as $key => $value)
		{
			foreach ($value as $task)
			{
				\DB::insert('roles_tasks')
					->set(array(
						'role_id' => $key,
						'task_id' => $task
					))
					->execute();
			}
		}
	}

	public function down()
	{
		\DBUtil::drop_table('roles_tasks');
	}
}