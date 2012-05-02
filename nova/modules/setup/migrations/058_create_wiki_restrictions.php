<?php

namespace Fuel\Migrations;

class Create_wiki_restrictions
{
	public function up()
	{
		\DBUtil::create_table('wiki_restrictions', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'page_id' => array('type' => 'INT', 'constraint' => 11),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
			'created_by' => array('type' => 'INT', 'constraint' => 11),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'updated_by' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'restrictions' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('wiki_restrictions');
	}
}