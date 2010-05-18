<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 0.9.4 => 0.9.5
|---------------------------------------------------------------
*/

/*
|---------------------------------------------------------------
| VERSION INFO FOR THE DATABASE
|---------------------------------------------------------------
*/

$system_versions = array(
	'version'			=> '0.9.5',
	'version_major'		=> 0,
	'version_minor'		=> 9,
	'version_update'	=> 5,
	'version_date'		=> now(),
	'version_launch'	=> 'Nova 0.9.5 is an update to the beta release of the next generation RPG management software from Anodyne Productions.',
	'version_changes'	=> ""
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 0,
	'sys_version_minor'		=> 9,
	'sys_version_update'	=> 5
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

/* jquery version info */
$this->db->where('comp_name', 'jQuery ColorBox');
$this->db->update('system_components', array('comp_version' => '1.3.6'));

/* new menu item */
$insert = array(
	'menu_name' => 'Sim Statistics',
	'menu_group' => 0,
	'menu_order' => 2,
	'menu_link' => 'report/stats',
	'menu_sim_type' => 1,
	'menu_type' => 'adminsub',
	'menu_cat' => 'report',
	'menu_use_access' => 'y',
	'menu_access' => 'report/stats',
);
$this->db->insert('menu_items', $insert);

/* new access page */
$insert = NULL;
$insert = array(
	'page_name' => "Sim Statistics",
	'page_url' => 'report/stats',
	'page_group' => 5,
	'page_desc' => "Can view a report on sim statistics for the current and previous months",
);
$this->db->insert('access_pages', $insert);
$insert_id = $this->db->insert_id();

/* update the roles */
$this->db->where('role_id', 1);
$this->db->update('access_roles', array('role_access' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,29,31,33,34,35,36,37,38,39,40,41,42,43,46,47,50,52,53,55,57,60,61,'. $insert_id));

$this->db->where('role_id', 2);
$this->db->update('access_roles', array('role_access' => '1,2,3,4,5,6,7,8,21,29,31,33,35,37,38,39,40,41,42,43,46,47,50,52,53,55,57,60,61,'. $insert_id));

$this->db->where('role_id', 3);
$this->db->update('access_roles', array('role_access' => '1,2,4,5,6,7,8,28,30,32,37,38,40,41,45,49,51,54,56,59,'. $insert_id));

$this->db->where('role_id', 4);
$this->db->update('access_roles', array('role_access' => '1,2,4,5,6,7,8,28,30,32,37,38,40,48,51,54,56,58,'. $insert_id));

/* add system version info */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/* End of file update_094.php */
/* Location: ./application/assets/update/update_094.php */