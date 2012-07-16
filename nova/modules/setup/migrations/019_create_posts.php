<?php

namespace Fuel\Migrations;

class Create_posts
{
	public function up()
	{
		\DBUtil::create_table('posts', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'timeline' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'date' => array('type' => 'BIGINT', 'constraint' => 20),
			'mission_id' => array('type' => 'INT', 'constraint' => 11),
			'saved_user_id' => array('type' => 'INT', 'null' => true),
			'status' => array('type' => 'ENUM', 'constraint' => "'activated','saved','pending'", 'default' => 'activated'),
			'content' => array('type' => 'TEXT', 'null' => true),
			'tags' => array('type' => 'TEXT', 'null' => true),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'participants' => array('type' => 'TEXT', 'null' => true),
			'lock_user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'lock_date' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));

		\DBUtil::create_table('post_authors', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'post_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('posts');
		\DBUtil::drop_table('post_authors');
	}
}