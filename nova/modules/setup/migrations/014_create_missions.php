<?php

namespace Fuel\Migrations;

class Create_missions
{
	public function up()
	{
		\DBUtil::create_table('missions', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'images' => array('type' => 'TEXT', 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'group_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::PENDING),
			'start_date' => array('type' => 'DATETIME', 'null' => true),
			'end_date' => array('type' => 'DATETIME', 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'summary' => array('type' => 'TEXT', 'null' => true),
			'notes' => array('type' => 'TEXT', 'null' => true),
			'notes_updated_at' => array('type' => 'DATETIME', 'null' => true),
		), array('id'));

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
		\DBUtil::drop_table('missions');
		\DBUtil::drop_table('mission_groups');
	}
}