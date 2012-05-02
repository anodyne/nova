<?php

namespace Fuel\Migrations;

class Create_catalog_modules
{
	public function up()
	{
		\DBUtil::create_table('catalog_modules', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'short_name' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'protected' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
			'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive'", 'default' => 'active'),
			'credits' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('catalog_modules');
	}
}