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

$modify_column = array(
	'access_pages' => array(
		'page_desc' => array(
			'null' => TRUE
		)
	),
	'access_roles' => array(
		'role_access' => array(
			'null' => TRUE
		),
		'role_desc' => array(
			'null' => TRUE
		)
	),
	'applications' => array(
		'app_character_name' => array(
			'null' => TRUE
		),
		'app_message' => array(
			'null' => TRUE
		)
	),
	'awards' => array(
		'award_desc' => array(
			'null' => TRUE
		)
	),
	'awards_queue' => array(
		'queue_receive_character' => array(
			'default' => 0
		),
		'queue_nominate' => array(
			'default' => 0
		),
		'queue_reason' => array(
			'null' => TRUE
		)
	),
	'awards_received' => array(
		'awardrec_reason' => array(
			'null' => TRUE
		)
	),
	'bans' => array(
		'ban_level' => array(
			'default' => 1
		),
		'ban_reason' => array(
			'null' => TRUE
		)
	),
	'catalogue_ranks' => array(
		'rankcat_credits' => array(
			'null' => TRUE
		),
		'rankcat_url' => array(
			'null' => TRUE
		)
	),
	'catalogue_skins' => array(
		'skin_credits' => array(
			'null' => TRUE
		)
	),
	'characters' => array(
		'user' => array(
			'null' => TRUE
		),
		'date_activate' => array(
			'null' => TRUE
		),
		'date_deactivate' => array(
			'null' => TRUE
		),
		'images' => array(
			'null' => TRUE
		),
		'rank' => array(
			'null' => TRUE
		),
		'position_2' => array(
			'null' => TRUE
		),
		'last_post' => array(
			'null' => TRUE
		)
	),
	'characters_data' => array(
		'data_value' => array(
			'null' => TRUE
		)
	),
	'characters_fields' => array(
		'field_type' => array(
			'null' => TRUE
		),
		'field_class' => array(
			'null' => TRUE
		),
		'field_label_page' => array(
			'null' => TRUE
		),
		'field_value' => array(
			'null' => TRUE
		),
		'field_help' => array(
			'null' => TRUE
		)
	),
	'characters_values' => array(
		'value_content' => array(
			'null' => TRUE
		)
	),
	'departments' => array(
		'dept_desc' => array(
			'null' => TRUE
		)
	),
	'docking' => array(
		'docking_sim_url' => array(
			'null' => TRUE
		)
	),
	'docking_data' => array(
		'data_value' => array(
			'null' => TRUE
		)
	),
	'docking_fields' => array(
		'field_type' => array(
			'null' => TRUE
		),
		'field_class' => array(
			'null' => TRUE
		),
		'field_label_page' => array(
			'null' => TRUE
		),
		'field_value' => array(
			'null' => TRUE
		),
		'field_help' => array(
			'null' => TRUE
		)
	),
	'docking_values' => array(
		'value_content' => array(
			'null' => TRUE
		)
	),
	'manifests' => array(
		'manifest_desc' => array(
			'null' => TRUE
		),
		'manifest_header_content' => array(
			'null' => TRUE
		),
		'manifest_view' => array(
			'null' => TRUE
		),
		'manifest_metadata' => array(
			'null' => TRUE
		)
	),
	'menu_items' => array(
		'menu_link' => array(
			'null' => TRUE
		)
	),
	'messages' => array(
		'message_content' => array(
			'null' => TRUE
		)
	),
	'mission_groups' => array(
		'misgroup_desc' => array(
			'null' => TRUE
		)
	),
	'missions' => array(
		'mission_images' => array(
			'null' => TRUE
		),
		'mission_group' => array(
			'null' => TRUE
		),
		'mission_start' => array(
			'null' => TRUE
		),
		'mission_end' => array(
			'null' => TRUE
		),
		'mission_desc' => array(
			'null' => TRUE
		),
		'mission_summary' => array(
			'null' => TRUE
		),
		'mission_notes' => array(
			'null' => TRUE
		),
		'mission_notes_updated' => array(
			'null' => TRUE
		)
	),
	'news' => array(
		'news_tags' => array(
			'null' => TRUE
		)
	),
	'news_comments' => array(
		'ncomment_content' => array(
			'null' => TRUE
		)
	),
	'personallogs' => array(
		'log_tags' => array(
			'null' => TRUE
		)
	),
	'personallogs_comments' => array(
		'lcomment_content' => array(
			'null' => TRUE
		)
	),
	'positions' => array(
		'pos_desc' => array(
			'null' => TRUE
		)
	),
	'posts' => array(
		'post_authors' => array(
			'null' => TRUE
		),
		'post_authors_users' => array(
			'null' => TRUE
		),
		'post_saved' => array(
			'null' => TRUE
		),
		'post_tags' => array(
			'null' => TRUE
		),
		'post_participants' => array(
			'null' => TRUE
		),
		'post_lock_user' => array(
			'null' => TRUE
		),
		'post_lock_date' => array(
			'null' => TRUE
		)
	),
	'posts_comments' => array(
		'pcomment_content' => array(
			'null' => TRUE
		)
	),
	'privmsgs' => array(
		'privmsgs_content' => array(
			'null' => TRUE
		)
	),
	'security_questions' => array(
		'question_value' => array(
			'null' => TRUE
		)
	),
	'settings' => array(
		'setting_value' => array(
			'null' => TRUE
		)
	),
	'sessions' => array(
		'user_data' => array(
			'null' => TRUE
		)
	),
	'specs' => array(
		'specs_images' => array(
			'null' => TRUE
		),
		'specs_summary' => array(
			'null' => TRUE
		)
	),
	'specs_data' => array(
		'data_value' => array(
			'null' => TRUE
		),
		'data_updated' => array(
			'null' => TRUE
		)
	),
	'specs_fields' => array(
		'field_type' => array(
			'null' => TRUE
		),
		'field_class' => array(
			'null' => TRUE
		),
		'field_label_page' => array(
			'null' => TRUE
		),
		'field_value' => array(
			'null' => TRUE
		),
		'field_help' => array(
			'null' => TRUE
		)
	),
	'specs_values' => array(
		'value_content' => array(
			'null' => TRUE
		)
	),
	'system_info' => array(
		'sys_last_update' => array(
			'null' => TRUE
		)
	),
	'tour' => array(
		'tour_images' => array(
			'null' => TRUE
		),
		'tour_summary' => array(
			'null' => TRUE
		)
	),
	'tour_data' => array(
		'data_value' => array(
			'null' => TRUE
		),
		'data_updated' => array(
			'null' => TRUE
		)
	),
	'tour_fields' => array(
		'field_type' => array(
			'null' => TRUE
		),
		'field_class' => array(
			'null' => TRUE
		),
		'field_label_page' => array(
			'null' => TRUE
		),
		'field_value' => array(
			'null' => TRUE
		),
		'field_help' => array(
			'null' => TRUE
		)
	),
	'tour_values' => array(
		'value_content' => array(
			'null' => TRUE
		)
	),
	'tour_decks' => array(
		'deck_content' => array(
			'null' => TRUE
		)
	),
	'uploads' => array(
		'upload_filename' => array(
			'null' => TRUE
		)
	),
	'user_loa' => array(
		'loa_duration' => array(
			'null' => TRUE
		),
		'loa_reason' => array(
			'null' => TRUE
		)
	),
	'user_prefs' => array(
		'pref_default' => array(
			'null' => TRUE
		)
	),
	'user_prefs_values' => array(
		'prefvalue_value' => array(
			'null' => TRUE
		)
	),
	'users' => array(
		'instant_message' => array(
			'null' => TRUE
		),
		'main_char' => array(
			'null' => TRUE
		),
		'access_role' => array(
			'null' => TRUE
		),
		'join_date' => array(
			'null' => TRUE
		),
		'leave_date' => array(
			'null' => TRUE
		),
		'last_post' => array(
			'null' => TRUE
		),
		'last_login' => array(
			'null' => TRUE
		),
		'location' => array(
			'null' => TRUE
		),
		'interests' => array(
			'null' => TRUE
		),
		'bio' => array(
			'null' => TRUE
		),
		'security_question' => array(
			'default' => 1
		),
		'my_links' => array(
			'null' => TRUE
		),
		'last_update' => array(
			'null' => TRUE
		)
	),
	'wiki_categories' => array(
		'wikicat_desc' => array(
			'null' => TRUE
		)
	),
	'wiki_comments' => array(
		'wcomment_content' => array(
			'null' => TRUE
		)
	),
	'wiki_drafts' => array(
		'draft_id_old' => array(
			'null' => TRUE
		),
		'draft_summary' => array(
			'null' => TRUE
		),
		'draft_categories' => array(
			'null' => TRUE
		),
		'draft_changed_comments' => array(
			'null' => TRUE
		)
	),
	'wiki_pages' => array(
		'page_updated_at' => array(
			'null' => TRUE
		),
		'page_updated_by_user' => array(
			'null' => TRUE
		),
		'page_updated_by_character' => array(
			'null' => TRUE
		)
	),
	'wiki_restrictions' => array(
		'restr_updated_at' => array(
			'null' => TRUE
		),
		'restr_updated_by' => array(
			'null' => TRUE
		),
		'restrictions' => array(
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
