<?php

namespace Fuel\Migrations;

class Create_forms
{
	public function up()
	{
		\DBUtil::create_table('forms', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'key' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'orientation' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'vertical'),
		), array('id'));

		$data = array(
			array(
				'key' => 'character',
				'name' => 'Character Information'),
			array(
				'key' => 'user',
				'name' => 'User Information'),
			array(
				'key' => 'specs',
				'name' => 'Specification Item'),
			array(
				'key' => 'tour',
				'name' => 'Tour Item'),
		);

		foreach ($data as $value)
		{
			\DB::insert('forms')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('forms');
	}
}