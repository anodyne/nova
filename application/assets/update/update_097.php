<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 0.9.7 => 0.9.8
|---------------------------------------------------------------
*/

/*
|---------------------------------------------------------------
| VERSION INFO FOR THE DATABASE
|---------------------------------------------------------------
*/

$system_versions = array(
	'version'			=> '0.9.8',
	'version_major'		=> 0,
	'version_minor'		=> 9,
	'version_update'	=> 8,
	'version_date'		=> 1269109800,
	'version_launch'	=> 'Nova 0.9.8 is an update to the beta release of the next generation RPG management software from Anodyne Productions.',
	'version_changes'	=> "* added the 0.9.8 update file
* added the archive_characters view file
* added the archive_departments view file
* added the archive_positions view file
* added the redeye skin
* added the manage/missiongroups view file
* added the manage/missiongroups js view file
* added the sim/missions/group view file
* added the sim/missions/group/X view file
* updated the dashboard to use the short rank name instead of the full rank name
* updated the pulsar skin
    * [admin] updated the size of the dashboard panel
    * [admin] updated the stylesheets
    * [main] updated the size of the dashboard panel
    * [wiki] updated the size of the dashboard panel
* updated the upgrade process to make the processing messages more descriptive
* updated the install data
    * version info
    * menu items
* updated the 0.9.7 update file
* updated the version info for 0.9.8
* updated the language files
* updated the characters model to take a zero into account instead of just NULL
* updated the upgrade process to pull over last post information as well
* updated the archive model with methods for pulling characters, positions and departments
* updated the archive controller to handle displaying characters from the SMS data
* updated the archive controller to handle displaying departments from the SMS data
* updated the archive controller to handle displaying positions from the SMS data
* updated the posts model to count posts based on users not on characters (prevents padding stats)
* updated character linking to use quick search on the NPCs tab
* updated write/missionpost to allow a user to select multiple characters of theirs for a post (#59)
* updated write/missionpost to simplify the UI a little bit
* updated the install controller to log any XML-RPC errors
* updated the update controller to log any XML-RPC errors
* updated the upgrade controller to log any XML-RPC errors
* updated the install controller to take the xmlrpc extension not being loaded into account
* updated the upgrade controller to take the xmlrpc extension not being loaded into account
* updated the update controller to take the xmlrpc extension not being loaded into account
* updated the database schema
    * [add] mission\_group field to the missions table
    * [add] mission\_groups table
* updated the missions model with methods for mission groups
* updated the sim controller to handle displaying mission groups
* updated some view files to change the URLs for mission pages
* updated the missions management page to be able to assign a mission group
* updated the manage controller to handle management of mission groups
* updated the copyright year of the nova license
* fixed errors in the upgrade process
* fixed errors after upgrading on the characters management page
* fixed errors after upgrading on the npc management page
* fixed bug where the all recent entries in the writing control panel showed all entries instead of just activated entries
* fixed bug where the character link page wouldn't show npcs
* fixed bug where the sms archives link didn't point to anywhere
* fixed an error in the archive controller
* fixed bug where user IDs were duplicated on multi-author posts allowing a user to pad their stats
* fixed potential bug where nova could look for array indices that wouldn't exist
* fixed bug in counting character's posts where low-numbered ID characters could have highly exaggerated post counts
* fixed bug in coutning users' posts where low-numbered ID users could have highly exaggerated post counts
* fixed bug in the upgrade process where last post wasn't put into the characters table too
* fixed bug in the upgrade process where news items weren't updated with the proper author user ID
* fixed bug in the upgrade process where personal logs weren't updated with the proper author user ID
* fixed bug where the checkbox to delete all positions in a department being deleted was disabled (#86)
* fixed bug where adding and editing mission dates didn't work (#87)"
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 0,
	'sys_version_minor'		=> 9,
	'sys_version_update'	=> 8
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

$add_tables = array(
	'mission_groups' => array(
		'id' => 'misgroup_id',
		'fields' => 'fields_mission_groups')
);

$fields_mission_groups = array(
	'misgroup_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'misgroup_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'misgroup_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'misgroup_desc' => array(
		'type' => 'TEXT')
);

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

$add_column = array(
	'missions' => array(
		'mission_group' => array(
			'type' => 'INT',
			'constraint' => 5),
		),
);

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

/* add the mission group menu item */
$array = array(
	'menu_name' => 'Mission Groups',
	'menu_group' => 0,
	'menu_order' => 2,
	'menu_link' => 'sim/missions/group',
	'menu_sim_type' => 1,
	'menu_type' => 'sub',
	'menu_cat' => 'sim'
);
$this->db->insert('menu_items', $array);

/* add the mission group management menu item */
$array = array(
	'menu_name' => 'Mission Groups',
	'menu_group' => 1,
	'menu_order' => 1,
	'menu_link' => 'manage/missiongroups',
	'menu_sim_type' => 1,
	'menu_type' => 'adminsub',
	'menu_cat' => 'manage',
	'menu_use_access' => 'y',
	'menu_access' => 'manage/missions'
);
$this->db->insert('menu_items', $array);

/* add system version info */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/* End of file update_097.php */
/* Location: ./application/assets/update/update_097.php */