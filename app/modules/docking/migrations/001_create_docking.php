<?php

namespace Fuel\Migrations;

class Create_docking
{
	public function up()
	{
		$form = array(
			array(
				'key' => 'docking',
				'name' => 'Docking Form'),
		);

		foreach ($form as $value)
		{
			\DB::insert('forms')->set($value)->execute();
		}

		$fields = array(
			array(
				'form_key' => 'docking',
				'section_id' => 6,
				'type' => 'text',
				'html_name' => 'duration',
				'html_id' => 'duration',
				'html_rows' => 0,
				'label' => 'Duration',
				'placeholder' => 'Enter the duration of your stay',
				'order' => 1),
			array(
				'form_key' => 'docking',
				'section_id' => 6,
				'type' => 'textarea',
				'html_name' => 'reason',
				'html_id' => 'reason',
				'html_rows' => 5,
				'label' => 'Reason for Docking',
				'placeholder' => 'Enter your reason for docking here',
				'order' => 2),
		);

		foreach ($fields as $value)
		{
			\DB::insert('form_fields')->set($value)->execute();
		}

		$sections = array(
			array(
				'form_key' => 'docking',
				'name' => 'Details',
				'order' => 0),
		);

		foreach ($sections as $value)
		{
			\DB::insert('form_sections')->set($value)->execute();
		}

		$navigation = array(
			array(
				'name' => 'Docked Items',
				'group' => 2,
				'order' => 0,
				'url' => 'sim/docked',
				'sim_type' => 3,
				'display' => 0,
				'type' => 'sub',
				'category' => 'sim'),
			array(
				'name' => 'Docking Request',
				'group' => 2,
				'order' => 1,
				'url' => 'sim/dockingrequest',
				'sim_type' => 3,
				'display' => 0,
				'type' => 'sub',
				'category' => 'sim'),
			array(
				'name' => 'Docked Items',
				'group' => 2,
				'order' => 3,
				'url' => 'manage/docked',
				'sim_type' => 3,
				'type' => 'adminsub',
				'category' => 'manage',
				'use_access' => 1,
				'access' => 'manage/docked'),
		);

		foreach ($navigation as $value)
		{
			\DB::insert('navigation')->set($value)->execute();
		}
	}

	public function down()
	{
		\DB::delete('forms')->where('key', 'docking')->execute();
		\DB::delete('form_fields')->where('form_key', 'docking')->execute();
		\DB::delete('form_sections')->where('form_key', 'docking')->execute();

		\DB::delete('navigation')->where('name', 'Docked Items')->execute();
		\DB::delete('navigation')->where('name', 'Docking Request')->execute();
	}
}
