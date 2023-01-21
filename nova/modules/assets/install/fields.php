<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Database Schema
 *
 * @package		Nova
 * @category	Install
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

$user_id_type				= 'INT';
$user_id_constraint			= 8;
$character_id_type			= 'INT';
$character_id_constraint	= 8;
$date_type					= 'BIGINT';
$date_constraint			= 20;

/**
 * Master array with name, primary key and name of the array
 * that's used to insert the data into the database
 */
$data = [
    'access_groups' => [
        'id' => 'group_id',
        'fields' => 'fields_access_groups'
    ],
    'access_pages' => [
        'id' => 'page_id',
        'fields' => 'fields_access_pages'
    ],
    'access_roles' => [
        'id' => 'role_id',
        'fields' => 'fields_access_roles'
    ],
    'applications' => [
        'id' => 'app_id',
        'fields' => 'fields_applications'
    ],
    'awards' => [
        'id' => 'award_id',
        'fields' => 'fields_awards'
    ],
    'awards_queue' => [
        'id' => 'queue_id',
        'fields' => 'fields_awards_queue'
    ],
    'awards_received' => [
        'id' => 'awardrec_id',
        'fields' => 'fields_awards_received'
    ],
    'bans' => [
        'id' => 'ban_id',
        'fields' => 'fields_bans'
    ],
    'catalogue_ranks' => [
        'id' => 'rankcat_id',
        'fields' => 'fields_catalogue_ranks'
    ],
    'catalogue_skins' => [
        'id' => 'skin_id',
        'fields' => 'fields_catalogue_skins'
    ],
    'catalogue_skinsecs' => [
        'id' => 'skinsec_id',
        'fields' => 'fields_catalogue_skinsecs'
    ],
    'characters' => [
        'id' => 'charid',
        'fields' => 'fields_characters'
    ],
    'characters_data' => [
        'id' => 'data_id',
        'fields' => 'fields_characters_data'
    ],
    'characters_fields' => [
        'id' => 'field_id',
        'fields' => 'fields_characters_fields'
    ],
    'characters_promotions' => [
        'id' => 'prom_id',
        'fields' => 'fields_characters_promotions'
    ],
    'characters_sections' => [
        'id' => 'section_id',
        'fields' => 'fields_characters_sections'
    ],
    'characters_tabs' => [
        'id' => 'tab_id',
        'fields' => 'fields_characters_tabs'
    ],
    'characters_values' => [
        'id' => 'value_id',
        'fields' => 'fields_characters_values'
    ],
    'coc' => [
        'id' => 'coc_id',
        'fields' => 'fields_coc'
    ],
    'departments' => [
        'id' => 'dept_id',
        'fields' => 'fields_departments'
    ],
    'docking' => [
        'id' => 'docking_id',
        'fields' => 'fields_docking'
    ],
    'docking_data' => [
        'id' => 'data_id',
        'fields' => 'fields_docking_data'
    ],
    'docking_fields' => [
        'id' => 'field_id',
        'fields' => 'fields_docking_fields'
    ],
    'docking_sections' => [
        'id' => 'section_id',
        'fields' => 'fields_docking_sections'
    ],
    'docking_values' => [
        'id' => 'value_id',
        'fields' => 'fields_docking_values'
    ],
    'login_attempts' => [
        'id' => 'login_id',
        'fields' => 'fields_login_attempts'
    ],
    'manifests' => [
        'id' => 'manifest_id',
        'fields' => 'fields_manifests'
    ],
    'menu_categories' => [
        'id' => 'menucat_id',
        'fields' => 'fields_menu_categories'
    ],
    'menu_items' => [
        'id' => 'menu_id',
        'fields' => 'fields_menu_items'
    ],
    'messages' => [
        'id' => 'message_id',
        'fields' => 'fields_messages'
    ],
    'mission_groups' => [
        'id' => 'misgroup_id',
        'fields' => 'fields_mission_groups'
    ],
    'missions' => [
        'id' => 'mission_id',
        'fields' => 'fields_missions'
    ],
    'news' => [
        'id' => 'news_id',
        'fields' => 'fields_news'
    ],
    'news_categories' => [
        'id' => 'newscat_id',
        'fields' => 'fields_news_categories'
    ],
    'news_comments' => [
        'id' => 'ncomment_id',
        'fields' => 'fields_news_comments'
    ],
    'personallogs' => [
        'id' => 'log_id',
        'fields' => 'fields_personallogs'
    ],
    'personallogs_comments' => [
        'id' => 'lcomment_id',
        'fields' => 'fields_personallogs_comments'
    ],
    'positions' => [
        'id' => 'pos_id',
        'fields' => 'fields_positions'
    ],
    'posts' => [
        'id' => 'post_id',
        'fields' => 'fields_posts'
    ],
    'posts_comments' => [
        'id' => 'pcomment_id',
        'fields' => 'fields_posts_comments'
    ],
    'privmsgs' => [
        'id' => 'privmsgs_id',
        'fields' => 'fields_privmsgs'
    ],
    'privmsgs_to' => [
        'id' => 'pmto_id',
        'fields' => 'fields_privmsgs_to'
    ],
    'ranks' => [
        'id' => 'rank_id',
        'fields' => 'fields_ranks'
    ],
    'security_questions' => [
        'id' => 'question_id',
        'fields' => 'fields_security_questions'
    ],
    'settings' => [
        'id' => 'setting_id',
        'fields' => 'fields_settings'
    ],
    'sessions' => [
        'id' => 'id',
        'fields' => 'fields_sessions'
    ],
    'sim_type' => [
        'id' => 'simtype_id',
        'fields' => 'fields_sim_type'
    ],
    'specs' => [
        'id' => 'specs_id',
        'fields' => 'fields_specs'
    ],
    'specs_data' => [
        'id' => 'data_id',
        'fields' => 'fields_specs_data'
    ],
    'specs_fields' => [
        'id' => 'field_id',
        'fields' => 'fields_specs_fields'
    ],
    'specs_sections' => [
        'id' => 'section_id',
        'fields' => 'fields_specs_sections'
    ],
    'specs_values' => [
        'id' => 'value_id',
        'fields' => 'fields_specs_values'
    ],
    'system_info' => [
        'id' => 'sys_id',
        'fields' => 'fields_system_info'
    ],
    'tour' => [
        'id' => 'tour_id',
        'fields' => 'fields_tour'
    ],
    'tour_data' => [
        'id' => 'data_id',
        'fields' => 'fields_tour_data'
    ],
    'tour_fields' => [
        'id' => 'field_id',
        'fields' => 'fields_tour_fields'
    ],
    'tour_values' => [
        'id' => 'value_id',
        'fields' => 'fields_tour_values'
    ],
    'tour_decks' => [
        'id' => 'deck_id',
        'fields' => 'fields_tour_decks'
    ],
    'uploads' => [
        'id' => 'upload_id',
        'fields' => 'fields_uploads'
    ],
    'user_loa' => [
        'id' => 'loa_id',
        'fields' => 'fields_user_loa'
    ],
    'user_prefs' => [
        'id' => 'pref_id',
        'fields' => 'fields_user_prefs'
    ],
    'user_prefs_values' => [
        'id' => 'prefvalue_id',
        'fields' => 'fields_user_prefs_values'
    ],
    'users' => [
        'id' => 'userid',
        'fields' => 'fields_users'
    ],
    'wiki_categories' => [
        'id' => 'wikicat_id',
        'fields' => 'fields_wiki_categories'
    ],
    'wiki_comments' => [
        'id' => 'wcomment_id',
        'fields' => 'fields_wiki_comments'
    ],
    'wiki_drafts' => [
        'id' => 'draft_id',
        'fields' => 'fields_wiki_drafts'
    ],
    'wiki_pages' => [
        'id' => 'page_id',
        'fields' => 'fields_wiki_pages'
    ],
    'wiki_restrictions' => [
        'id' => 'restr_id',
        'fields' => 'fields_wiki_restrictions'
    ],
];

