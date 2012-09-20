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
				'key' => 'app',
				'name' => 'Application Information'),
		);

		foreach ($data as $value)
		{
			\DB::insert('forms')->set($value)->execute();
		}

		\DBUtil::create_table('form_data', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
			'field_id' => array('type' => 'BIGINT', 'constraint' => 20),
			'user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'character_id' => array('type' => 'VARCHAR', 'constraint' => 11, 'null' => true),
			'item_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'value' => array('type' => 'TEXT', 'null' => true),
			'updated_at' => array('type' => 'DATETIME', 'null' => true),
		), array('id'));

		\DBUtil::create_table('form_fields', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
			'section_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'type' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'text'),
			'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
			'restriction' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'help' => array('type' => 'TEXT', 'null' => true),
			'selected' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'value' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'html_name' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'html_id' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'html_class' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => 'span4'),
			'html_rows' => array('type' => 'INT', 'constraint' => 3, 'default' => 5),
			'placeholder' => array('type' => 'TEXT', 'null' => true),
			'updated_at' => array('type' => 'DATETIME', 'null' => true),
		), array('id'));

		$data = array(
			array(
				'form_key' => 'character',
				'section_id' => 1,
				'type' => 'select',
				'html_name' => 'gender',
				'html_id' => 'gender',
				'html_rows' => 0,
				'label' => 'Gender',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 1,
				'type' => 'text',
				'html_name' => 'species',
				'html_id' => 'species',
				'html_rows' => 0,
				'label' => 'Species',
				'placeholder' => 'e.g. Human',
				'order' => 2),
			array(
				'form_key' => 'character',
				'section_id' => 1,
				'type' => 'text',
				'html_name' => 'age',
				'html_id' => 'age',
				'html_rows' => 0,
				'html_class' => 'span1',
				'label' => 'Age',
				'placeholder' => 'Age',
				'order' => 3),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'height',
				'html_id' => 'height',
				'html_rows' => 0,
				'label' => 'Height',
				'placeholder' => 'e.g. 6\'2"',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'weight',
				'html_id' => 'weight',
				'html_rows' => 0,
				'label' => 'Weight',
				'placeholder' => 'e.g. 215 lbs.',
				'order' => 2),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'hair_color',
				'html_id' => 'hair_color',
				'html_rows' => 0,
				'label' => 'Hair Color',
				'placeholder' => 'Hair Color',
				'order' => 3),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'text',
				'html_name' => 'eye_color',
				'html_id' => 'eye_color',
				'html_rows' => 0,
				'label' => 'Eye Color',
				'placeholder' => 'Eye Color',
				'order' => 4),
			array(
				'form_key' => 'character',
				'section_id' => 2,
				'type' => 'textarea',
				'html_name' => 'physical_desc',
				'html_id' => 'physical_desc',
				'html_rows' => 3,
				'html_class' => 'span8',
				'label' => 'Physical Description',
				'placeholder' => 'Enter your physical description here',
				'order' => 5),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'text',
				'html_name' => 'spouse',
				'html_id' => 'spouse',
				'html_rows' => 0,
				'label' => 'Spouse',
				'placeholder' => 'Spouse',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'textarea',
				'html_name' => 'children',
				'html_id' => 'children',
				'html_rows' => 3,
				'label' => 'Children',
				'placeholder' => 'Enter your character\'s children here',
				'order' => 2),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'text',
				'html_name' => 'father',
				'html_id' => 'father',
				'html_rows' => 0,
				'label' => 'Father',
				'placeholder' => 'Father',
				'order' => 3),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'text',
				'html_name' => 'mother',
				'html_id' => 'mother',
				'html_rows' => 0,
				'label' => 'Mother',
				'placeholder' => 'Mother',
				'order' => 4),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'textarea',
				'html_name' => 'siblings',
				'html_id' => 'siblings',
				'html_rows' => 3,
				'label' => 'Siblings',
				'placeholder' => 'Enter your character\'s siblings here',
				'order' => 5),
			array(
				'form_key' => 'character',
				'section_id' => 3,
				'type' => 'textarea',
				'html_name' => 'other_family',
				'html_id' => 'other_family',
				'html_rows' => 3,
				'label' => 'Other Family',
				'placeholder' => 'Enter your character\'s other family here',
				'order' => 6),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'personality',
				'html_id' => 'personality',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'General Overview',
				'placeholder' => 'Enter your character\'s general personality overview here',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'strengths',
				'html_id' => 'strengths',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'Strengths &amp; Weaknesses',
				'placeholder' => 'Enter your character\'s strengths and weaknesses here',
				'order' => 2),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'ambitions',
				'html_id' => 'ambitions',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'Ambitions',
				'placeholder' => 'Enter your character\'s ambitions here',
				'order' => 3),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'hobbies',
				'html_id' => 'hobbies',
				'html_rows' => 5,
				'html_class' => 'span8',
				'label' => 'Hobbies &amp; Interests',
				'placeholder' => 'Enter your character\'s hobbies and interests here',
				'order' => 4),
			array(
				'form_key' => 'character',
				'section_id' => 4,
				'type' => 'textarea',
				'html_name' => 'languages',
				'html_id' => 'languages',
				'html_rows' => 2,
				'html_class' => 'span8',
				'label' => 'Languages',
				'placeholder' => 'Enter your character\'s known languages here',
				'order' => 5),
			array(
				'form_key' => 'character',
				'section_id' => 5,
				'type' => 'textarea',
				'html_name' => 'history',
				'html_id' => 'history',
				'html_rows' => 15,
				'html_class' => 'span8',
				'label' => 'History',
				'placeholder' => 'Enter your character\'s personal history here',
				'order' => 1),
			array(
				'form_key' => 'character',
				'section_id' => 5,
				'type' => 'textarea',
				'html_name' => 'service_record',
				'html_id' => 'service_record',
				'html_rows' => 15,
				'html_class' => 'span8',
				'label' => 'Service Record',
				'placeholder' => 'Enter your character\'s service record here',
				'order' => 2),
			array(
				'form_key' => 'user',
				'type' => 'text',
				'html_name' => 'location',
				'html_id' => 'location',
				'html_rows' => 0,
				'label' => 'Location',
				'placeholder' => 'Enter your location here',
				'order' => 0),
			array(
				'form_key' => 'user',
				'type' => 'textarea',
				'html_name' => 'interests',
				'html_id' => 'interests',
				'html_rows' => 5,
				'label' => 'Interests',
				'placeholder' => 'Enter your interests here',
				'order' => 1),
			array(
				'form_key' => 'user',
				'type' => 'textarea',
				'html_name' => 'bio',
				'html_id' => 'bio',
				'html_rows' => 5,
				'label' => 'Bio',
				'placeholder' => 'Enter your bio information here',
				'order' => 2),
			array(
				'form_key' => 'app',
				'type' => 'textarea',
				'html_name' => 'experience',
				'html_id' => 'experience',
				'html_rows' => 5,
				'html_class' => 'span5',
				'label' => 'Simming Experience',
				'order' => 0),
			array(
				'form_key' => 'app',
				'type' => 'select',
				'html_name' => 'hear_about',
				'html_id' => 'hear_about',
				'html_class' => 'span5',
				'label' => 'Where Did You Hear About Us?',
				'order' => 1),
		);

		foreach ($data as $value)
		{
			\DB::insert('form_fields')->set($value)->execute();
		}

		\DBUtil::create_table('form_sections', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
			'tab_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
			'updated_at' => array('type' => 'DATETIME', 'null' => true),
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
				'tab_id' => 2,
				'name' => 'Family',
				'order' => 2),
			array(
				'form_key' => 'character',
				'tab_id' => 3,
				'name' => 'Personality &amp; Traits',
				'order' => 0),
			array(
				'form_key' => 'character',
				'tab_id' => 4,
				'name' => '',
				'order' => 0),
		);

		foreach ($data as $value)
		{
			\DB::insert('form_sections')->set($value)->execute();
		}

		\DBUtil::create_table('form_tabs', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'link_id' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
			'updated_at' => array('type' => 'DATETIME', 'null' => true),
		), array('id'));

		$data = array(
			array(
				'form_key' => 'character',
				'name' => 'Basic Info',
				'link_id' => 'one',
				'order' => 1),
			array(
				'form_key' => 'character',
				'name' => 'Personal Info',
				'link_id' => 'two',
				'order' => 2),
			array(
				'form_key' => 'character',
				'name' => 'Personality',
				'link_id' => 'three',
				'order' => 3),
			array(
				'form_key' => 'character',
				'name' => 'History',
				'link_id' => 'four',
				'order' => 4),
		);

		foreach ($data as $value)
		{
			\DB::insert('form_tabs')->set($value)->execute();
		}

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
			array(
				'field_id' => 26,
				'value' => 'Friend',
				'content' => 'A Friend',
				'order' => 1),
			array(
				'field_id' => 26,
				'value' => 'Member',
				'content' => 'A Member of the Game',
				'order' => 2),
			array(
				'field_id' => 26,
				'value' => 'Organization',
				'content' => 'An Organization',
				'order' => 3),
			array(
				'field_id' => 26,
				'value' => 'Advertisement',
				'content' => 'An Advertisement',
				'order' => 4),
			array(
				'field_id' => 26,
				'value' => 'Search',
				'content' => 'An Internet Search',
				'order' => 5),
		);

		foreach ($data as $value)
		{
			\DB::insert('form_values')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('forms');
		\DBUtil::drop_table('form_data');
		\DBUtil::drop_table('form_fields');
		\DBUtil::drop_table('form_sections');
		\DBUtil::drop_table('form_tabs');
		\DBUtil::drop_table('form_values');
	}
}