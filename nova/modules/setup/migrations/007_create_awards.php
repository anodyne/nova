<?php

namespace Fuel\Migrations;

class Create_awards
{
	public function up()
	{
		\DBUtil::create_table('awards', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'image' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'category_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'type' => array('type' => 'ENUM', 'constraint' => "'ic','ooc','both'", 'default' => 'ic'),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('awards');
	}
}