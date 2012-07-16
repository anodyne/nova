<?php

namespace Fuel\Migrations;

class Create_sim_types
{
	public function up()
	{
		\DBUtil::create_table('sim_types', array(
			'id' => array('type' => 'INT', 'constraint' => 2, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 50),
		), array('id'));

		$data = array(
			array('name' => 'all'),
			array('name' => 'ship'),
			array('name' => 'base'),
			array('name' => 'colony'),
			array('name' => 'unit'),
			array('name' => 'realm'),
			array('name' => 'planet'),
			array('name' => 'organization')
		);

		foreach ($data as $value)
		{
			\DB::insert('sim_types')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('sim_types');
	}
}