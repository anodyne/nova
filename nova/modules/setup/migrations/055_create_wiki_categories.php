<?php

namespace Fuel\Migrations;

class Create_wiki_categories
{
	public function up()
	{
		\DBUtil::create_table('wiki_categories', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('wiki_categories');
	}
}