/**
 * Field arrays with all the data necessary to create the system
 */
$fields_access_groups = [
    'group_id' => [
        'type' => 'INT',
        'constraint' => 6,
        'auto_increment' => true,
    ],
    'group_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => '',
    ],
    'group_order' => [
        'type' => 'INT',
        'constraint' => 4,
        'default' => 99,
    ],
];

$fields_access_pages = [
    'page_id' => [
        'type' => 'INT',
        'constraint' => 6,
        'auto_increment' => true,
    ],
    'page_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => '',
    ],
    'page_url' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => '',
    ],
    'page_level' => [
        'type' => 'VARCHAR',
        'constraint' => 3,
        'default' => '',
    ],
    'page_group' => [
        'type' => 'INT',
        'constraint' => 6,
        'default' => 0,
    ],
    'page_desc' => [
        'type' => 'TEXT',
        'null' => true,
    ],
];

$fields_access_roles = [
    'role_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true,
    ],
    'role_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => '',
    ],
    'role_access' => [
        'type' => 'TEXT',
        'null' => true,
    ],
    'role_desc' => [
        'type' => 'TEXT',
        'null' => true,
    ],
];

$fields_applications = [
    'app_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true,
    ],
    'app_email' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => '',
    ],
    'app_ip' => [
        'type' => 'VARCHAR',
        'constraint' => 45,
        'default' => '',
    ],
    'app_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
    ],
    'app_user_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => '',
    ],
    'app_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint,
    ],
    'app_character_name' => [
        'type' => 'TEXT',
        'null' => true,
    ],
    'app_position' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => '',
    ],
    'app_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
    ],
    'app_action' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => '',
    ],
    'app_message' => [
        'type' => 'TEXT',
        'null' => true,
    ],
];

