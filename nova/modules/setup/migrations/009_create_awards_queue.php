<?php

namespace Fuel\Migrations;

class Create_awards_queue
{
	public function up()
	{
		\DBUtil::create_table('awards_queue', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'receive_character_id' => array('type' => 'INT', 'constraint' => 11),
			'receive_user_id' => array('type' => 'INT', 'constraint' => 11),
			'nominate_character_id' => array('type' => 'INT', 'constraint' => 11),
			'award_id' => array('type' => 'INT', 'constraint' => 11),
			'reason' => array('type' => 'TEXT', 'null' => true),
			'status' => array('type' => 'ENUM', 'constraint' => "'pending','accepted','rejected'", 'default' => 'pending'),
			'date' => array('type' => 'BIGINT', 'constraint' => 20),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('awards_queue');
	}
}