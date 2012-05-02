<?php

namespace Fuel\Migrations;

class Create_post_authors
{
	public function up()
	{
		\DBUtil::create_table('post_authors', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'post_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('post_authors');
	}
}