$fields_awards = [
    'award_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true,
    ],
    'award_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => '',
    ],
    'award_image' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => '',
    ],
    'award_order' => [
        'type' => 'INT',
        'constraint' => 5,
    ],
    'award_desc' => [
        'type' => 'TEXT',
        'null' => true,
    ],
    'award_cat' => [
        'type' => 'ENUM',
        'constraint' => ['ic', 'ooc', 'both'],
        'default' => 'ic',
    ],
    'award_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y',
    ],
];

$fields_awards_queue = [
    'queue_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true,
    ],
    'queue_receive_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint,
        'default' => 0,
    ],
    'queue_receive_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
    ],
    'queue_nominate' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint,
        'default' => 0,
    ],
    'queue_award' => [
        'type' => 'INT',
        'constraint' => 5,
    ],
    'queue_reason' => [
        'type' => 'TEXT',
        'null' => true,
    ],
    'queue_status' => [
        'type' => 'ENUM',
        'constraint' => ['pending','accepted','rejected'],
        'default' => 'pending',
    ],
    'queue_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
    ],
];

$fields_awards_received = [
    'awardrec_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true,
    ],
    'awardrec_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
    ],
    'awardrec_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint,
        'default' => 0,
    ],
    'awardrec_nominated_by' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint,
        'default' => 0,
    ],
    'awardrec_award' => [
        'type' => 'INT',
        'constraint' => 5,
    ],
    'awardrec_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
    ],
    'awardrec_reason' => [
        'type' => 'TEXT',
        'null' => true,
    ],
];

$fields_bans = [
    'ban_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true,
    ],
    'ban_level' => [
        'type' => 'INT',
        'constraint' => 1,
        'default' => 1,
    ],
    'ban_ip' => [
        'type' => 'VARCHAR',
        'constraint' => 45,
        'default' => '',
    ],
    'ban_email' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => '',
    ],
    'ban_reason' => [
        'type' => 'TEXT',
        'null' => true,
    ],
    'ban_date' => [
        'type' => $date_type,
        'constraint'=> $date_constraint,
    ],
];

$fields_catalogue_ranks = [
    'rankcat_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true,
    ],
    'rankcat_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => '',
    ],
    'rankcat_location' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => '',
    ],
    'rankcat_preview' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => 'preview.png',
    ],
    'rankcat_blank' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => 'blank.png',
    ],
    'rankcat_extension' => [
        'type' => 'VARCHAR',
        'constraint' => 5,
        'default' => '.png',
    ],
    'rankcat_status' => [
        'type' => 'ENUM',
        'constraint' => ['active','inactive','development'],
        'default' => 'active',
    ],
    'rankcat_credits' => [
        'type' => 'TEXT',
        'null' => true,
    ],
    'rankcat_url' => [
        'type' => 'TEXT',
        'null' => true,
    ],
    'rankcat_default' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n',
    ],
    'rankcat_genre' => [
        'type' => 'VARCHAR',
        'constraint' => 10,
        'default' => GENRE,
    ],
];

$fields_catalogue_skins = [
    'skin_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true,
    ],
    'skin_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => '',
    ],
    'skin_location' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => '',
    ],
    'skin_credits' => [
        'type' => 'TEXT',
        'null' => true,
    ],
];

