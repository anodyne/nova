<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 0.9.6 => 0.9.7
|---------------------------------------------------------------
*/

/*
|---------------------------------------------------------------
| VERSION INFO FOR THE DATABASE
|---------------------------------------------------------------
*/

$system_versions = array(
	'version'			=> '0.9.7',
	'version_major'		=> 0,
	'version_minor'		=> 9,
	'version_update'	=> 7,
	'version_date'		=> 1268536500,
	'version_launch'	=> 'Nova 0.9.7 is an update to the beta release of the next generation RPG management software from Anodyne Productions.',
	'version_changes'	=> "* added the 0.9.7 update file
* added the shiloh skin
* removed the get\_author\_user\_ids() method from the posts model
* removed the beta skin
* removed the titan skin
* updated the install data
    * version info
    * system component info
* updated the constants config file with the new version info
* updated the jquery ui to version 1.8rc3
* updated the look and feel of the installation center
* updated the pulsar skin
    * [admin] added admin section
    * [main] added the jquery ui theme
    * [main] added panel control images
    * [main] updated the stylesheets
    * [main] removed unused images
    * [login] updated the stylesheets
    * [wiki] added wiki section
    * added the jquery block ui plugin
* updated the titan skin
    * [admin] added the genre logos
    * [admin] updated the jquery ui theme
    * [admin] updated the stylesheets
    * [admin] updated the template file
    * [main] updated the jquery ui theme
    * [main] updated the stylesheets
    * [main] updated the genre logos
    * [main] updated the template file
    * [wiki] added the genre logos
    * [wiki] updated the stylesheets
    * [wiki] updated the template file
* updated the specifications listing to clean up some small issues
* updated the pulsar skin
* updated the look and feel of the update center
* updated the look and feel of the upgrade center
* updated the controllers to remove calls to load the string helper (it's autoloaded now)
* updated the autoload config to pull in the string helper automatically
* updated jquery qtip plugin to version 1.0-r29
* updated the tooltip location to the upper right of the target
* updated the default style for the uniform stylesheet
* updated the install language file
* updated the install options screen
* updated the ftp config file to set debug to false
* updated the install controller to remove some debug code
* fixed bug where error was thrown when submitting a wiki comment (#77)
* fixed bug where error was thrown when submitting a log comment (#78)
* fixed bug where error was thrown when submitting a post comment (#79) - would also affect sending post save and post delete emails as well
* fixed bug where the submit button on the contact form didn't work (#80)
* fixed bug where the character bio editing didn't work with character selection (#73)
* fixed bug where IE would cache the ajax views and won't let go (#81)
* fixed bug where the lazy plugin was throwing errors with the qtip plugin
* fixed error with the bl5 install file
* fixed error with the baj install file"
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 0,
	'sys_version_minor'		=> 9,
	'sys_version_update'	=> 7
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

if (isset($add_tables))
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

if (isset($drop_tables))
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

if (isset($rename_tables))
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

if (isset($add_column))
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

if (isset($modify_column))
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

if (isset($drop_column))
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
$this->db->update('system_components', array('comp_version' => '1.8rc3'));

/* jquery qtip version info */
$this->db->where('comp_name', 'qTip');
$this->db->update('system_components', array('comp_version' => '1.0-r29'));

/* add system version info */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/* End of file update_096.php */
/* Location: ./application/assets/update/update_096.php */