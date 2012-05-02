<?php

namespace Fuel\Migrations;

class Create_character_promotions
{
	public function up()
	{
		\DBUtil::create_table('character_promotions', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'old_order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'old_rank' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'new_order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'new_rank' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'date' => array('type' => 'BIGINT', 'constraint' => 20),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('character_promotions');
	}
}