$fields_catalogue_skinsecs = [
    'skinsec_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true,
    ],
    'skinsec_section' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => '',
    ],
    'skinsec_skin' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => '',
    ],
    'skinsec_image_preview' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => '',
    ],
    'skinsec_status' => [
        'type' => 'ENUM',
        'constraint' => ['active','inactive','development'],
        'default' => 'active',
    ],
    'skinsec_default' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n',
    ],
];

$fields_characters = [
    'charid' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint,
        'auto_increment' => true
    ],
    'user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
        'null' => true
    ],
    'first_name' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => ''
    ],
    'middle_name' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => ''
    ],
    'last_name' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => ''
    ],
    'suffix' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => ''
    ],
    'crew_type' => [
        'type' => 'ENUM',
        'constraint' => ['active','inactive','pending','npc'],
        'default' => 'active'
    ],
    'date_activate' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'date_deactivate' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'images' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'rank' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true
    ],
    'position_1' => [
        'type' => 'INT',
        'constraint' => 10,
        'default' => 1
    ],
    'position_2' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true
    ],
    'last_post' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
];

$fields_characters_data = [
    'data_id' => [
        'type' => 'BIGINT',
        'constraint' => 20,
        'auto_increment' => true
    ],
    'data_field' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'data_char' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'data_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
        'null' => true,
    ],
    'data_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'data_updated' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
];

$fields_characters_fields = [
    'field_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'field_type' => [
        'type' => 'ENUM',
        'constraint' => ['text','select','textarea'],
        'default' => 'TEXT',
        'null' => true
    ],
    'field_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'field_fid' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'field_class' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_label_page' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'field_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'field_rows' => [
        'type' => 'INT',
        'constraint' => 3,
        'default' => 5
    ],
    'field_section' => [
        'type' => 'INT',
        'constraint' => 8,
        'default' => 1
    ],
    'field_help' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_characters_promotions = [
    'prom_id' => [
        'type' => 'BIGINT',
        'constraint' => 20,
        'auto_increment' => true
    ],
    'prom_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
        'null' => true,
    ],
    'prom_char' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'prom_old_order' => [
        'type' => 'INT',
        'constraint' => 8
    ],
    'prom_old_rank' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'prom_new_order' => [
        'type' => 'INT',
        'constraint' => 8
    ],
    'prom_new_rank' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'prom_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
];

$fields_characters_sections = [
    'section_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'section_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'section_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'section_tab' => [
        'type' => 'INT',
        'constraint' => 5,
        'default' => 1
    ],
];

$fields_characters_tabs = [
    'tab_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'tab_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'tab_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'tab_link_id' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => 'one'
    ],
    'tab_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
];

$fields_characters_values = [
    'value_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'value_field' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'value_field_value' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'value_selected' => [
        'type' => 'VARCHAR',
        'constraint' => 10,
        'default' => ''
    ],
    'value_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'value_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
];

$fields_coc = [
    'coc_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'coc_crew' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'coc_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
];

$fields_departments = [
    'dept_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'dept_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'dept_desc' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'dept_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'dept_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'dept_type' => [
        'type' => 'ENUM',
        'constraint' => ['playing','nonplaying'],
        'default' => 'playing'
    ],
    'dept_parent' => [
        'type' => 'INT',
        'constraint' => 10,
        'default' => 0
    ],
    'dept_manifest' => [
        'type' => 'INT',
        'constraint' => 5,
        'default' => 0
    ],
];

$fields_docking = [
    'docking_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'docking_sim_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'docking_sim_url' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'docking_gm_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'docking_gm_email' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'docking_status' => [
        'type' => 'ENUM',
        'constraint' => ['active','inactive','pending'],
        'default' => 'pending'
    ],
    'docking_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
];

$fields_docking_data = [
    'data_id' => [
        'type' => 'BIGINT',
        'constraint' => 20,
        'auto_increment' => true
    ],
    'data_docking_item' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'data_field' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'data_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'data_updated' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
];

$fields_docking_fields = [
    'field_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'field_type' => [
        'type' => 'ENUM',
        'constraint' => ['text','select','textarea'],
        'default' => 'TEXT',
        'null' => true
    ],
    'field_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'field_fid' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'field_class' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_label_page' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_selected' => [
        'type' => 'VARCHAR',
        'constraint' => 20,
        'default' => ''
    ],
    'field_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'field_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'field_rows' => [
        'type' => 'INT',
        'constraint' => 3,
        'default' => 5
    ],
    'field_section' => [
        'type' => 'INT',
        'constraint' => 8,
        'default' => 1
    ],
    'field_help' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_docking_sections = [
    'section_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'section_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'section_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
];

