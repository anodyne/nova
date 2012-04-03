<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 1.1.2 => 1.2
|---------------------------------------------------------------
*/

$system_info	= NULL;
$add_tables		= NULL;
$drop_tables	= NULL;
$rename_tables	= NULL;
$add_column		= NULL;
$modify_column	= NULL;
$drop_column	= NULL;

/*
|---------------------------------------------------------------
| VERSION INFO FOR THE DATABASE
|---------------------------------------------------------------
*/

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