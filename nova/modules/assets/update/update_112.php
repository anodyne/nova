<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 1.1.2 => 1.2
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
	'version'			=> '1.2.0',
	'version_major'		=> 1,
	'version_minor'		=> 2,
	'version_update'	=> 0,
	'version_date'		=> 1292889600,
	'version_launch'	=> "Nova 1.2 is the second major update to Nova 1 and add new functionality to the system to help admin run their RPG even better. In addition to patching nearly two dozen bugs from Nova 1.0 and 1.1, version 1.2 adds ban controls for dealing with pesky users, deck listing improvements, contact page improvements and multiple manifests. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
	'version_changes'	=> "* added the 1.2 update file
* added the ability to ban users from applying or even getting to the site
* added a page that level 2 bans are redirected to
* added the validation error image to the assets directory
* added the assignment image to the admin \_base directory
* added prettyPhoto jquery plugin to replace fancybox
* removed fancybox jquery plugin
* updated the applications report to show email address and IP address of the user who applied
* updated the email sent to the game master from the join form to show the IP address of the applicant
* updated the contact form to be simpler and use proper form validation
* updated the departments model with methods for handling multiple manifests
* updated codeigniter to version 1.7.3
* updated jquery to version 1.4.4
* updated jquery ui to version 1.8.7
* updated markItUp! plugin to version 1.1.9
* updated the autoload config item to not try and autoload the input library since CI loads it by default
* updated the user model with a method to pull user information based on characters in the database
* updated department management with a better interface for working with departments
* updated position management to split departments out by manifest
* updated the write controller to check for whether a user has a character associated with their account and if they don't redirct them to an error page
* updated some of the model methods to correct for situations where the user or character ID might not be present and throw errors
* updated the basic and dev install data to fix a typo
* updated the language files
    * [base\_lang] added _labels\_ban_
    * [base\_lang] added _labels\_bans_
    * [base\_lang] added _labels\_ipaddr_
    * [base\_lang] added _labels\_header_
    * [base\_lang] added _labels\_listings_
    * [base\_lang] added _labels\_manifests_
    * [base\_lang] added _labels\_refresh_
    * [base\_lang] added _labels\_unassigned_
    * [base\_lang] added _misc\_level1\_only_
    * [email\_lang] updated _email\_content\_private\_message_
    * [error\_lang] added _error\_wcp\_1_
    * [text\_lang] added _text\_bans_
    * [text\_lang] added _text\_ban\_join_
    * [text\_lang] added _text\_manifest\_delete\_departments_
    * [text\_lang] added _text\_manifest_
    * [text\_lang] added _text\_manifest\_assign_
    * [text\_lang] added _text\_duplicate\_dept_
    * [text\_lang] updated _text\_manage\_depts_
* fixed bug where users without an active character would be shown in the activity warning panel on the ACP
* fixed bug where the sample post in the join application email was just a massive wall of text
* fixed bug where the specifications weren't properly upgraded during the sms upgrade process
* fixed bug with a missing closing tag on the create characters page
* fixed bug where timezone menu in site/settings pulled the wrong value to populate the field with
* fixed bug where the join page was pulling an image from the wrong location
* fixed spacing bug in access role management
* fixed spacing bug in news item management
* fixed spacing bug in log management
* fixed spacing bug in post management
* fixed spacing bug in department management
* fixed some errors being thrown throughout the system
* fixed bug where the flash message view couldn't be overridden with seamless substitution
* fixed bug where post emails were sent out with the user's primary character name attached even if the primary character wasn't associated with the post
* fixed bug where the private message email didn't contain the content of the private message
* fixed some errors thrown through the system when a user without a character tried moving through the system
* fixed bug where personal logs don't have the right date when they're saved first
* fixed bug where pending users would appear in the dropdown of potential recipients for a PM
* fixed bug where changing a dynamic form field from text/textarea to dropdown wouldn't trigger the dropdown values section to open, rendering the field pretty much useless"
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 1,
	'sys_version_minor'		=> 2,
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

$add_tables = array(
	'bans' => array(
		'id' => 'ban_id',
		'fields' => 'fields_bans'),
	'manifests' => array(
		'id' => 'manifest_id',
		'fields' => 'fields_manifests')
);

$fields_bans = array(
	'ban_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'ban_level' => array(
		'type' => 'INT',
		'constraint' => 1),
	'ban_ip' => array(
		'type' => 'VARCHAR',
		'constraint' => 16,
		'default' => ''),
	'ban_email' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'ban_reason' => array(
		'type' => 'TEXT'),
	'ban_date' => array(
		'type' => 'BIGINT',
		'constraint'=> 20),
);

$fields_manifests = array(
	'manifest_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'manifest_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'manifest_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'manifest_desc' => array(
		'type' => 'TEXT'),
	'manifest_header_content' => array(
		'type' => 'TEXT'),
	'manifest_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'manifest_default' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
);