$fields_docking_values = [
    'value_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'value_field' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'value_field_value' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'value_selected' => [
        'type' => 'VARCHAR',
        'constraint' => 10,
        'default' => ''
    ],
    'value_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'value_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
];

$fields_login_attempts = [
    'login_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'login_ip' => [
        'type' => 'VARCHAR',
        'constraint' => 45,
        'default' => ''
    ],
    'login_email' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'login_time' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'default' => 0
    ],
];

$fields_manifests = [
    'manifest_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'manifest_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'manifest_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'manifest_desc' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'manifest_header_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'manifest_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'manifest_default' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'manifest_view' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'manifest_metadata' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_menu_categories = [
    'menucat_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'menucat_order' => [
        'type' => 'INT',
        'constraint' => 5,
        'default' => 1
    ],
    'menucat_menu_cat' => [
        'type' => 'VARCHAR',
        'constraint' => 20,
        'default' => ''
    ],
    'menucat_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'menucat_type' => [
        'type' => 'ENUM',
        'constraint' => ['sub','adminsub'],
        'default' => 'sub'
    ],
];

$fields_menu_items = [
    'menu_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'menu_name' => [
        'type' => 'VARCHAR',
        'constraint' => 150,
        'default' => ''
    ],
    'menu_group' => [
        'type' => 'INT',
        'constraint' => 4
    ],
    'menu_order' => [
        'type' => 'INT',
        'constraint' => 4
    ],
    'menu_link' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'menu_link_type' => [
        'type' => 'ENUM',
        'constraint' => ['onsite','offsite'],
        'default' => 'onsite'
    ],
    'menu_need_login' => [
        'type' => 'ENUM',
        'constraint' => ['y','n','none'],
        'default' => 'none'
    ],
    'menu_use_access' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'menu_access' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'menu_access_level' => [
        'type' => 'INT',
        'constraint' => 4,
        'default' => '0'
    ],
    'menu_type' => [
        'type' => 'ENUM',
        'constraint' => ['main','sub','adminsub'],
        'default' => 'main'
    ],
    'menu_cat' => [
        'type' => 'VARCHAR',
        'constraint' => 20,
        'default' => ''
    ],
    'menu_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'menu_sim_type' => [
        'type' => 'INT',
        'constraint' => 5
    ],
];

$fields_messages = [
    'message_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'message_key' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'message_label' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'message_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'message_type' => [
        'type' => 'ENUM',
        'constraint' => ['title','message','other'],
        'default' => 'message'
    ],
    'message_protected' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
];

$fields_mission_groups = [
    'misgroup_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'misgroup_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'misgroup_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'misgroup_desc' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'misgroup_parent' => [
        'type' => 'INT',
        'constraint' => 5,
        'default' => 0
    ],
];

$fields_missions = [
    'mission_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'mission_title' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'mission_images' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'mission_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'mission_group' => [
        'type' => 'INT',
        'constraint' => 5,
        'null' => true
    ],
    'mission_status' => [
        'type' => 'ENUM',
        'constraint' => ['upcoming','current','completed'],
        'default' => 'upcoming'
    ],
    'mission_start' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'mission_end' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'mission_desc' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'mission_summary' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'mission_notes' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'mission_notes_updated' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
];

$fields_news = [
    'news_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'news_title' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'news_author_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'news_author_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'news_cat' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'news_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'news_content' => [
        'type' => 'LONGTEXT',
        'null' => true,
    ],
    'news_status' => [
        'type' => 'ENUM',
        'constraint' => ['activated','saved','pending'],
        'default' => 'activated'
    ],
    'news_private' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'news_tags' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'news_last_update' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'default' => 0
    ],
];

$fields_news_categories = [
    'newscat_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'newscat_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'newscat_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
];

$fields_news_comments = [
    'ncomment_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'ncomment_author_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'ncomment_author_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'ncomment_news' => [
        'type' => 'INT',
        'constraint' => 8
    ],
    'ncomment_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'ncomment_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'ncomment_status' => [
        'type' => 'ENUM',
        'constraint' => ['activated','pending'],
        'default' => 'activated'
    ],
];

