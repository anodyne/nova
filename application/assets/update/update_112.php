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
	'version_date'		=> 1285628400,
	'version_launch'	=> "Nova 1.2 is... A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
	'version_changes'	=> ""
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
		'fields' => 'fields_bans')
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
$pageid = $this->db->insert_id();

/**
 * add the new access page to the system administrator role
 */
$query = $this->db->get_where('access_roles', array('role_name' => 'System Administrator'));
$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
if ($row !== FALSE)
{
	$role = array('role_access' => $row->role_access.','.$pageid);
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

/**
 * add the system version info
 */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/* End of file update_112.php */
/* Location: ./application/assets/update/update_112.php */