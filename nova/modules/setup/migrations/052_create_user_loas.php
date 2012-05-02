<?php

namespace Fuel\Migrations;

class Create_user_loas
{
	public function up()
	{
		\DBUtil::create_table('user_loas', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'start' => array('type' => 'BIGINT', 'constraint' => 20),
			'end' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'duration' => array('type' => 'TEXT', 'null' => true),
			'reason' => array('type' => 'TEXT', 'null' => true),
			'type' => array('type' => 'ENUM', 'constraint' => "'active','loa','eloa'", 'default' => 'loa'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('user_loas');
	}
}