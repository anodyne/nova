<?php

namespace Fuel\Migrations;

class Create_tour_decks
{
	public function up()
	{
		\DBUtil::create_table('tour_decks', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'content' => array('type' => 'TEXT', 'null' => true),
			'tour_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('tour_decks');
	}
}