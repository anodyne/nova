<?php

namespace Fuel\Migrations;

class Create_tour
{
	public function up()
	{
		\DBUtil::create_table('tour', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'images' => array('type' => 'TEXT', 'null' => true),
			'summary' => array('type' => 'TEXT', 'null' => true),
			'spec_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('tour');
	}
}