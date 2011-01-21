<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 1.0.5 => 1.0.6
|---------------------------------------------------------------
*/

$system_versions	= NULL;
$system_info		= NULL;
$add_tables			= NULL;
$drop_tables		= NULL;
$rename_tables		= NULL;
$add_column			= NULL;
$modify_column		= NULL;
$drop_column		= NULL;

/*
|---------------------------------------------------------------
| VERSION INFO FOR THE DATABASE
|---------------------------------------------------------------
*/

$system_versions = array(
	'version'			=> '1.0.6',
	'version_major'		=> 1,
	'version_minor'		=> 0,
	'version_update'	=> 6,
	'version_date'		=> 1279148400,
	'version_launch'	=> "Nova 1.0.6 is the sixth and final maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, a critical CodeIgniter security bug, several bugs with character management, a bug with user management and setting email preferences, updates to the jQuery UI library and other plugins and more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users. Additionally, active testing is underway for Nova 1.1 that will add several new features to the system and will be available later this summer.",
	'version_changes'	=> "* added the 1.0.6 update file
* updated the character bio management page to show a loader until everything has finished loading to help with load time
* updated jquery ui to version 1.8.2
* updated the auth library to remove some debug code since the autologin bug seems to have been solved
* updated the index page to turn down the error reporting (fatal errors and database errors will still be shown)
* updated the select menu on the write PM page to separate active and inactive characters
* updated colorbox to version 1.3.8
* updated the characters model to include a method for inserting promotion records
* updated the language file with a new item (_labels\_from_)
* updated the users model with a new method for removing user preference values
* updated CI's core upload class to fixing a security hole
* fixed error thrown when posting a comment on a mission post
* fixed error thrown when attempting to delete a character
* fixed error thrown during step 2 of the update process for some users
* fixed error thrown when there's only one mission image set on the mission detail page
* fixed error thrown when there's only one tour image set on the tour detail page
* fixed error thrown when there's only one character image set on the character bio page
* fixed bug where acceptance and rejection messages were sent without any changes an admin made
* fixed bug where changing a character's state to and from active wouldn't set the open slots of their position(s)
* fixed bug where the position dropdowns when creating a character showed all positions instead of open positions
* fixed bug where rank history information wasn't being populated correctly
* fixed bug where turning off update notification still attempted to run the check (before running in to another check)
* fixed bug where a user's email preferences remained active even after the user was set to inactive
* fixed bug where a user's email preferences weren't deleted when the user was deleted"
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 1,
	'sys_version_minor'		=> 0,
	'sys_version_update'	=> 6
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

if (!is_null($add_tables))
{
	foreach ($add_table as $key => $value)
	{
		$this->dbforge->add_field($$value['fields']);
		$this->dbforge->add_key($value['id'], TRUE);
		$this->dbforge->create_table($key, TRUE);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO DROP
|
| $drop_tables = array('table_name');
|---------------------------------------------------------------
*/

if (!is_null($drop_tables))
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

if (!is_null($rename_tables))
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

if (!is_null($add_column))
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

if (!is_null($modify_column))
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

if (!is_null($drop_column))
{
	foreach ($drop_column as $key => $value)
	{
		$this->dbforge->drop_column($key, $value[0]);
	}
}

/*
|---------------------------------------------------------------
| DATA TO INSERT/UPDATE/DELETE
|---------------------------------------------------------------
*/

/* jquery ui version info */
$this->db->where('comp_name', 'jQuery UI');
$this->db->update('system_components', array('comp_version' => '1.8.2'));

/* jquery ui version info */
$this->db->where('comp_name', 'jQuery ColorBox');
$this->db->update('system_components', array('comp_version' => '1.3.8'));

/* add system version info */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/* End of file update_105.php */
/* Location: ./application/assets/update/update_105.php */