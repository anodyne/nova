<?php

namespace Fuel\Migrations;

class Create_character_positions
{
	public function up()
	{
		\DBUtil::create_table('character_positions', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'position_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'primary' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('character_positions');
	}
}