<?php

namespace Fuel\Migrations;

class Create_specs
{
	public function up()
	{
		\DBUtil::create_table('specs', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'images' => array('type' => 'TEXT', 'null' => true),
			'summary' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('specs');
	}
}