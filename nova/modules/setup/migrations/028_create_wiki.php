<?php

namespace Fuel\Migrations;

class Create_wiki
{
	public function up()
	{
		\DBUtil::create_table('wiki_categories', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
		), array('id'));

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
		\DBUtil::drop_table('wiki_categories');
		\DBUtil::drop_table('wiki_drafts');
		\DBUtil::drop_table('wiki_pages');
		\DBUtil::drop_table('wiki_restrictions');
	}
}