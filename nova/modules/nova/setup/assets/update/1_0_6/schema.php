<?php
/**
 * File that handles all schema changes to the database.
 *
 * 1.0.6 => 1.1
 *
 * @package		Update
 * @author		Anodyne Productions
 */

$add_tables			= null;
$drop_tables		= null;
$rename_tables		= null;
$add_column			= null;
$modify_column		= null;
$drop_column		= null;

/*
|---------------------------------------------------------------
| TABLES TO ADD
|
| $add_tables = array(
|	'table_name' => array(
|		'id' => 'table_id',
|		'fields' => 'fields_table_name')
| );
|
| $fields_table_name = array(
|	'table_id' => array(
|		'type' => 'INT',
|		'constraint' => 6,
|		'auto_increment' => true),
|	'table_field_1' => array(
|		'type' => 'VARCHAR',
|		'constraint' => 255,
|		'default' => ''),
|	'table_field_2' => array(
|		'type' => 'INT',
|		'constraint' => 4,
|		'default' => '99')
| );
|---------------------------------------------------------------
*/

$add_tables = array(
	'specs' => array(
		'id' => 'specs_id',
		'fields' => 'fields_specs')
);

$fields_specs = array(
	'specs_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => true),
	'specs_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'specs_order' => array(
		'type' => 'INT',
		'constraint' => 4),
	'specs_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'specs_images' => array(
		'type' => 'TEXT'),
	'specs_summary' => array(
		'type' => 'TEXT')
);

if ( ! is_null($add_tables))
{
	foreach ($add_tables as $key => $value)
	{
		DBForge::add_field($$value['fields']);
		DBForge::add_key($value['id'], true);
		DBForge::create_table($key, true);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO DROP
|
| $drop_tables = array('table_name');
|---------------------------------------------------------------
*/

if ( ! is_null($drop_tables))
{
	foreach ($drop_tables as $value)
	{
		DBForge::drop_table($value);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO RENAME
|
| $rename_tables = array('old_table_name' => 'new_table_name');
|---------------------------------------------------------------
*/

if ( ! is_null($rename_tables))
{
	foreach ($rename_tables as $key => $value)
	{
		DBForge::rename_table($key, $value);
	}
}

/*
|---------------------------------------------------------------
| COLUMNS TO ADD
|
| $add_column = array(
|	'table_name' => array(
|		'field_name_1' => array('type' => 'TEXT'),
|		'field_name_2' => array(
|			'type' => 'VARCHAR',
|			'constraint' => 100)
|	)
| );
|---------------------------------------------------------------
*/

$add_column = array(
	'specs_data' => array(
		'data_item' => array(
			'type' => 'INT',
			'constraint' => 5)
	),
	'tour' => array(
		'tour_spec_item' => array(
			'type' => 'INT',
			'constraint' => 5)
	),
);

if ( ! is_null($add_column))
{
	foreach ($add_column as $key => $value)
	{
		DBForge::add_column($key, $value);
	}
}

/*
|---------------------------------------------------------------
| COLUMNS TO MODIFY
|
| $modify_column = array(
|	'table_name' => array(
|		'old_field_name' => array(
|			'name' => 'new_field_name',
|			'type' => 'TEXT')
|	)
| );
|---------------------------------------------------------------
*/

if ( ! is_null($modify_column))
{
	foreach ($modify_column as $key => $value)
	{
		DBForge::modify_column($key, $value);
	}
}

/*
|---------------------------------------------------------------
| COLUMNS TO DROP
|
| $drop_column = array(
|	'table_name' => array('field_name')
| );
|---------------------------------------------------------------
*/

if ( ! is_null($drop_column))
{
	foreach ($drop_column as $key => $value)
	{
		DBForge::drop_column($key, $value[0]);
	}
}