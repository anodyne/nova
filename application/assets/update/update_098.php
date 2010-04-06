<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 0.9.8 => 0.9.9
|---------------------------------------------------------------
*/

/*
|---------------------------------------------------------------
| VERSION INFO FOR THE DATABASE
|---------------------------------------------------------------
*/

$system_versions = array(
	'version'			=> '0.9.9',
	'version_major'		=> 0,
	'version_minor'		=> 9,
	'version_update'	=> 9,
	'version_date'		=> 1270521000,
	'version_launch'	=> 'Nova 0.9.9 is an update to the beta release of the next generation RPG management software from Anodyne Productions.',
	'version_changes'	=> "* added the 0.9.9 update file
* updated the versions array file
* updated the install data
    * version info
    * component info
    * permanent credits message
    * system email on by default
    * menu items
* updated the shiloh skin
    * [main] updated the stylesheets
    * [wiki] added the wiki section
* updated the pulsar skin
    * [admin] added a new small loading circle graphic
    * [admin] added styles for upload close and list-grid
    * [main] updated the structure stylesheet
* updated the nova license
* updated the language files
* updated the sms config file with directions about what each item is for
* updated to jquery ui version 1.8
* updated the constants config file with a constant for defining whether something is an ajax request
* updated several ajax methods that were vulnerable to outside hijacking
* updated several ajax methods to get the final order integer better
* updated the all news page to handle the lack of news better
* updated the contact page to not show the form if email is disabled
* updated the wiki manage categories page to show a message if there aren't any categories
* updated the wiki view page to only show the revert option if A) there's more than 1 draft and B) the draft row isn't the current page draft
* updated the wiki revert draft functionality to put a generic update message in place
* updated the write mission post page to check for missions and allow admins to create to create them right there
* updated the write mission post page to be able to set an upcoming mission to current on the fly if there aren't no current missions
* updated site settings to change the way the date format setting works
* updated the check for an external bio image to be a little safer
* updated the characters listing to make the tables display better
* updated the npcs listing to make the tables display better
* updated the upload controller to now allow _, - or = in the name of uploaded images
* updated the edit character bio page to handle images in a whole new way and with lots of fun ajax stuff
* updated upload management page to have a link to upload images
* updated mission management with new image upload management code
* fixed bug in the upgrade controller where an error would be thrown in certain circumstances
* fixed bug with adding bio dropdown values
* fixed bug where adding a deck and immediately trying to re-order it wouldn't work (#93)
* fixed error thrown when editing a specs field because of a misnamed array index
* fixed error thrown when editing a tour field because of a misnamed array index
* fixed error thrown when editing a docking field because of a misnamed array index
* fixed bug where adding a docking field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where adding a specs form field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where adding a tour form field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where adding a bio form field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where the description for wiki categories couldn't be edited (#92)
* fixed bug where external images wouldn't display in character bio pages (#91)
* fixed bug where gallery wouldn't work unless there were 3 images
* fixed bug during install caused by not loading a library
* fixed bug during update caused by not loading a library
* fixed bug where reverting a wiki page wiped out the categories for the draft
* fixed bug where adding an int field would error out because it tried to put a default value in (#94)
* fixed bug where in certain situations an error could be thrown pulling online users
* fixed bug where a character's user id was wiped out during the approval process
* fixed IE8 display issue with the control panel
* fixed bug where error was thrown when rejecting an application (#98)
* fixed bug where the post model wasn't taking one of the post author string potentials into account (#96)
* fixed bug where the email language file wasn't extensible (#97)
* fixed bug where creating an award wouldn't have a display set by default"
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 0,
	'sys_version_minor'		=> 9,
	'sys_version_update'	=> 9
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
$this->db->update('system_components', array('comp_version' => '1.8'));

$array = array(
	'upload' => array(
		'menu_name' => 'Upload Images',
		'menu_group' => 3,
		'menu_order' => 0,
		'menu_link' => 'upload/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'n'),
	'manage' => array(
		'menu_name' => 'Manage Uploads',
		'menu_group' => 3,
		'menu_order' => 1,
		'menu_link' => 'upload/manage',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'upload/manage'),
);

/* upload management link */
$this->db->where('menu_link', 'upload/manage');
$this->db->update('menu_items', $array['manage']);

/* add the upload link */
$this->db->insert('menu_items', $array['upload']);

/* add system version info */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/* End of file update_098.php */
/* Location: ./application/assets/update/update_098.php */