if (!is_null($add_tables))
{
	foreach ($add_tables as $key => $value)
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

$add_column = array(
	'applications' => array(
		'app_ip' => array(
			'type' => 'VARCHAR',
			'constraint' => 16,
			'default' => '')),
	'departments_'.GENRE => array(
		'dept_manifest' => array(
			'type' => 'INT',
			'constraint' => 5,
			'default' => 0)),
	'tour_decks' => array(
		'deck_item' => array(
			'type' => 'INT',
			'constraint' => 5,
			'default' => 0)),
);

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

/**
 * update the jquery version info
 */
$this->db->where('comp_name', 'CodeIgniter');
$this->db->update('system_components', array('comp_version' => '1.7.3'));

/**
 * update the jquery version info
 */
$this->db->where('comp_name', 'jQuery');
$this->db->update('system_components', array('comp_version' => '1.4.4'));

/**
 * update the jquery ui version info
 */
$this->db->where('comp_name', 'jQuery UI');
$this->db->update('system_components', array('comp_version' => '1.8.7'));

/**
 * update the markItUp! version info
 */
$this->db->where('comp_name', 'markItUp!');
$this->db->update('system_components', array('comp_version' => '1.1.9'));

/**
 * remove the fancybox plugin from the list of components
 */
$this->db->where('comp_name', 'FancyBox');
$this->db->delete('system_components');

/**
 * add the prettyPhoto plugin to the list of components
 */
$additem = array(
	'comp_name' => 'prettyPhoto',
	'comp_version' => '3.0.1',
	'comp_desc' => "prettyPhoto is a jQuery lightbox clone. Not only does it support images, it also support for videos, flash, YouTube, iframes. It's a full blown media lightbox.",
	'comp_url' => 'http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/'
);
$this->db->insert('system_components', $additem);

/**
 * add the new access page information
 */
$page = array(
	'page_name' => 'Ban Controls',
	'page_url' => 'site/bans',
	'page_group' => 3,
	'page_desc' => "Can create and remove site bans",
);
$this->db->insert('access_pages', $page);
$ban_pageid = $this->db->insert_id();

$page = array(
	'page_name' => 'Site Manifests',
	'page_url' => 'site/manifests',
	'page_group' => 3,
	'page_desc' => "Can create, delete and edit site manifests",
);
$this->db->insert('access_pages', $page);
$manifests_pageid = $this->db->insert_id();

/**
 * add the new access page to the system administrator role
 */
$query = $this->db->get_where('access_roles', array('role_name' => 'System Administrator'));
$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
if ($row !== FALSE)
{
	$role = array('role_access' => $row->role_access.','.$ban_pageid.','.$manifests_pageid);
	$this->db->where('role_id', $row->role_id);
	$this->db->update('access_roles', $role);
}

/**
 * create the new menu item
 */
$menu = array(
	'menu_name' => 'Ban Controls',
	'menu_group' => 0,
	'menu_order' => 4,
	'menu_link' => 'site/bans',
	'menu_link_type' => 'onsite',
	'menu_need_login' => 'none',
	'menu_use_access' => 'y',
	'menu_access' => 'site/bans',
	'menu_type' => 'adminsub',
	'menu_cat' => 'site',
	'menu_display' => 'y',
	'menu_sim_type' => 1,
);
$this->db->insert('menu_items', $menu);

$menu = array(
	'menu_name' => 'Site Manifests',
	'menu_group' => 0,
	'menu_order' => 5,
	'menu_link' => 'site/manifests',
	'menu_link_type' => 'onsite',
	'menu_need_login' => 'none',
	'menu_use_access' => 'y',
	'menu_access' => 'site/manifests',
	'menu_type' => 'adminsub',
	'menu_cat' => 'site',
	'menu_display' => 'y',
	'menu_sim_type' => 1,
);
$this->db->insert('menu_items', $menu);

/**
 * add the primary manifest
 */
$manifests = array(
	'manifest_name' => 'Primary Manifest',
	'manifest_desc' => "This is the primary manifest used by the sim.",
	'manifest_header_content' => "Update your manifest header content from the manifest management page.",
	'manifest_order' => 0,
	'manifest_display' => 'y',
	'manifest_default' => 'y'
);
$this->db->insert('manifests', $manifests);
$deptid = $this->db->insert_id();

/**
 * update the database with the right manifest id
 */
$this->db->where('dept_manifest', 0);
$this->db->update('departments_'.GENRE, array('dept_manifest' => $deptid));

/**
 * add the system version info
 */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/**
 * need to take in to account that some sims may have
 * more than one genre installed, so we need to do the
 * department table update for all the genres so that
 * nova doesn't break in the even they change their genre
 */

// get all the tables
$tables = $this->db->list_tables();

// grab the db table prefix
$prefix = $this->db->dbprefix;

// count the characters in the prefix and add "departments_" to it
$prefixChars = strlen($prefix);
$totalChars = $prefixChars + 12;

foreach ($tables as $key => $value)
{
	if (substr($value, 0, $totalChars) == $prefix.'departments_' && $value != $prefix.'departments_'.GENRE)
	{
		// the key used for the add column array
		$t = 'departments_'.GENRE;
		
		// the table name minus the prefix
		$table = str_replace($prefix, '', $value);
		
		// add the column to all of the department tables
		$this->dbforge->add_column($table, $add_column[$t]);
		
		// update the manifest field
		$this->db->where('dept_manifest', 0);
		$this->db->update($table, array('dept_manifest' => $deptid));
	}
}

/**
 * there is a bug in nova 1.1 where specification items aren't
 * properly associated with their data. to fix this, we need
 * to update all of the spec data. this only fixes people who
 * updated from nova 1.0. if you upgraded from sms to nova 1.1
 * none of your data was pulled over and you'll need to reinsert it
 */

$sdata = $this->db->get('specs_data');

if ($sdata->num_rows() > 0)
{
	foreach ($sdata->result() as $s)
	{
		$uarray = array('data_item' => 1);
		
		$this->db->where('data_item', 0);
		$this->db->update('specs_data', $uarray);
	}
}

/* End of file update_112.php */
/* Location: ./application/assets/update/update_112.php */