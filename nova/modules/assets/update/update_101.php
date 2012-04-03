<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 1.0.1 => 1.0.2
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
	'sys_version_minor'		=> 0,
	'sys_version_update'	=> 2
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

$add_column = array(
	'catalogue_ranks' => array(
		'rankcat_genre' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'default' => GENRE)
	)
);

if (!$this->db->field_exists('mission_group', 'missions'))
{
	$add_column['missions'] = array(
		'mission_group' => array(
			'type' => 'INT',
			'constraint' => 5)
	);
}

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

$modify_column = array(
	'missions' => array(
		'mission_title' => array(
			'name' => 'mission_title',
			'type' => 'VARCHAR',
			'constraint' => 255)
	),
	'news_categories' => array(
		'newscat_name' => array(
			'name' => 'newscat_name',
			'type' => 'VARCHAR',
			'constraint' => 255)
	),
	'news' => array(
		'news_author_character' => array(
			'name' => 'news_author_character',
			'type' => 'INT',
			'constraint' => 8),
		'news_author_user' => array(
			'name' => 'news_author_user',
			'type' => 'INT',
			'constraint' => 8),
		'news_title' => array(
			'name' => 'news_title',
			'type' => 'VARCHAR',
			'constraint' => 255)
	),
	'personallogs' => array(
		'log_author_character' => array(
			'name' => 'log_author_character',
			'type' => 'INT',
			'constraint' => 8),
		'log_author_user' => array(
			'name' => 'log_author_user',
			'type' => 'INT',
			'constraint' => 8),
		'log_title' => array(
			'name' => 'log_title',
			'type' => 'VARCHAR',
			'constraint' => 255)
	),
	'posts' => array(
		'post_title' => array(
			'name' => 'post_title',
			'type' => 'VARCHAR',
			'constraint' => 255),
		'post_location' => array(
			'name' => 'post_location',
			'type' => 'VARCHAR',
			'constraint' => 255),
		'post_timeline' => array(
			'name' => 'post_timeline',
			'type' => 'VARCHAR',
			'constraint' => 255)
	)
);

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

/* End of file update_101.php */
/* Location: ./application/assets/update/update_101.php */