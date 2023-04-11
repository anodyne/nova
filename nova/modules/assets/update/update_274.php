<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Update Nova from 2.7.4 to 2.7.5
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
    'sys_version_update' => 5,
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
$userField = [
    'type' => 'INT',
    'constraint' => 8,
];
$characterField = [
    'type' => 'INT',
    'constraint' => 8,
];
$dateField = [
    'type' => 'BIGINT',
    'constraint' => 20,
];
$textField = [
    'type' => 'TEXT',
];


$modify_column = [
    'access_pages' => [
        'page_desc' => array_merge($nullable, $textField),
    ],
    'access_roles' => [
        'role_access' => array_merge($nullable, $textField),
        'role_desc' => array_merge($nullable, $textField),
    ],
    'applications' => [
        'app_character_name' => array_merge($nullable, $textField),
        'app_message' => array_merge($nullable, $textField),
    ],
    'awards' => [
        'award_desc' => array_merge($nullable, $textField),
    ],
    'awards_queue' => [
        'queue_reason' => array_merge($nullable, $textField),
    ],
    'awards_received' => [
        'awardrec_reason' => array_merge($nullable, $textField),
    ],
    'bans' => [
        'ban_reason' => array_merge($nullable, $textField),
    ],
    'catalogue_ranks' => [
        'rankcat_credits' => array_merge($nullable, $textField),
        'rankcat_url' => array_merge($nullable, $textField),
    ],
    'catalogue_skins' => [
        'skin_credits' => array_merge($nullable, $textField),
    ],
    'characters' => [
        'user' => array_merge($nullable, $userField),
        'date_activate' => array_merge($nullable, $dateField),
        'date_deactivate' => array_merge($nullable, $dateField),
        'images' => array_merge($nullable, $textField),
        'rank' => array_merge($nullable, ['type' => 'INT', 'constraint' => 10]),
        'position_2' => array_merge($nullable, ['type' => 'INT', 'constraint' => 10]),
        'last_post' => array_merge($nullable, $dateField),
    ],
    'characters_data' => [
        'data_user' => array_merge($nullable, $userField),
        'data_value' => array_merge($nullable, $textField),
    ],
    'characters_fields' => [
        'field_type' => array_merge($nullable, [
            'type' => 'ENUM',
            'constraint' => ['text','select','textarea'],
            'default' => 'text',
        ]),
        'field_class' => array_merge($nullable, $textField),
        'field_label_page' => array_merge($nullable, $textField),
        'field_value' => array_merge($nullable, $textField),
        'field_help' => array_merge($nullable, $textField),
    ],
    'characters_promotions' => [
        'prom_user' => array_merge($nullable, $userField),
    ],
    'characters_values' => [
        'value_content' => array_merge($nullable, $textField),
    ],
    'departments' => [
        'dept_desc' => array_merge($nullable, $textField),
    ],
    'docking' => [
        'docking_sim_url' => array_merge($nullable, $textField),
    ],
    'docking_data' => [
        'data_value' => array_merge($nullable, $textField),
    ],
    'docking_fields' => [
        'field_type' => array_merge($nullable, [
            'type' => 'ENUM',
            'constraint' => ['text','select','textarea'],
            'default' => 'text',
        ]),
        'field_class' => array_merge($nullable, $textField),
        'field_label_page' => array_merge($nullable, $textField),
        'field_value' => array_merge($nullable, $textField),
        'field_help' => array_merge($nullable, $textField),
    ],
    'docking_values' => [
        'value_content' => array_merge($nullable, $textField),
    ],
    'manifests' => [
        'manifest_desc' => array_merge($nullable, $textField),
        'manifest_header_content' => array_merge($nullable, $textField),
        'manifest_view' => array_merge($nullable, $textField),
        'manifest_metadata' => array_merge($nullable, $textField),
    ],
    'menu_items' => [
        'menu_link' => array_merge($nullable, $textField),
    ],
    'messages' => [
        'message_content' => array_merge($nullable, $textField),
    ],
    'mission_groups' => [
        'misgroup_desc' => array_merge($nullable, $textField),
    ],
    'missions' => [
        'mission_images' => array_merge($nullable, $textField),
        'mission_group' => array_merge($nullable, ['type' => 'INT', 'constraint' => 5]),
        'mission_start' => array_merge($nullable, $dateField),
        'mission_end' => array_merge($nullable, $dateField),
        'mission_desc' => array_merge($nullable, $textField),
        'mission_summary' => array_merge($nullable, $textField),
        'mission_notes' => array_merge($nullable, $textField),
        'mission_notes_updated' => array_merge($nullable, $dateField),
    ],
    'news' => [
        'news_content' => array_merge($nullable, $textField),
        'news_tags' => array_merge($nullable, $textField),
    ],
    'news_comments' => [
        'ncomment_content' => array_merge($nullable, $textField),
    ],
    'personallogs' => [
        'log_content' => array_merge($nullable, $textField),
        'log_tags' => array_merge($nullable, $textField),
    ],
    'personallogs_comments' => [
        'lcomment_content' => array_merge($nullable, $textField),
    ],
    'positions' => [
        'pos_desc' => array_merge($nullable, $textField),
    ],
    'posts' => [
        'post_authors' => array_merge($nullable, $textField),
        'post_authors_users' => array_merge($nullable, $textField),
        'post_saved' => array_merge($nullable, $userField),
        'post_content' => array_merge($nullable, $textField),
        'post_tags' => array_merge($nullable, $textField),
        'post_participants' => array_merge($nullable, $textField),
        'post_lock_user' => array_merge($nullable, $userField),
        'post_lock_date' => array_merge($nullable, $dateField),
    ],
    'posts_comments' => [
        'pcomment_content' => array_merge($nullable, $textField),
    ],
    'privmsgs' => [
        'privmsgs_content' => array_merge($nullable, $textField),
    ],
    'security_questions' => [
        'question_value' => array_merge($nullable, $textField),
    ],
    'settings' => [
        'setting_value' => array_merge($nullable, $textField),
    ],
    'specs' => [
        'specs_images' => array_merge($nullable, $textField),
        'specs_summary' => array_merge($nullable, $textField),
    ],
    'specs_data' => [
        'data_value' => array_merge($nullable, $textField),
        'data_updated' => array_merge($nullable, $dateField),
    ],
    'specs_fields' => [
        'field_type' => array_merge($nullable, [
            'type' => 'ENUM',
            'constraint' => ['text','select','textarea'],
            'default' => 'text',
        ]),
        'field_class' => array_merge($nullable, $textField),
        'field_label_page' => array_merge($nullable, $textField),
        'field_value' => array_merge($nullable, $textField),
        'field_help' => array_merge($nullable, $textField),
    ],
    'specs_values' => [
        'value_content' => array_merge($nullable, $textField),
    ],
    'system_info' => [
        'sys_last_update' => array_merge($nullable, $dateField),
    ],
    'tour' => [
        'tour_images' => array_merge($nullable, $textField),
        'tour_summary' => array_merge($nullable, $textField),
    ],
    'tour_data' => [
        'data_value' => array_merge($nullable, $textField),
        'data_updated' => array_merge($nullable, $dateField),
    ],
    'tour_fields' => [
        'field_type' => array_merge($nullable, [
            'type' => 'ENUM',
            'constraint' => ['text','select','textarea'],
            'default' => 'text',
        ]),
        'field_class' => array_merge($nullable, $textField),
        'field_label_page' => array_merge($nullable, $textField),
        'field_value' => array_merge($nullable, $textField),
        'field_help' => array_merge($nullable, $textField),
    ],
    'tour_values' => [
        'value_content' => array_merge($nullable, $textField),
    ],
    'tour_decks' => [
        'deck_content' => array_merge($nullable, $textField),
    ],
    'uploads' => [
        'upload_filename' => array_merge($nullable, $textField),
    ],
    'user_loa' => [
        'loa_start_date' => array_merge($nullable, $dateField),
        'loa_end_date' => array_merge($nullable, $dateField),
        'loa_duration' => array_merge($nullable, $textField),
        'loa_reason' => array_merge($nullable, $textField),
    ],
    'user_prefs' => [
        'pref_default' => array_merge($nullable, $textField),
    ],
    'user_prefs_values' => [
        'prefvalue_value' => array_merge($nullable, $textField),
    ],
    'users' => [
        'instant_message' => array_merge($nullable, $textField),
        'main_char' => array_merge($nullable, $characterField),
        'access_role' => array_merge($nullable, ['type' => 'INT', 'constraint' => 5]),
        'join_date' => array_merge($nullable, $dateField),
        'leave_date' => array_merge($nullable, $dateField),
        'last_post' => array_merge($nullable, $dateField),
        'last_login' => array_merge($nullable, $dateField),
        'location' => array_merge($nullable, $textField),
        'interests' => array_merge($nullable, $textField),
        'bio' => array_merge($nullable, $textField),
        'my_links' => array_merge($nullable, $textField),
        'last_update' => array_merge($nullable, $dateField),
    ],
    'wiki_categories' => [
        'wikicat_desc' => array_merge($nullable, $textField),
    ],
    'wiki_comments' => [
        'wcomment_content' => array_merge($nullable, $textField),
    ],
    'wiki_drafts' => [
        'draft_id_old' => array_merge($nullable, ['type' => 'INT', 'constraint' => 10]),
        'draft_summary' => array_merge($nullable, $textField),
        'draft_content' => array_merge($nullable, $textField),
        'draft_categories' => array_merge($nullable, $textField),
        'draft_changed_comments' => array_merge($nullable, $textField),
    ],
    'wiki_pages' => [
        'page_updated_at' => array_merge($nullable, $dateField),
        'page_updated_by_user' => array_merge($nullable, $userField),
        'page_updated_by_character' => array_merge($nullable, $characterField),
    ],
    'wiki_restrictions' => [
        'restr_updated_at' => array_merge($nullable, $dateField),
        'restr_updated_by' => array_merge($nullable, $userField),
        'restrictions' => array_merge($nullable, $textField),
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

$insertSettingsData = [
    ['setting_key' => 'contact_form_enabled', 'setting_value' => 'y', 'setting_user_created' => 'n'],
];

foreach ($insertSettingsData as $settingsData) {
    $count = $this->db->where('setting_key', $settingsData['setting_key'])
        ->from('settings')
        ->count_all_results();

    if ($count === 0) {
        $this->db->insert('settings', $settingsData);
    }
}
