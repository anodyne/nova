<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Update Nova from 1.2.x to 2.0
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
	'version'			=> '2.0.0',
	'version_major'		=> 2,
	'version_minor'		=> 0,
	'version_update'	=> 0,
	'version_date'		=> 1292889600,
	'version_launch'	=> "You've spoken and we've listened. The feedback we constantly get about Nova is that it's great, but it's difficult to update. Nova 2 is all about fixing that very issue. With a brand new file structure, Nova 2 has never been easier to update (simply delete one folder and replace it with one from the zip archive). In addition, Nova 2 adds new functionality to the system to help admins manage their RPG. [...] More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
	'version_changes'	=> ""
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 2,
	'sys_version_minor'		=> 0,
	'sys_version_update'	=> 0
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

$add_column = array(
	'wiki_pages' => array(
		'page_type' => array(
			'type' => 'ENUM',
			'constraint' => "'standard','system'",
			'default' => 'standard'),
		'page_key' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'default' => ''),
	),
	'posts' => array(
		'post_participants' => array(
			'type' => 'TEXT'),
	)
);

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

/**
 * Data to insert/update/delete
 */

// update the lazy version info
$this->db->where('comp_name', 'Lazy');
$this->db->update('system_components', array('comp_version' => '1.5'));

// update the jquery version info
$this->db->where('comp_name', 'jQuery');
$this->db->update('system_components', array('comp_version' => '1.5.1'));

// update the jquery ui version info
$this->db->where('comp_name', 'jQuery UI');
$this->db->update('system_components', array('comp_version' => '1.8.10'));

// add the elastic plugin to the list of components
$additem = array(
	'comp_name' => 'Elastic',
	'comp_version' => '1.6.4',
	'comp_desc' => "jQuery Elastic is a plugin that makes your textareas grow and shrink to fit its content and was inspired by the auto-growing textareas on Facebook.",
	'comp_url' => 'http://www.unwrongest.com/projects/elastic/'
);
$this->db->insert('system_components', $additem);

// add the use_post_participants setting
$additem = array(
	'setting_key' => 'use_post_participants',
	'setting_value' => 'y',
	'setting_user_created' => 'n'
);
$this->db->insert('settings', $additem);

// update the level 3 wiki page item
$this->db->where('page_url', 'wiki/page');
$this->db->where('page_level', 3);
$this->db->update('access_pages', array('page_desc' => "Can create, delete and edit all wiki pages (including system pages), including viewing history and reverting to previous drafts. Level 3 permissions can bypass all access restrictions on a wiki page."));
