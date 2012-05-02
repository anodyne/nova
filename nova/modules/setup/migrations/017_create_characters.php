<?php

namespace Fuel\Migrations;

class Create_characters
{
	public function up()
	{
		\DBUtil::create_table('characters', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'first_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'middle_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'last_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'suffix' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','pending','archived'", 'default' => 'pending'),
			'activated' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'deactivated' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'rank_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 1),
			'last_post' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('characters');
	}
}