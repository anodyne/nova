<?php

namespace Fuel\Migrations;

class Create_mission_groups
{
	public function up()
	{
		\DBUtil::create_table('mission_groups', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'parent_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('mission_groups');
	}
}