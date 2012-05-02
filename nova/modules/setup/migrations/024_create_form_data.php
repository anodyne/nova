<?php

namespace Fuel\Migrations;

class Create_form_data
{
	public function up()
	{
		\DBUtil::create_table('form_data', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
			'field_id' => array('type' => 'BIGINT', 'constraint' => 20),
			'user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'character_id' => array('type' => 'VARCHAR', 'constraint' => 11, 'null' => true),
			'item_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'value' => array('type' => 'TEXT', 'null' => true),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('form_data');
	}
}