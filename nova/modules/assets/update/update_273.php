<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Update Nova from 2.7.3 to 2.7.4
 */
$system_info = null;
$add_tables = null;
$drop_tables = null;
$rename_tables = null;
$add_column = null;
$modify_column = null;
$drop_column = null;

/**
 * Version info for the database
 */
$system_info = [
    'sys_last_update' => now(),
    'sys_version_major' => 2,
    'sys_version_minor' => 7,
    'sys_version_update' => 4,
];

/*
|---------------------------------------------------------------
| TABLES TO DROP
|
| $drop_tables = array('table_name');
|---------------------------------------------------------------
*/

if ($drop_tables !== null) {
    foreach ($drop_tables as $tableToDrop) {
        if ($this->db->table_exists($tableToDrop)) {
            $this->dbforge->drop_table($tableToDrop);
        }
    }
}

/*
|---------------------------------------------------------------
| TABLES TO RENAME
|
| $rename_tables = array('old_table_name' => 'new_table_name');
|---------------------------------------------------------------
*/

if ($rename_tables !== null) {
    foreach ($rename_tables as $oldTableName => $newTableName) {
        if ($this->db->table_exists($oldTableName)) {
            $this->dbforge->rename_table($oldTableName, $newTableName);
        }
    }
}

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

if ($add_tables !== null) {
    foreach ($add_tables as $tableName => $tableData) {
        if (! $this->db->table_exists($tableName)) {
            $this->dbforge->add_field(${$tableData['fields']});
            $this->dbforge->add_key($tableData['id'], true);
            $this->dbforge->create_table($tableName, true);
        }
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

if ($add_column !== null) {
    foreach ($add_column as $tableName => $columns) {
        foreach ($columns as $columnName => $columnData) {
            if (! $this->db->field_exists($columnName, $tableName)) {
                $this->dbforge->add_column($tableName, $columns);
            }
        }
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

$nullable = ['null' => true];

$modify_column = [
    'access_pages' => ['page_desc' => $nullable],
    'access_roles' => [
        'role_access' => $nullable,
        'role_desc' => $nullable,
    ],
    'applications' => [
        'app_character_name' => $nullable,
        'app_message' => $nullable,
    ],
    'awards' => ['award_desc' => $nullable],
    'awards_queue' => ['queue_reason' => $nullable],
    'awards_received' => ['awardrec_reason' => $nullable],
    'bans' => ['ban_reason' => $nullable],
    'catalogue_ranks' => [
        'rankcat_credits' => $nullable,
        'rankcat_url' => $nullable,
    ],
    'catalogue_skins' => ['skin_credits' => $nullable],
    'characters' => [
        'user' => $nullable,
        'date_activate' => $nullable,
        'date_deactivate' => $nullable,
        'images' => $nullable,
        'rank' => $nullable,
        'position_2' => $nullable,
        'last_post' => $nullable,
    ],
    'characters_data' => [
        'data_user' => $nullable,
        'data_value' => $nullable,
    ],
    'characters_fields' => [
        'field_type' => $nullable,
        'field_class' => $nullable,
        'field_label_page' => $nullable,
        'field_value' => $nullable,
        'field_help' => $nullable,
    ],
    'characters_promotions' => ['prom_user' => $nullable],
    'characters_values' => ['value_content' => $nullable],
    'departments' => ['dept_desc' => $nullable],
    'docking' => ['docking_sim_url' => $nullable],
    'docking_data' => ['data_value' => $nullable],
    'docking_fields' => [
        'field_type' => $nullable,
        'field_class' => $nullable,
        'field_label_page' => $nullable,
        'field_value' => $nullable,
        'field_help' => $nullable,
    ],
    'docking_values' => ['value_content' => $nullable],
    'manifests' => [
        'manifest_desc' => $nullable,
        'manifest_header_content' => $nullable,
        'manifest_view' => $nullable,
        'manifest_metadata' => $nullable,
    ],
    'menu_items' => ['menu_link' => $nullable],
    'messages' => ['message_content' => $nullable],
    'mission_groups' => ['misgroup_desc' => $nullable],
    'missions' => [
        'mission_images' => $nullable,
        'mission_group' => $nullable,
        'mission_start' => $nullable,
        'mission_end' => $nullable,
        'mission_desc' => $nullable,
        'mission_summary' => $nullable,
        'mission_notes' => $nullable,
        'mission_notes_updated' => $nullable,
    ],
    'news' => [
        'news_content' => $nullable,
        'news_tags' => $nullable,
    ],
    'news_comments' => ['ncomment_content' => $nullable],
    'personallogs' => [
        'log_content' => $nullable,
        'log_tags' => $nullable,
    ],
    'personallogs_comments' => ['lcomment_content' => $nullable],
    'positions' => ['pos_desc' => $nullable],
    'posts' => [
        'post_authors' => $nullable,
        'post_authors_users' => $nullable,
        'post_saved' => $nullable,
        'post_content' => $nullable,
        'post_tags' => $nullable,
        'post_participants' => $nullable,
        'post_lock_user' => $nullable,
        'post_lock_date' => $nullable,
    ],
    'posts_comments' => ['pcomment_content' => $nullable],
    'privmsgs' => ['privmsgs_content' => $nullable],
    'security_questions' => ['question_value' => $nullable],
    'settings' => ['setting_value' => $nullable],
    'specs' => [
        'specs_images' => $nullable,
        'specs_summary' => $nullable,
    ],
    'specs_data' => [
        'data_value' => $nullable,
        'data_updated' => $nullable,
    ],
    'specs_fields' => [
        'field_type' => $nullable,
        'field_class' => $nullable,
        'field_label_page' => $nullable,
        'field_value' => $nullable,
        'field_help' => $nullable,
    ],
    'specs_values' => ['value_content' => $nullable],
    'system_info' => ['sys_last_update' => $nullable],
    'tour' => [
        'tour_images' => $nullable,
        'tour_summary' => $nullable,
    ],
    'tour_data' => [
        'data_value' => $nullable,
        'data_updated' => $nullable,
    ],
    'tour_fields' => [
        'field_type' => $nullable,
        'field_class' => $nullable,
        'field_label_page' => $nullable,
        'field_value' => $nullable,
        'field_help' => $nullable,
    ],
    'tour_values' => ['value_content' => $nullable],
    'tour_decks' => ['deck_content' => $nullable],
    'uploads' => ['upload_filename' => $nullable],
    'user_loa' => [
        'loa_start_date' => $nullable,
        'loa_end_date' => $nullable,
        'loa_duration' => $nullable,
        'loa_reason' => $nullable,
    ],
    'user_prefs' => ['pref_default' => $nullable],
    'user_prefs_values' => ['prefvalue_value' => $nullable],
    'users' => [
        'instant_message' => $nullable,
        'main_char' => $nullable,
        'access_role' => $nullable,
        'join_date' => $nullable,
        'leave_date' => $nullable,
        'last_post' => $nullable,
        'last_login' => $nullable,
        'location' => $nullable,
        'interests' => $nullable,
        'bio' => $nullable,
        'my_links' => $nullable,
        'last_update' => $nullable,
    ],
    'wiki_categories' => ['wikicat_desc' => $nullable],
    'wiki_comments' => ['wcomment_content' => $nullable],
    'wiki_drafts' => [
        'draft_id_old' => $nullable,
        'draft_summary' => $nullable,
        'draft_content' => $nullable,
        'draft_categories' => $nullable,
        'draft_changed_comments' => $nullable,
    ],
    'wiki_pages' => [
        'page_updated_at' => $nullable,
        'page_updated_by_user' => $nullable,
        'page_updated_by_character' => $nullable,
    ],
    'wiki_restrictions' => [
        'restr_updated_at' => $nullable,
        'restr_updated_by' => $nullable,
        'restrictions' => $nullable,
    ],
];

if ($modify_column !== null) {
    foreach ($modify_column as $key => $value) {
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

if ($drop_column !== null) {
    foreach ($drop_column as $tableName => $columns) {
        $this->dbforge->drop_column($tableName, $columns[0]);
    }
}
