<?php

namespace Fuel\Migrations;

class Create_media
{
	public function up()
	{
		\DBUtil::create_table('media', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'filename' => array('type' => 'TEXT', 'null' => true),
			'mime_type' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'resource_type' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('media');
	}
}