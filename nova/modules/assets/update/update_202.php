<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Update Nova from 2.0.2 to 2.0.3
 */
$system_versions	= null;
$system_info		= null;
$add_tables			= null;
$drop_tables		= null;
$rename_tables		= null;
$add_column			= null;
$modify_column		= null;
$drop_column		= null;

/**
 * Version info for the database
 */
$system_versions = array(
	'version'			=> '2.0.3',
	'version_major'		=> 2,
	'version_minor'		=> 0,
	'version_update'	=> 3,
	'version_date'		=> 1330646400,
	'version_launch'	=> "Nova 2.0.3 addresses an issue with benchmarking psuedo-variables (elapsed time and memory consumption) that are caused by the Template engine not using the Output class. In addition, the jQuery UI has been updated to version 1.8.18.",
	'version_changes'	=> "* Updated jQuery UI to version 1.8.18.
* Benchmarking psuedo-variables are not handled properly because of the fact the Template library doesn't use the Output library for sending content to the browser.
* When saving posts with the Post Participants feature turned off, Nova would throw errors about a database field not accepting NULL values."
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 2,
	'sys_version_minor'		=> 0,
	'sys_version_update'	=> 3
);

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
|		'auto_increment' => TRUE),
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

if ($add_tables !== null)
{
	foreach ($add_tables as $key => $value)
	{
		$this->dbforge->add_field($$value['fields']);
		$this->dbforge->add_key($value['id'], true);
		$this->dbforge->create_table($key, true);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO DROP
|
| $drop_tables = array('table_name');
|---------------------------------------------------------------
*/

if ($drop_tables !== null)
{
	foreach ($drop_tables as $value)
	{
		$this->dbforge->drop_table($value);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO RENAME
|
| $rename_tables = array('old_table_name' => 'new_table_name');
|---------------------------------------------------------------
*/

if ($rename_tables !== null)
{
	foreach ($rename_tables as $key => $value)
	{
		$this->dbforge->rename_table($key, $value);
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

if ($add_column !== null)
{
	foreach ($add_column as $key => $value)
	{
		$this->dbforge->add_column($key, $value);
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

if ($modify_column !== null)
{
	foreach ($modify_column as $key => $value)
	{
		$this->dbforge->modify_column($key, $value);
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

if ($drop_column !== null)
{
	foreach ($drop_column as $key => $value)
	{
		$this->dbforge->drop_column($key, $value[0]);
	}
}

// update the jquery ui version info
$this->db->where('comp_name', 'jQuery UI');
$this->db->update('system_components', array('comp_version' => '1.8.18'));
