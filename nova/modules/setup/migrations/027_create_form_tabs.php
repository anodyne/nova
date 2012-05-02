<?php

namespace Fuel\Migrations;

class Create_form_tabs
{
	public function up()
	{
		\DBUtil::create_table('form_tabs', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'link_id' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));

		$data = array(
			array(
				'form_key' => 'character',
				'name' => 'Basic Info',
				'link_id' => 'one',
				'order' => 1),
			array(
				'form_key' => 'character',
				'name' => 'Personality',
				'link_id' => 'two',
				'order' => 2),
			array(
				'form_key' => 'character',
				'name' => 'History',
				'link_id' => 'three',
				'order' => 3),
		);

		foreach ($data as $value)
		{
			\DB::insert('form_tabs')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('form_tabs');
	}
}