$fields_personallogs = [
    'log_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'log_title' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'log_author_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'log_author_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'log_content' => [
        'type' => 'LONGTEXT',
        'null' => true,
    ],
    'log_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'log_status' => [
        'type' => 'ENUM',
        'constraint' => ['activated','saved','pending'],
        'default' => 'activated'
    ],
    'log_tags' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'log_last_update' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'default' => 0
    ],
    'log_words' => [
        'type' => 'BIGINT',
        'constraint' => 8,
        'default' => 0,
    ],
];

$fields_personallogs_comments = [
    'lcomment_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'lcomment_author_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'lcomment_author_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'lcomment_log' => [
        'type' => 'INT',
        'constraint' => 8
    ],
    'lcomment_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'lcomment_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'lcomment_status' => [
        'type' => 'ENUM',
        'constraint' => ['activated','pending'],
        'default' => 'activated'
    ],
];

$fields_positions = [
    'pos_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'pos_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'pos_desc' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'pos_dept' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'pos_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'pos_open' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'pos_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'pos_type' => [
        'type' => 'ENUM',
        'constraint' => ['senior','officer','enlisted','other'],
        'default' => 'officer'
    ],
    'pos_top_open' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
];

$fields_posts = [
    'post_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'post_title' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'post_location' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'post_timeline' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'post_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'post_authors' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'post_authors_users' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'post_mission' => [
        'type' => 'INT',
        'constraint' => 8
    ],
    'post_saved' => [
        'type' => $user_id_type,
        'constriant' => $user_id_constraint,
        'null' => true
    ],
    'post_status' => [
        'type' => 'ENUM',
        'constraint' => ['activated','saved','pending'],
        'default' => 'activated'
    ],
    'post_content' => [
        'type' => 'LONGTEXT',
        'null' => true,
    ],
    'post_tags' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'post_last_update' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'default' => 0
    ],
    'post_participants' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'post_lock_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
        'null' => true
    ],
    'post_lock_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'post_words' => [
        'type' => 'BIGINT',
        'constraint' => 8,
        'default' => 0,
    ],
];

$fields_posts_comments = [
    'pcomment_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'pcomment_author_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'pcomment_author_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'pcomment_post' => [
        'type' => 'INT',
        'constraint' => 8
    ],
    'pcomment_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'pcomment_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'pcomment_status' => [
        'type' => 'ENUM',
        'constraint' => ['activated','pending'],
        'default' => 'activated'
    ],
];

$fields_privmsgs = [
    'privmsgs_id' => [
        'type' => 'BIGINT',
        'constraint' => 20,
        'auto_increment' => true
    ],
    'privmsgs_author_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'privmsgs_author_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'privmsgs_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'privmsgs_subject' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'privmsgs_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'privmsgs_author_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
];

$fields_privmsgs_to = [
    'pmto_id' => [
        'type' => 'BIGINT',
        'constraint' => 20,
        'auto_increment' => true
    ],
    'pmto_message' => [
        'type' => 'BIGINT',
        'constraint' => 20
    ],
    'pmto_recipient_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'pmto_recipient_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'pmto_unread' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'pmto_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
];

$fields_ranks = [
    'rank_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'rank_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'rank_short_name' => [
        'type' => 'VARCHAR',
        'constraint' => 20,
        'default' => ''
    ],
    'rank_image' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'rank_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'rank_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'rank_class' => [
        'type' => 'INT',
        'constraint' => 5,
        'default' => 1
    ],
];

$fields_security_questions = [
    'question_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'question_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_settings = [
    'setting_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'setting_key' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'setting_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'setting_label' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'setting_user_created' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
];

$fields_sessions = [
    'id' => [
        'type' => 'VARCHAR',
        'constraint' => 128
    ],
    'ip_address' => [
        'type' => 'VARCHAR',
        'constraint' => 45
    ],
    'timestamp' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
        'default' => 0
    ],
    'data' => [
        'type' => 'BLOB'
    ],
];

$fields_sim_type = [
    'simtype_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'simtype_name' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => ''
    ],
];

$fields_specs = [
    'specs_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'specs_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'specs_order' => [
        'type' => 'INT',
        'constraint' => 4
    ],
    'specs_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'specs_images' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'specs_summary' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_specs_data = [
    'data_id' => [
        'type' => 'BIGINT',
        'constraint' => 20,
        'auto_increment' => true
    ],
    'data_item' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'data_field' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'data_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'data_updated' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
];

