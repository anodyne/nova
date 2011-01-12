<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 1.0.1 => 1.0.2
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
	'version'			=> '1.0.2',
	'version_major'		=> 1,
	'version_minor'		=> 0,
	'version_update'	=> 2,
	'version_date'		=> 1271817000,
	'version_launch'	=> 'Nova 1.0.2 is a maintenance release that fixes a majority of the outstanding issues with Nova 1.0, including: login issues, post display issues and bug with posting mission entries. See the changelog after updating for a complete list of changes. This update is recommended for all users.',
	'version_changes'	=> "* added the 1.0.2 update file
* added the MY\_Input library to add a call to a text cleanup function after filtering for XSS
* updated the database schema to use a genre field in the rank catalogue table
* updated the genre install files to populate the new genre field in the rank catalogue table on creation
* updated the language files
    * [base\_lang] added labels_genre key
    * [error\_lang] added error_login_7
* updated the ranks model to pull the genre when looking for the default rank catalogue item
* updated the ranks model to pull only the ranks sets from a genre when getting all ranks
* updated the ranks model to only pull rank catalogue items for the given genre
* updated the site controller to handle adding and editing the genre for a rank catalogue item
* updated the ajax controller to handle adding and editing the genre for a rank catalogue item
* updated the upload management page to show messages if uploaded images weren't found in specific categories
* updated the write news item page to not allow a user to have a news item without a category
* updated the index file to use a higher debug to allow people to see any errors for debugging purposes
* updated the upgrade process to fix some minor schema differences between sms and nova
* updated the ranks model so the get\_group\_ranks() method had a customizable identifier
* updated the auth library to check for a user's status and not allow pending users to log in to the system
* updated the login page to handle the new pending user error
* updated the Auth library to increase the login attempts allowed to 5
* updated the Auth library to attempt a fix to the remember me lockout issue
* updated the user account page to reset the cookie in the event of a password reset if the user has elected to have nova remember them
* updated the admin controller so that nova resets the cookie password after an SMS upgrade if the user has elected to have nova remember them
* fixed bug where the menu library wouldn't respect any access control put on main navigation menu items (#101)
* fixed bug where the menu library wouldn't respect any access control put on sub navigation menu items
* fixed undefined variable error thrown on site/catalogueranks
* fixed bug where rank catalogue items didn't work well when multiple genres were installed (#102)
* fixed bug where uploaded images besides bio images couldn't be deleted
* fixed bug where authors were being dropped off of posts because of faulty logic
* fixed bug where sample post wasn't sent out in the email sent to game masters
* fixed bug in IE where ranks couldn't be added
* fixed bug where rank classes wouldn't be shown for ranks sets without a blank name rank item
* fixed bug where the user bio pointed to the wrong location for user posts and awards
* fixed bug where listing all of a users' posts would display posts besides their own
* fixed error thrown on commenting on a mission post
* fixed fatal error thrown when updating a news item
* fixed fatal error thrown when updating a personal log
* fixed a presentational bug in login error #6
* fixed bug where the mission dropdown wasn't properly populated when viewing a saved post"
);

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

/* add system version info */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/* End of file update_101.php */
/* Location: ./application/assets/update/update_101.php */