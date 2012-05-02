<?php

namespace Fuel\Migrations;

class Create_coc
{
	public function up()
	{
		\DBUtil::create_table('coc', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'order' => array('type' => 'INT', 'constraint' => 5),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('coc');
	}
}
