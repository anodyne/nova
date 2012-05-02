<?php

namespace Fuel\Migrations;

class Create_wiki_drafts
{
	public function up()
	{
		\DBUtil::create_table('wiki_drafts', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'id_old' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'summary' => array('type' => 'TEXT', 'null' => true),
			'content' => array('type' => 'TEXT', 'null' => true),
			'page_id' => array('type' => 'INT', 'constraint' => 11),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
			'categories' => array('type' => 'TEXT', 'null' => true),
			'change_comments' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('wiki_drafts');
	}
}