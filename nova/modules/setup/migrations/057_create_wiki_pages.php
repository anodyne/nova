<?php

namespace Fuel\Migrations;

class Create_wiki_pages
{
	public function up()
	{
		\DBUtil::create_table('wiki_pages', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'draft_id' => array('type' => 'INT', 'constraint' => 11),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
			'created_by_user' => array('type' => 'INT', 'constraint' => 11),
			'created_by_character' => array('type' => 'INT', 'constraint' => 11),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'updated_by_user' => array('type' => 'INT', 'constraint' => 11),
			'updated_by_character' => array('type' => 'INT', 'constraint' => 11),
			'comments' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'type' => array('type' => 'ENUM', 'constraint' => "'standard','system'", 'default' => 'standard'),
			'key' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('wiki_pages');
	}
}