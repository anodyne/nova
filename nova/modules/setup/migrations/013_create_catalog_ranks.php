<?php

namespace Fuel\Migrations;

class Create_catalog_ranks
{
	public function up()
	{
		\DBUtil::create_table('catalog_ranks', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'preview' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'preview.png'),
			'blank' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'blank.png'),
			'extension' => array('type' => 'VARCHAR', 'constraint' => 5, 'default' => '.png'),
			'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
			'credits' => array('type' => 'TEXT'),
			'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
			'genre' => array('type' => 'VARCHAR', 'constraint' => 10, 'default' => '', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('catalog_ranks');
	}
}