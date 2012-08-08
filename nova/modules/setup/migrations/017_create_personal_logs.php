<?php

namespace Fuel\Migrations;

class Create_personal_logs
{
	public function up()
	{
		\DBUtil::create_table('personal_logs', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'content' => array('type' => 'TEXT', 'null' => true),
			'date' => array('type' => 'BIGINT', 'constraint' => 20),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
			'tags' => array('type' => 'TEXT', 'null' => true),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('personal_logs');
	}
}