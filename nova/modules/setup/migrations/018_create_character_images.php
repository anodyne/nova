<?php

namespace Fuel\Migrations;

class Create_character_images
{
	public function up()
	{
		\DBUtil::create_table('character_images', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'image' => array('type' => 'TEXT', 'null' => true),
			'primary_image' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
			'created_by' => array('type' => 'INT', 'constraint' => 11),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('character_images');
	}
}