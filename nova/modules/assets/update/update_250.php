<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Update Nova from 2.5.0 to 2.5.1
 */
$system_info	= null;
$add_tables		= null;
$drop_tables	= null;
$rename_tables	= null;
$add_column		= null;
$modify_column	= null;
$drop_column	= null;

/**
 * Version info for the database
 */
$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 2,
	'sys_version_minor'		=> 5,
	'sys_version_update'	=> 1,
);

/*
|---------------------------------------------------------------
| TABLES TO ADD
|
| $add_tables = array(
|	'table_name' => array(
|		'id' => 'table_id',
|		'fields' => 'table_name')
| );
|
| $table_name = array(
|	'table_id' => array(
|		'type' => 'INT',
|		'constraint' => 6,
|		'auto_increment' => TRUE
),
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

if ($add_tables !== null)
{
	foreach ($add_tables as $key => $value)
	{
		$this->dbforge->add_field($$value['fields']);
		$this->dbforge->add_key($value['id'], true
	);
		$this->dbforge->create_table($key, true
	);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO DROP
|
| $drop_tables = array('table_name');
|---------------------------------------------------------------
*/

if ($drop_tables !== null)
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

if ($rename_tables !== null)
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

if ($add_column !== null)
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

$user_id_type				= 'INT';
$user_id_constraint			= 8;
$character_id_type			= 'INT';
$character_id_constraint	= 8;
$date_type					= 'BIGINT';
$date_constraint			= 20;

$modify_column = array(
	'access_pages' => array(
		'page_desc' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'access_roles' => array(
		'role_access' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'role_desc' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'applications' => array(
		'app_character_name' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'app_message' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'awards' => array(
		'award_desc' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'awards_queue' => array(
		'queue_receive_character' => array(
			'type' => $character_id_type,
			'constraint' => $character_id_constraint,
			'default' => 0
		),
		'queue_nominate' => array(
			'type' => $character_id_type,
			'constraint' => $character_id_constraint,
			'default' => 0
		),
		'queue_reason' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'awards_received' => array(
		'awardrec_reason' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'bans' => array(
		'ban_level' => array(
			'type' => 'INT',
			'constraint' => 1,
			'default' => 1
		),
		'ban_reason' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'catalogue_ranks' => array(
		'rankcat_credits' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'rankcat_url' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'catalogue_skins' => array(
		'skin_credits' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'characters' => array(
		'user' => array(
			'type' => $user_id_type,
			'constraint' => $user_id_constraint,
			'null' => TRUE
		),
		'date_activate' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'date_deactivate' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'images' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'rank' => array(
			'type' => 'INT',
			'constraint' => 10,
			'null' => TRUE
		),
		'position_2' => array(
			'type' => 'INT',
			'constraint' => 10,
			'null' => TRUE
		),
		'last_post' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		)
	),
	'characters_data' => array(
		'data_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'characters_fields' => array(
		'field_type' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_class' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_label_page' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_help' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'characters_values' => array(
		'value_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'departments_'.GENRE => array(
		'dept_desc' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'docking' => array(
		'docking_sim_url' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'docking_data' => array(
		'data_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'docking_fields' => array(
		'field_type' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_class' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_label_page' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_help' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'docking_values' => array(
		'value_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'manifests' => array(
		'manifest_desc' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'manifest_header_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'manifest_view' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'manifest_metadata' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'menu_items' => array(
		'menu_link' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'messages' => array(
		'message_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'mission_groups' => array(
		'misgroup_desc' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'missions' => array(
		'mission_images' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'mission_group' => array(
			'type' => 'INT',
			'constraint' => 5,
			'null' => TRUE
		),
		'mission_start' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'mission_end' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'mission_desc' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'mission_summary' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'mission_notes' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'mission_notes_updated' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		)
	),
	'news' => array(
		'news_tags' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'news_comments' => array(
		'ncomment_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'personallogs' => array(
		'log_tags' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'personallogs_comments' => array(
		'lcomment_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'positions_'.GENRE => array(
		'pos_desc' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'posts' => array(
		'post_authors' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'post_authors_users' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'post_saved' => array(
			'type' => $user_id_type,
			'constraint' => $user_id_constraint,
			'null' => TRUE
		),
		'post_tags' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'post_participants' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'post_lock_user' => array(
			'type' => $user_id_type,
			'constraint' => $user_id_constraint,
			'null' => TRUE
		),
		'post_lock_date' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		)
	),
	'posts_comments' => array(
		'pcomment_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'privmsgs' => array(
		'privmsgs_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'security_questions' => array(
		'question_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'settings' => array(
		'setting_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'sessions' => array(
		'user_data' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'specs' => array(
		'specs_images' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'specs_summary' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'specs_data' => array(
		'data_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'data_updated' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		)
	),
	'specs_fields' => array(
		'field_type' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_class' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_label_page' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_help' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'specs_values' => array(
		'value_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'system_info' => array(
		'sys_last_update' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		)
	),
	'tour' => array(
		'tour_images' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'tour_summary' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'tour_data' => array(
		'data_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'data_updated' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		)
	),
	'tour_fields' => array(
		'field_type' => array(
			'type' => 'ENUM',
			'constraint' => "'text','select','textarea'",
			'default' => 'TEXT',
			'null' => TRUE
		),
		'field_class' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_label_page' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'field_help' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'tour_values' => array(
		'value_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'tour_decks' => array(
		'deck_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'uploads' => array(
		'upload_filename' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'user_loa' => array(
		'loa_duration' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'loa_reason' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'loa_start_date' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'loa_end_date' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		)
	),
	'user_prefs' => array(
		'pref_default' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'user_prefs_values' => array(
		'prefvalue_value' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'users' => array(
		'instant_message' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'main_char' => array(
			'type' => $character_id_type,
			'constraint' => $character_id_constraint,
			'null' => TRUE
		),
		'access_role' => array(
			'type' => 'INT',
			'constraint' => 5,
			'null' => TRUE
		),
		'join_date' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'leave_date' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'last_post' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'last_login' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'location' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'interests' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'bio' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'security_question' => array(
			'type' => 'INT',
			'constraint' => 5,
			'default' => 1
		),
		'my_links' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'last_update' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		)
	),
	'wiki_categories' => array(
		'wikicat_desc' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'wiki_comments' => array(
		'wcomment_content' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'wiki_drafts' => array(
		'draft_id_old' => array(
			'type' => 'INT',
			'constraint' => 10,
			'null' => TRUE
		),
		'draft_summary' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'draft_categories' => array(
			'type' => 'TEXT',
			'null' => TRUE
		),
		'draft_changed_comments' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	),
	'wiki_pages' => array(
		'page_updated_at' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'page_updated_by_user' => array(
			'type' => $user_id_type,
			'constraint' => $user_id_constraint,
			'null' => TRUE
		),
		'page_updated_by_character' => array(
			'type' => $character_id_type,
			'constraint' => $character_id_constraint,
			'null' => TRUE
		)
	),
	'wiki_restrictions' => array(
		'restr_updated_at' => array(
			'type' => $date_type,
			'constraint' => $date_constraint,
			'null' => TRUE
		),
		'restr_updated_by' => array(
			'type' => $user_id_type,
			'constraint' => $user_id_constraint,
			'null' => TRUE
		),
		'restrictions' => array(
			'type' => 'TEXT',
			'null' => TRUE
		)
	)
);

if ($modify_column !== null)
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

if ($drop_column !== null)
{
	foreach ($drop_column as $key => $value)
	{
		$this->dbforge->drop_column($key, $value[0]);
	}
}
