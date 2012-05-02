<?php

namespace Fuel\Migrations;

class Create_announcement_categories
{
	public function up()
	{
		\DBUtil::create_table('announcement_categories', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
		), array('id'));

		$data = array(
			array('name' => 'General'),
			array('name' => 'Sim'),
			array('name' => 'In-Character'),
			array('name' => 'Out-of-Character'),
			array('name' => 'Website Update'),
		);

		foreach ($data as $value)
		{
			\DB::insert('announcement_categories')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('announcement_categories');
	}
}