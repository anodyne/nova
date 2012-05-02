<?php

namespace Fuel\Migrations;

class Create_form_sections
{
	public function up()
	{
		\DBUtil::create_table('form_sections', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
			'tab_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));

		$data = array(
			array(
				'form_key' => 'character',
				'tab_id' => 1,
				'name' => 'Character Information',
				'order' => 0),
			array(
				'form_key' => 'character',
				'tab_id' => 1,
				'name' => 'Physical Appearance',
				'order' => 1),
			array(
				'form_key' => 'character',
				'tab_id' => 1,
				'name' => 'Family',
				'order' => 2),
			array(
				'form_key' => 'character',
				'tab_id' => 2,
				'name' => 'Personality &amp; Traits',
				'order' => 0),
			array(
				'form_key' => 'character',
				'tab_id' => 3,
				'name' => '',
				'order' => 0),
			array(
				'form_key' => 'specs',
				'name' => 'General',
				'order' => 0),
			array(
				'form_key' => 'specs',
				'name' => 'Dimensions',
				'order' => 1),
			array(
				'form_key' => 'specs',
				'name' => 'Personnel',
				'order' => 2),
			array(
				'form_key' => 'specs',
				'name' => 'Speed',
				'order' => 3),
			array(
				'form_key' => 'specs',
				'name' => 'Weapons &amp; Defensive Systems',
				'order' => 4),
			array(
				'form_key' => 'specs',
				'name' => 'Auxiliary Craft',
				'order' => 5),
		);

		foreach ($data as $value)
		{
			\DB::insert('form_sections')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('form_sections');
	}
}