$fields_specs_fields = [
    'field_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'field_type' => [
        'type' => 'ENUM',
        'constraint' => ['text','select','textarea'],
        'default' => 'TEXT',
        'null' => true
    ],
    'field_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'field_fid' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'field_class' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_label_page' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_selected' => [
        'type' => 'VARCHAR',
        'constraint' => 20,
        'default' => ''
    ],
    'field_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'field_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'field_rows' => [
        'type' => 'INT',
        'constraint' => 3,
        'default' => 5
    ],
    'field_section' => [
        'type' => 'INT',
        'constraint' => 8,
        'default' => 1
    ],
    'field_help' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_specs_sections = [
    'section_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'section_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'section_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
];

$fields_specs_values = [
    'value_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'value_field' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'value_type' => [
        'type' => 'ENUM',
        'constraint' => ['option'],
        'default' => 'option'
    ],
    'value_field_value' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'value_selected' => [
        'type' => 'VARCHAR',
        'constraint' => 10,
        'default' => ''
    ],
    'value_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'value_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
];

$fields_system_info = [
    'sys_id' => [
        'type' => 'INT',
        'constraint' => 4,
        'auto_increment' => true
    ],
    'sys_uid' => [
        'type' => 'VARCHAR',
        'constraint' => 32,
        'default' => ''
    ],
    'sys_install_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'sys_last_update' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'sys_version_major' => [
        'type' => 'INT',
        'constraint' => 1
    ],
    'sys_version_minor' => [
        'type' => 'INT',
        'constraint' => 2
    ],
    'sys_version_update' => [
        'type' => 'INT',
        'constraint' => 4
    ],
    'sys_version_ignore' => [
        'type' => 'VARCHAR',
        'constraint' => 20,
        'default' => ''
    ],
];

$fields_tour = [
    'tour_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'tour_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'tour_order' => [
        'type' => 'INT',
        'constraint' => 4
    ],
    'tour_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'tour_images' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'tour_summary' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'tour_spec_item' => [
        'type' => 'INT',
        'constraint' => 5
    ],
];

$fields_tour_data = [
    'data_id' => [
        'type' => 'BIGINT',
        'constraint' => 20,
        'auto_increment' => true
    ],
    'data_tour_item' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'data_field' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'data_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'data_updated' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
];

$fields_tour_fields = [
    'field_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'field_type' => [
        'type' => 'ENUM',
        'constraint' => ['text','select','textarea'],
        'default' => 'TEXT',
        'null' => true
    ],
    'field_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'field_fid' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'field_class' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_label_page' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'field_selected' => [
        'type' => 'VARCHAR',
        'constraint' => 20,
        'default' => ''
    ],
    'field_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
    'field_display' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'field_rows' => [
        'type' => 'INT',
        'constraint' => 3,
        'default' => 5
    ],
    'field_help' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_tour_values = [
    'value_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'value_field' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'value_field_value' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'value_selected' => [
        'type' => 'VARCHAR',
        'constraint' => 10,
        'default' => ''
    ],
    'value_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'value_order' => [
        'type' => 'INT',
        'constraint' => 5
    ],
];

$fields_tour_decks = [
    'deck_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'deck_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'deck_order' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'deck_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'deck_item' => [
        'type' => 'INT',
        'constraint' => 5,
        'default' => 0
    ],
];

$fields_uploads = [
    'upload_id' => [
        'type' => 'BIGINT',
        'constraint' => 20,
        'auto_increment' => true
    ],
    'upload_filename' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'upload_mime_type' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'upload_resource_type' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'upload_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'upload_ip' => [
        'type' => 'VARCHAR',
        'constraint' => 45,
        'default' => ''
    ],
    'upload_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
];

$fields_user_loa = [
    'loa_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'loa_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'loa_start_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true,
    ],
    'loa_end_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true,
    ],
    'loa_duration' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'loa_reason' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'loa_type' => [
        'type' => 'ENUM',
        'constraint' => ['active','loa','eloa'],
        'default' => 'loa'
    ],
];

