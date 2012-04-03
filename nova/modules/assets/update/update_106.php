<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 1.0.6 => 1.1.0
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
	'sys_version_minor'		=> 1,
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
	'specs' => array(
		'id' => 'specs_id',
		'fields' => 'fields_specs')
);

$fields_specs = array(
	'specs_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'specs_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'specs_order' => array(
		'type' => 'INT',
		'constraint' => 4),
	'specs_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'specs_images' => array(
		'type' => 'TEXT'),
	'specs_summary' => array(
		'type' => 'TEXT')
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
	'specs_data' => array(
		'data_item' => array(
			'type' => 'INT',
			'constraint' => 5)
	),
	'tour' => array(
		'tour_spec_item' => array(
			'type' => 'INT',
			'constraint' => 5)
	),
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

// get the specs data
$specs = $this->db->get_where('specs_data', array('data_value !=' => ''));

// if there is specs data, then continue with updating it
if ($specs->num_rows() > 0)
{
	/**
	 * update all the specs data to point to the first specification item
	 */
	$this->db->update('specs_data', array('data_item' => 1));
	
	/**
	 * create a new specification item from the sim name
	 */
	$name = $this->db->get_where('settings', array('setting_key' => 'sim_name'));
	$name = ($name->num_rows() > 0) ? $name->row() : FALSE;
	$specitem = array(
		'specs_name' => $name->setting_value,
		'specs_summary' => 'Summary for the '. $name->setting_value,
	);
	$this->db->insert('specs', $specitem);
}

/* End of file update_106.php */
/* Location: ./application/assets/update/update_106.php */