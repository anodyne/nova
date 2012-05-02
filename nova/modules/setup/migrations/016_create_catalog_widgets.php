<?php

namespace Fuel\Migrations;

class Create_catalog_widgets
{
	public function up()
	{
		\DBUtil::create_table('catalog_widgets', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'page' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'zone' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
			'credits' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('catalog_widgets');
	}
}