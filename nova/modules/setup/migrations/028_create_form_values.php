<?php

namespace Fuel\Migrations;

class Create_form_values
{
	public function up()
	{
		\DBUtil::create_table('form_values', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'field_id' => array('type' => 'INT', 'constraint' => 11),
			'value' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'content' => array('type' => 'TEXT', 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
		), array('id'));

		$data = array(
			array(
				'field_id' => 1,
				'value' => 'Male',
				'content' => 'Male',
				'order' => 1),
			array(
				'field_id' => 1,
				'value' => 'Female',
				'content' => 'Female',
				'order' => 2),
			array(
				'field_id' => 1,
				'value' => 'Hermaphrodite',
				'content' => 'Hermaphrodite',
				'order' => 3),
			array(
				'field_id' => 1,
				'value' => 'Neuter',
				'content' => 'Neuter',
				'order' => 4),
		);

		foreach ($data as $value)
		{
			\DB::insert('form_values')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('form_values');
	}
}