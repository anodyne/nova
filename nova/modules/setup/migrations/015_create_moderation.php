<?php

namespace Fuel\Migrations;

class Create_moderation
{
	public function up()
	{
		\DBUtil::create_table('moderation', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'character_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'type' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'created_at' => array('type' => 'DATETIME'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('moderation');
	}
}