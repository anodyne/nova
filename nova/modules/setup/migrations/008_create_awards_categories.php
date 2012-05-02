<?php

namespace Fuel\Migrations;

class Create_awards_categories
{
	public function up()
	{
		\DBUtil::create_table('awards_categories', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('awards_categories');
	}
}