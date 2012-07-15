<?php

namespace Fuel\Migrations;

class Create_tour
{
	public function up()
	{
		\DBUtil::create_table('tour', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'images' => array('type' => 'TEXT', 'null' => true),
			'summary' => array('type' => 'TEXT', 'null' => true),
			'spec_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
		), array('id'));

		\DBUtil::create_table('tour_decks', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'content' => array('type' => 'TEXT', 'null' => true),
			'tour_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
		), array('id'));

		\DBUtil::create_table('specs', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'images' => array('type' => 'TEXT', 'null' => true),
			'summary' => array('type' => 'TEXT', 'null' => true),
		), array('id'));

		$data = array(
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

		$data = array(
			array(
				'form_key' => 'specs',
				'section_id' => 7,
				'type' => 'text',
				'html_name' => 'class',
				'html_id' => 'class',
				'html_rows' => 0,
				'label' => 'Class',
				'placeholder' => 'Enter the class of vessel',
				'order' => 0),
			array(
				'form_key' => 'specs',
				'section_id' => 7,
				'type' => 'text',
				'html_name' => 'role',
				'html_id' => 'role',
				'html_rows' => 0,
				'label' => 'Role',
				'placeholder' => 'Enter the role of the vessel',
				'order' => 1),
			array(
				'form_key' => 'specs',
				'section_id' => 7,
				'type' => 'text',
				'html_name' => 'duration',
				'html_id' => 'duration',
				'html_rows' => 0,
				'label' => 'Duration',
				'placeholder' => 'Enter the duration of the vessel',
				'order' => 2),
			array(
				'form_key' => 'specs',
				'section_id' => 7,
				'type' => 'text',
				'html_name' => 'refit',
				'html_id' => 'refit',
				'html_rows' => 0,
				'label' => 'Time Between Refits',
				'placeholder' => 'Enter the time between refits for this vessel',
				'order' => 3),
			array(
				'form_key' => 'specs',
				'section_id' => 7,
				'type' => 'text',
				'html_name' => 'resupply',
				'html_id' => 'resupply',
				'html_rows' => 0,
				'label' => 'Time Between Resupply',
				'placeholder' => 'Enter the time between resupply of this vessel',
				'order' => 0),
			array(
				'form_key' => 'specs',
				'section_id' => 8,
				'type' => 'text',
				'html_name' => 'length',
				'html_id' => 'length',
				'html_rows' => 0,
				'label' => 'Length',
				'placeholder' => 'e.g. 415 meters',
				'order' => 0),
			array(
				'form_key' => 'specs',
				'section_id' => 8,
				'type' => 'text',
				'html_name' => 'width',
				'html_id' => 'width',
				'html_rows' => 0,
				'label' => 'Width',
				'placeholder' => 'e.g. 75 meters',
				'order' => 1),
			array(
				'form_key' => 'specs',
				'section_id' => 8,
				'type' => 'text',
				'html_name' => 'height',
				'html_id' => 'height',
				'html_rows' => 0,
				'label' => 'Height',
				'placeholder' => 'e.g. 45 meters',
				'order' => 2),
			array(
				'form_key' => 'specs',
				'section_id' => 8,
				'type' => 'text',
				'html_name' => 'decks',
				'html_id' => 'decks',
				'html_rows' => 0,
				'html_class' => 'medium',
				'label' => 'Decks',
				'placeholder' => 'e.g. 10',
				'order' => 3),
			array(
				'form_key' => 'specs',
				'section_id' => 9,
				'type' => 'text',
				'html_name' => 'compliment_officers',
				'html_id' => 'compliment_officers',
				'html_rows' => 0,
				'html_class' => 'medium',
				'label' => 'Officers',
				'placeholder' => 'e.g. 60',
				'order' => 0),
			array(
				'form_key' => 'specs',
				'section_id' => 9,
				'type' => 'text',
				'html_name' => 'compliment_enlisted',
				'html_id' => 'compliment_enlisted',
				'html_rows' => 0,
				'html_class' => 'medium',
				'label' => 'Enlisted Crew',
				'placeholder' => 'e.g. 500',
				'order' => 1),
			array(
				'form_key' => 'specs',
				'section_id' => 9,
				'type' => 'text',
				'html_name' => 'compliment_marines',
				'html_id' => 'compliment_marines',
				'html_rows' => 0,
				'html_class' => 'medium',
				'label' => 'Marines',
				'placeholder' => 'e.g. 48',
				'order' => 2),
			array(
				'form_key' => 'specs',
				'section_id' => 9,
				'type' => 'text',
				'html_name' => 'compliment_civilians',
				'html_id' => 'compliment_civilians',
				'html_rows' => 0,
				'html_class' => 'medium',
				'label' => 'Civilians',
				'placeholder' => 'e.g. 200',
				'order' => 3),
			array(
				'form_key' => 'specs',
				'section_id' => 9,
				'type' => 'text',
				'html_name' => 'compliment_emergency',
				'html_id' => 'compliment_emergency',
				'html_rows' => 0,
				'html_class' => 'medium',
				'label' => 'Emergency Capacity',
				'placeholder' => 'e.g. 2000',
				'order' => 4),
			array(
				'form_key' => 'specs',
				'section_id' => 10,
				'type' => 'text',
				'html_name' => 'speed_normal',
				'html_id' => 'speed_normal',
				'html_rows' => 0,
				'html_class' => 'medium',
				'label' => 'Cruise Speed',
				'placeholder' => 'e.g. Warp 6',
				'order' => 0),
			array(
				'form_key' => 'specs',
				'section_id' => 10,
				'type' => 'text',
				'html_name' => 'speed_max',
				'html_id' => 'speed_max',
				'html_rows' => 0,
				'html_class' => 'medium',
				'label' => 'Maximum Speed',
				'placeholder' => 'e.g. Warp 9',
				'order' => 1),
			array(
				'form_key' => 'specs',
				'section_id' => 10,
				'type' => 'text',
				'html_name' => 'speed_emergency',
				'html_id' => 'speed_emergency',
				'html_rows' => 0,
				'html_class' => 'medium',
				'label' => 'Emergency Speed',
				'placeholder' => 'e.g. Warp 9.9975',
				'order' => 2),
			array(
				'form_key' => 'specs',
				'section_id' => 11,
				'type' => 'textarea',
				'html_name' => 'defensive',
				'html_id' => 'defensive',
				'html_rows' => 5,
				'label' => 'Shields',
				'placeholder' => 'e.g. Enter your vessel\'s defensive systems here',
				'order' => 0),
			array(
				'form_key' => 'specs',
				'section_id' => 11,
				'type' => 'textarea',
				'html_name' => 'weapons',
				'html_id' => 'weapons',
				'html_rows' => 5,
				'label' => 'Weapon Systems',
				'placeholder' => 'e.g. Enter your vessel\'s weapon systems here',
				'order' => 1),
			array(
				'form_key' => 'specs',
				'section_id' => 11,
				'type' => 'textarea',
				'html_name' => 'armament',
				'html_id' => 'armament',
				'html_rows' => 5,
				'label' => 'Armament',
				'placeholder' => 'e.g. Enter your vessel\'s armament here',
				'order' => 2),
			array(
				'form_key' => 'specs',
				'section_id' => 12,
				'type' => 'text',
				'html_name' => 'shuttlebays',
				'html_id' => 'shuttlebays',
				'html_rows' => 0,
				'html_class' => 'small',
				'label' => 'Shuttlebays',
				'order' => 0),
			array(
				'form_key' => 'specs',
				'section_id' => 12,
				'type' => 'textarea',
				'html_name' => 'shuttles',
				'html_id' => 'shuttles',
				'html_rows' => 5,
				'label' => 'Shuttles',
				'placeholder' => 'Enter your vessel\'s shuttles here',
				'order' => 1),
			array(
				'form_key' => 'specs',
				'section_id' => 12,
				'type' => 'textarea',
				'html_name' => 'fighters',
				'html_id' => 'fighters',
				'html_rows' => 5,
				'label' => 'Fighters',
				'placeholder' => 'Enter your vessel\'s fighters here',
				'order' => 2),
			array(
				'form_key' => 'specs',
				'section_id' => 12,
				'type' => 'textarea',
				'html_name' => 'runabouts',
				'html_id' => 'runabouts',
				'html_rows' => 5,
				'label' => 'Runabouts',
				'placeholder' => 'Enter your vessel\'s runabouts here',
				'order' => 3),
			array(
				'form_key' => 'tour',
				'type' => 'text',
				'html_name' => 'location',
				'html_id' => 'location',
				'html_rows' => 0,
				'label' => 'Location',
				'placeholder' => 'Enter the tour item\'s location here',
				'order' => 0),
			array(
				'form_key' => 'tour',
				'type' => 'textarea',
				'html_name' => 'long_desc',
				'html_id' => 'long_desc',
				'html_rows' => 5,
				'label' => 'Description',
				'placeholder' => 'Enter the tour item\'s description here',
				'order' => 1),
		);

		foreach ($data as $value)
		{
			\DB::insert('form_fields')->set($value)->execute();
		}

		$data = array(
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
		\DBUtil::drop_table('tour');
		\DBUtil::drop_table('tour_decks');
		\DBUtil::drop_table('specs');

		$fields = \DB::select('*')->from('form_fields')
			->where('form_key', 'specs')
			->or_where('form_key', 'tour')
			->execute();

		if (count($fields) > 0)
		{
			foreach ($fields as $f)
			{
				\DB::delete('form_data')->where('field_id', $f->id)->execute();
			}
		}

		\DB::delete('form_sections')
			->where('key', 'specs')
			->where('key', 'tour')
			->execute();

		\DB::delete('form_fields')
			->where('key', 'specs')
			->where('key', 'tour')
			->execute();

		\DB::delete('forms')
			->where('key', 'specs')
			->where('key', 'tour')
			->execute();
	}
}