<?php

namespace Fuel\Migrations;

class Create_announcements
{
	public function up()
	{
		\DBUtil::create_table('announcements', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'category_id' => array('type' => 'INT', 'constraint' => 11),
			'date' => array('type' => 'BIGINT', 'constraint' => 20),
			'content' => array('type' => 'BLOB'),
			'status' => array('type' => 'ENUM', 'constraint' => "'activated','saved','pending'", 'default' => 'activated'),
			'private' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
			'tags' => array('type' => 'TEXT', 'null' => true),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('announcements');
	}
}