$fields_user_prefs = [
    'pref_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'pref_key' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'pref_label' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'pref_default' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_user_prefs_values = [
    'prefvalue_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'auto_increment' => true
    ],
    'prefvalue_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'prefvalue_key' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'prefvalue_value' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_users = [
    'userid' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
        'auto_increment' => true
    ],
    'status' => [
        'type' => 'ENUM',
        'constraint' => ['active','inactive','pending'],
        'default' => 'active'
    ],
    'name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'email' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'password' => [
        'type' => 'VARCHAR',
        'constraint' => 40,
        'default' => ''
    ],
    'date_of_birth' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => ''
    ],
    'instant_message' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'main_char' => [
        'type' => 'INT',
        'constraint' => 5,
        'null' => true
    ],
    'access_role' => [
        'type' => 'INT',
        'constraint' => 5,
        'null' => true
    ],
    'is_sysadmin' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'is_game_master' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'is_webmaster' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'is_firstlaunch' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'y'
    ],
    'timezone' => [
        'type' => 'VARCHAR',
        'constraint' => 5,
        'default' => 'UTC'
    ],
    'daylight_savings' => [
        'type' => 'VARCHAR',
        'constraint' => 1,
        'default' => '0'
    ],
    'language' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => 'english'
    ],
    'join_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'leave_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'last_post' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'last_login' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'loa' => [
        'type' => 'ENUM',
        'constraint' => ['active','loa','eloa'],
        'default' => 'active'
    ],
    'display_rank' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => 'default'
    ],
    'skin_main' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => 'default'
    ],
    'skin_wiki' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => 'default'
    ],
    'skin_admin' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => 'default'
    ],
    'location' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'interests' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'bio' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'security_question' => [
        'type' => 'INT',
        'constraint' => 5,
        'default' => 1
    ],
    'security_answer' => [
        'type' => 'VARCHAR',
        'constraint' => 40,
        'default' => ''
    ],
    'password_reset' => [
        'type' => 'INT',
        'constraint' => 1,
        'default' => 0
    ],
    'moderate_posts' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'moderate_logs' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'moderate_news' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'moderate_post_comments' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'moderate_log_comments' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'moderate_news_comments' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'moderate_wiki_comments' => [
        'type' => 'ENUM',
        'constraint' => ['y','n'],
        'default' => 'n'
    ],
    'my_links' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'last_update' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
];

$fields_wiki_categories = [
    'wikicat_id' => [
        'type' => 'INT',
        'constraint' => 8,
        'auto_increment' => true
    ],
    'wikicat_name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
    'wikicat_desc' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_wiki_comments = [
    'wcomment_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'wcomment_author_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'wcomment_author_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'wcomment_page' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'wcomment_date' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'wcomment_content' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'wcomment_status' => [
        'type' => 'ENUM',
        'constraint' => ['activated','pending'],
        'default' => 'activated'
    ],
];

$fields_wiki_drafts = [
    'draft_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'draft_id_old' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true
    ],
    'draft_title' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => ''
    ],
    'draft_author_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'draft_author_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'draft_summary' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'draft_content' => [
        'type' => 'LONGTEXT',
        'null' => true,
    ],
    'draft_page' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'draft_created_at' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'draft_categories' => [
        'type' => 'TEXT',
        'null' => true
    ],
    'draft_changed_comments' => [
        'type' => 'TEXT',
        'null' => true
    ],
];

$fields_wiki_pages = [
    'page_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'page_draft' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'page_created_at' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'page_created_by_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'page_created_by_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint
    ],
    'page_updated_at' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'page_updated_by_user' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
        'null' => true
    ],
    'page_updated_by_character' => [
        'type' => $character_id_type,
        'constraint' => $character_id_constraint,
        'null' => true
    ],
    'page_comments' => [
        'type' => 'ENUM',
        'constraint' => ['open','closed'],
        'default' => 'open'
    ],
    'page_type' => [
        'type' => 'ENUM',
        'constraint' => ['standard','system'],
        'default' => 'standard'
    ],
    'page_key' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'default' => ''
    ],
];

$fields_wiki_restrictions = [
    'restr_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'auto_increment' => true
    ],
    'restr_page' => [
        'type' => 'INT',
        'constraint' => 10
    ],
    'restr_created_at' => [
        'type' => $date_type,
        'constraint' => $date_constraint
    ],
    'restr_created_by' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint
    ],
    'restr_updated_at' => [
        'type' => $date_type,
        'constraint' => $date_constraint,
        'null' => true
    ],
    'restr_updated_by' => [
        'type' => $user_id_type,
        'constraint' => $user_id_constraint,
        'null' => true
    ],
    'restrictions' => [
        'type' => 'TEXT',
        'null' => true
    ],
];
