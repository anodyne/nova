<?php

namespace Fuel\Migrations;

class Create_awards_received
{
	public function up()
	{
		\DBUtil::create_table('awards_received', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'receive_character_id' => array('type' => 'INT', 'constraint' => 11),
			'receive_user_id' => array('type' => 'INT', 'constraint' => 11),
			'nominate_character_id' => array('type' => 'INT', 'constraint' => 11),
			'award_id' => array('type' => 'INT', 'constraint' => 11),
			'date' => array('type' => 'BIGINT', 'constraint' => 20),
			'reason' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('awards_received');
	}
}