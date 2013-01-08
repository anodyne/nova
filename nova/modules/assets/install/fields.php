<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
$data = array(
	'access_groups'				=> array('id' => 'group_id', 'fields' => 'fields_access_groups'),
	'access_pages'				=> array('id' => 'page_id', 'fields' => 'fields_access_pages'),
	'access_roles'				=> array('id' => 'role_id', 'fields' => 'fields_access_roles'),
	'applications'				=> array('id' => 'app_id', 'fields' => 'fields_applications'),
	'awards'					=> array('id' => 'award_id', 'fields' => 'fields_awards'),
	'awards_queue'				=> array('id' => 'queue_id', 'fields' => 'fields_awards_queue'),
	'awards_received'			=> array('id' => 'awardrec_id', 'fields' => 'fields_awards_received'),
	'bans'						=> array('id' => 'ban_id', 'fields' => 'fields_bans'),
	'catalogue_ranks'			=> array('id' => 'rankcat_id', 'fields' => 'fields_catalogue_ranks'),
	'catalogue_skins'			=> array('id' => 'skin_id', 'fields' => 'fields_catalogue_skins'),
	'catalogue_skinsecs'		=> array('id' => 'skinsec_id', 'fields' => 'fields_catalogue_skinsecs'),
	'characters'				=> array('id' => 'charid', 'fields' => 'fields_characters'),
	'characters_data'			=> array('id' => 'data_id', 'fields' => 'fields_characters_data'),
	'characters_fields'			=> array('id' => 'field_id', 'fields' => 'fields_characters_fields'),
	'characters_promotions'		=> array('id' => 'prom_id', 'fields' => 'fields_characters_promotions'),
	'characters_sections'		=> array('id' => 'section_id', 'fields' => 'fields_characters_sections'),
	'characters_tabs'			=> array('id' => 'tab_id', 'fields' => 'fields_characters_tabs'),
	'characters_values'			=> array('id' => 'value_id', 'fields' => 'fields_characters_values'),
	'coc'						=> array('id' => 'coc_id', 'fields' => 'fields_coc'),
	'departments_'.	GENRE		=> array('id' => 'dept_id', 'fields' => 'fields_departments'),
	'docking'					=> array('id' => 'docking_id', 'fields' => 'fields_docking'),
	'docking_data'				=> array('id' => 'data_id', 'fields' => 'fields_docking_data'),
	'docking_fields'			=> array('id' => 'field_id', 'fields' => 'fields_docking_fields'),
	'docking_sections'			=> array('id' => 'section_id', 'fields' => 'fields_docking_sections'),
	'docking_values'			=> array('id' => 'value_id', 'fields' => 'fields_docking_values'),
	'login_attempts'			=> array('id' => 'login_id', 'fields' => 'fields_login_attempts'),
	'manifests'					=> array('id' => 'manifest_id', 'fields' => 'fields_manifests'),
	'menu_categories'			=> array('id' => 'menucat_id', 'fields' => 'fields_menu_categories'),
	'menu_items'				=> array('id' => 'menu_id', 'fields' => 'fields_menu_items'),
	'messages'					=> array('id' => 'message_id', 'fields' => 'fields_messages'),
	'mission_groups'			=> array('id' => 'misgroup_id', 'fields' => 'fields_mission_groups'),
	'missions'					=> array('id' => 'mission_id', 'fields' => 'fields_missions'),
	'news'						=> array('id' => 'news_id', 'fields' => 'fields_news'),
	'news_categories'			=> array('id' => 'newscat_id', 'fields' => 'fields_news_categories'),
	'news_comments'				=> array('id' => 'ncomment_id', 'fields' => 'fields_news_comments'),
	'personallogs'				=> array('id' => 'log_id', 'fields' => 'fields_personallogs'),
	'personallogs_comments'		=> array('id' => 'lcomment_id', 'fields' => 'fields_personallogs_comments'),
	'positions_'. GENRE			=> array('id' => 'pos_id', 'fields' => 'fields_positions'),
	'posts'						=> array('id' => 'post_id', 'fields' => 'fields_posts'),
	'posts_comments'			=> array('id' => 'pcomment_id', 'fields' => 'fields_posts_comments'),
	'privmsgs'					=> array('id' => 'privmsgs_id', 'fields' => 'fields_privmsgs'),
	'privmsgs_to'				=> array('id' => 'pmto_id', 'fields' => 'fields_privmsgs_to'),
	'ranks_'. GENRE				=> array('id' => 'rank_id', 'fields' => 'fields_ranks'),
	'security_questions'		=> array('id' => 'question_id', 'fields' => 'fields_security_questions'),	
	'settings'					=> array('id' => 'setting_id', 'fields' => 'fields_settings'),
	'sessions'					=> array('id' => 'session_id', 'fields' => 'fields_sessions'),
	'sim_type'					=> array('id' => 'simtype_id', 'fields' => 'fields_sim_type'),
	'specs'						=> array('id' => 'specs_id', 'fields' => 'fields_specs'),
	'specs_data'				=> array('id' => 'data_id', 'fields' => 'fields_specs_data'),
	'specs_fields'				=> array('id' => 'field_id', 'fields' => 'fields_specs_fields'),
	'specs_sections'			=> array('id' => 'section_id', 'fields' => 'fields_specs_sections'),
	'specs_values'				=> array('id' => 'value_id', 'fields' => 'fields_specs_values'),
	'system_info'				=> array('id' => 'sys_id', 'fields' => 'fields_system_info'),
	'tour'						=> array('id' => 'tour_id', 'fields' => 'fields_tour'),
	'tour_data'					=> array('id' => 'data_id', 'fields' => 'fields_tour_data'),
	'tour_fields'				=> array('id' => 'field_id', 'fields' => 'fields_tour_fields'),
	'tour_values'				=> array('id' => 'value_id', 'fields' => 'fields_tour_values'),
	'tour_decks'				=> array('id' => 'deck_id', 'fields' => 'fields_tour_decks'),
	'uploads'					=> array('id' => 'upload_id', 'fields' => 'fields_uploads'),
	'user_loa'					=> array('id' => 'loa_id', 'fields' => 'fields_user_loa'),
	'user_prefs'				=> array('id' => 'pref_id', 'fields' => 'fields_user_prefs'),
	'user_prefs_values'			=> array('id' => 'prefvalue_id', 'fields' => 'fields_user_prefs_values'),
	'users'						=> array('id' => 'userid', 'fields' => 'fields_users'),
	'wiki_categories'			=> array('id' => 'wikicat_id', 'fields' => 'fields_wiki_categories'),
	'wiki_comments'				=> array('id' => 'wcomment_id', 'fields' => 'fields_wiki_comments'),
	'wiki_drafts'				=> array('id' => 'draft_id', 'fields' => 'fields_wiki_drafts'),
	'wiki_pages'				=> array('id' => 'page_id', 'fields' => 'fields_wiki_pages'),
	'wiki_restrictions'			=> array('id' => 'restr_id', 'fields' => 'fields_wiki_restrictions'),
);

/**
 * Field arrays with all th edata necessary to create the system
 */
$fields_access_groups = array(
	'group_id' => array(
		'type' => 'INT',
		'constraint' => 6,
		'auto_increment' => TRUE),
	'group_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'group_order' => array(
		'type' => 'INT',
		'constraint' => 4,
		'default' => '99')
);

$fields_access_pages = array(
	'page_id' => array(
		'type' => 'INT',
		'constraint' => 6,
		'auto_increment' => TRUE),
	'page_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'page_url' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'page_level' => array(
		'type' => 'VARCHAR',
		'constraint' => 3,
		'default' => ''),
	'page_group' => array(
		'type' => 'INT',
		'constraint' => 6,
		'default' => '0'),
	'page_desc' => array(
		'type' => 'TEXT'),
);

$fields_access_roles = array(
	'role_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'role_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'role_access' => array(
		'type' => 'TEXT'),
	'role_desc' => array(
		'type' => 'TEXT'),
);

$fields_applications = array(
	'app_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'app_email' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'app_ip' => array(
		'type' => 'VARCHAR',
		'constraint' => 45,
		'default' => ''),
	'app_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'app_user_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'app_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'app_character_name' => array(
		'type' => 'TEXT'),
	'app_position' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'app_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'app_action' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'app_message' => array(
		'type' => 'TEXT')
);

$fields_awards = array(
	'award_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'award_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'award_image' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'award_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'award_desc' => array(
		'type' => 'TEXT'),
	'award_cat' => array(
		'type' => 'ENUM',
		'constraint' => "'ic','ooc','both'",
		'default' => 'ic'),
	'award_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y')
);

$fields_awards_queue = array(
	'queue_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'queue_receive_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'queue_receive_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'queue_nominate' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'queue_award' => array(
		'type' => 'INT',
		'constraint' => 5),
	'queue_reason' => array(
		'type' => 'TEXT'),
	'queue_status' => array(
		'type' => 'ENUM',
		'constraint' => "'pending','accepted','rejected'",
		'default' => 'pending'),
	'queue_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint)
);

$fields_awards_received = array(
	'awardrec_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'awardrec_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'awardrec_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint,
		'default' => 0),
	'awardrec_nominated_by' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint,
		'default' => 0),
	'awardrec_award' => array(
		'type' => 'INT',
		'constraint' => 5),
	'awardrec_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'awardrec_reason' => array(
		'type' => 'TEXT')
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
		'constraint' => 45,
		'default' => ''),
	'ban_email' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'ban_reason' => array(
		'type' => 'TEXT'),
	'ban_date' => array(
		'type' => $date_type,
		'constraint'=> $date_constraint),
);

$fields_catalogue_ranks = array(
	'rankcat_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'rankcat_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'rankcat_location' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'rankcat_preview' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => 'preview.png'),
	'rankcat_blank' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => 'blank.png'),
	'rankcat_extension' => array(
		'type' => 'VARCHAR',
		'constraint' => 5,
		'default' => '.png'),
	'rankcat_status' => array(
		'type' => 'ENUM',
		'constraint' => "'active','inactive','development'",
		'default' => 'active'),
	'rankcat_credits' => array(
		'type' => 'TEXT'),
	'rankcat_url' => array(
		'type' => 'TEXT'),
	'rankcat_default' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'rankcat_genre' => array(
		'type' => 'VARCHAR',
		'constraint' => 10,
		'default' => GENRE),
);

$fields_catalogue_skins = array(
	'skin_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'skin_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'skin_location' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'skin_credits' => array(
		'type' => 'TEXT')
);

$fields_catalogue_skinsecs = array(
	'skinsec_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'skinsec_section' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => ''),
	'skinsec_skin' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'skinsec_image_preview' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => ''),
	'skinsec_status' => array(
		'type' => 'ENUM',
		'constraint' => "'active','inactive','development'",
		'default' => 'active'),
	'skinsec_default' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n')
);

$fields_characters = array(
	'charid' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint,
		'auto_increment' => TRUE),
	'user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'first_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => ''),
	'middle_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => ''),
	'last_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => ''),
	'suffix' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => ''),
	'crew_type' => array(
		'type' => 'ENUM',
		'constraint' => "'active','inactive','pending','npc'",
		'default' => 'active'),
	'date_activate' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'date_deactivate' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'images' => array(
		'type' => 'TEXT'),
	'rank' => array(
		'type' => 'INT',
		'constraint' => 10),
	'position_1' => array(
		'type' => 'INT',
		'constraint' => 10,
		'default' => 1),
	'position_2' => array(
		'type' => 'INT',
		'constraint' => 10),
	'last_post' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
);

$fields_characters_data = array(
	'data_id' => array(
		'type' => 'BIGINT',
		'constraint' => 20,
		'auto_increment' => TRUE),
	'data_field' => array(
		'type' => 'INT',
		'constraint' => 10),
	'data_char' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'data_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'data_value' => array(
		'type' => 'TEXT'),
	'data_updated' => array(
		'type' => $date_type,
		'constraint' => $date_constraint)
);

$fields_characters_fields = array(
	'field_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'field_type' => array(
		'type' => 'ENUM',
		'constraint' => "'text','select','textarea'",
		'default' => 'text'),
	'field_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'field_fid' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'field_class' => array(
		'type' => 'TEXT'),
	'field_label_page' => array(
		'type' => 'TEXT'),
	'field_value' => array(
		'type' => 'TEXT'),
	'field_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'field_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'field_rows' => array(
		'type' => 'INT',
		'constraint' => 3,
		'default' => 5),
	'field_section' => array(
		'type' => 'INT',
		'constraint' => 8,
		'default' => 1)
);

$fields_characters_promotions = array(
	'prom_id' => array(
		'type' => 'BIGINT',
		'constraint' => 20,
		'auto_increment' => TRUE),
	'prom_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'prom_char' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'prom_old_order' => array(
		'type' => 'INT',
		'constraint' => 8),
	'prom_old_rank' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'prom_new_order' => array(
		'type' => 'INT',
		'constraint' => 8),
	'prom_new_rank' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'prom_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint)
);

$fields_characters_sections = array(
	'section_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'section_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'section_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'section_tab' => array(
		'type' => 'INT',
		'constraint' => 5,
		'default' => 1)
);

$fields_characters_tabs = array(
	'tab_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'tab_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'tab_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'tab_link_id' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => 'one'),
	'tab_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y')
);

$fields_characters_values = array(
	'value_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'value_field' => array(
		'type' => 'INT',
		'constraint' => 10),
	'value_field_value' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'value_selected' => array(
		'type' => 'VARCHAR',
		'constraint' => 10,
		'default' => ''),
	'value_content' => array(
		'type' => 'TEXT'),
	'value_order' => array(
		'type' => 'INT',
		'constraint' => 5)
);

$fields_coc = array(
	'coc_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'coc_crew' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'coc_order' => array(
		'type' => 'INT',
		'constraint' => 5)
);

$fields_departments = array(
	'dept_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'dept_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'dept_desc' => array(
		'type' => 'TEXT'),
	'dept_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'dept_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'dept_type' => array(
		'type' => 'ENUM',
		'constraint' => "'playing','nonplaying'",
		'default' => 'playing'),
	'dept_parent' => array(
		'type' => 'INT',
		'constraint' => 10,
		'default' => 0),
	'dept_manifest' => array(
		'type' => 'INT',
		'constraint' => 5,
		'default' => 0),
);

$fields_docking = array(
	'docking_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'docking_sim_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'docking_sim_url' => array(
		'type' => 'TEXT'),
	'docking_gm_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'docking_gm_email' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'docking_status' => array(
		'type' => 'ENUM',
		'constraint' => "'active','inactive','pending'",
		'default' => 'pending'),
	'docking_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint)
);

$fields_docking_data = array(
	'data_id' => array(
		'type' => 'BIGINT',
		'constraint' => 20,
		'auto_increment' => TRUE),
	'data_docking_item' => array(
		'type' => 'INT',
		'constraint' => 5),
	'data_field' => array(
		'type' => 'INT',
		'constraint' => 10),
	'data_value' => array(
		'type' => 'TEXT'),
	'data_updated' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
);

$fields_docking_fields = array(
	'field_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'field_type' => array(
		'type' => 'ENUM',
		'constraint' => "'text','select','textarea'",
		'default' => 'text'),
	'field_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'field_fid' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'field_class' => array(
		'type' => 'TEXT'),
	'field_label_page' => array(
		'type' => 'TEXT'),
	'field_value' => array(
		'type' => 'TEXT'),
	'field_selected' => array(
		'type' => 'VARCHAR',
		'constraint' => 20,
		'default' => ''),
	'field_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'field_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'field_rows' => array(
		'type' => 'INT',
		'constraint' => 3,
		'default' => 5),
	'field_section' => array(
		'type' => 'INT',
		'constraint' => 8,
		'default' => 1),
);

$fields_docking_sections = array(
	'section_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'section_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'section_order' => array(
		'type' => 'INT',
		'constraint' => 5)
);

$fields_docking_values = array(
	'value_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'value_field' => array(
		'type' => 'INT',
		'constraint' => 10),
	'value_field_value' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'value_selected' => array(
		'type' => 'VARCHAR',
		'constraint' => 10,
		'default' => ''),
	'value_content' => array(
		'type' => 'TEXT'),
	'value_order' => array(
		'type' => 'INT',
		'constraint' => 5)
);

$fields_login_attempts = array(
	'login_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'login_ip' => array(
		'type' => 'VARCHAR',
		'constraint' => 45,
		'default' => ''),
	'login_email' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'login_time' => array(
		'type' => $date_type,
		'constraint' => $date_constraint,
		'default' => 0)
);

$fields_manifests = array(
	'manifest_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'manifest_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'manifest_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'manifest_desc' => array(
		'type' => 'TEXT'),
	'manifest_header_content' => array(
		'type' => 'TEXT'),
	'manifest_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'manifest_default' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'manifest_view' => array(
		'type' => 'TEXT'),
);

$fields_menu_categories = array(
	'menucat_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'menucat_order' => array(
		'type' => 'INT',
		'constraint' => 5,
		'default' => 1),
	'menucat_menu_cat' => array(
		'type' => 'VARCHAR',
		'constraint' => 20,
		'default' => ''),
	'menucat_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'menucat_type' => array(
		'type' => 'ENUM',
		'constraint' => "'sub','adminsub'",
		'default' => 'sub')
);

$fields_menu_items = array(
	'menu_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'menu_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 150,
		'default' => ''),
	'menu_group' => array(
		'type' => 'INT',
		'constraint' => 4),
	'menu_order' => array(
		'type' => 'INT',
		'constraint' => 4),
	'menu_link' => array(
		'type' => 'TEXT'),
	'menu_link_type' => array(
		'type' => 'ENUM',
		'constraint' => "'onsite','offsite'",
		'default' => 'onsite'),
	'menu_need_login' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n','none'",
		'default' => 'none'),
	'menu_use_access' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'menu_access' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'menu_access_level' => array(
		'type' => 'INT',
		'constraint' => 4,
		'default' => '0'),
	'menu_type' => array(
		'type' => 'ENUM',
		'constraint' => "'main','sub','adminsub'",
		'default' => 'main'),
	'menu_cat' => array(
		'type' => 'VARCHAR',
		'constraint' => 20,
		'default' => ''),
	'menu_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'menu_sim_type' => array(
		'type' => 'INT',
		'constraint' => 5)
);

$fields_messages = array(
	'message_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'message_key' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'message_label' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'message_content' => array(
		'type' => 'TEXT'),
	'message_type' => array(
		'type' => 'ENUM',
		'constraint' => "'title','message','other'",
		'default' => 'message'),
	'message_protected' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n')
);

$fields_mission_groups = array(
	'misgroup_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'misgroup_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'misgroup_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'misgroup_desc' => array(
		'type' => 'TEXT'),
	'misgroup_parent' => array(
		'type' => 'INT',
		'constraint' => 5,
		'default' => 0),
);

$fields_missions = array(
	'mission_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'mission_title' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'mission_images' => array(
		'type' => 'TEXT'),
	'mission_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'mission_group' => array(
		'type' => 'INT',
		'constraint' => 5),
	'mission_status' => array(
		'type' => 'ENUM',
		'constraint' => "'upcoming','current','completed'",
		'default' => 'upcoming'),
	'mission_start' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'mission_end' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'mission_desc' => array(
		'type' => 'TEXT'),
	'mission_summary' => array(
		'type' => 'TEXT'),
	'mission_notes' => array(
		'type' => 'TEXT'),
	'mission_notes_updated' => array(
		'type' => $date_type,
		'constraint' => $date_constraint)
);

$fields_news = array(
	'news_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'news_title' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'news_author_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'news_author_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'news_cat' => array(
		'type' => 'INT',
		'constraint' => 5),
	'news_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'news_content' => array(
		'type' => 'TEXT'),
	'news_status' => array(
		'type' => 'ENUM',
		'constraint' => "'activated','saved','pending'",
		'default' => 'activated'),
	'news_private' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'news_tags' => array(
		'type' => 'TEXT'),
	'news_last_update' => array(
		'type' => $date_type,
		'constraint' => $date_constraint,
		'default' => 0),
);

$fields_news_categories = array(
	'newscat_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'newscat_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'newscat_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y')
);

$fields_news_comments = array(
	'ncomment_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'ncomment_author_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'ncomment_author_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'ncomment_news' => array(
		'type' => 'INT',
		'constraint' => 8),
	'ncomment_content' => array(
		'type' => 'TEXT'),
	'ncomment_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'ncomment_status' => array(
		'type' => 'ENUM',
		'constraint' => "'activated','pending'",
		'default' => 'activated')
);

$fields_personallogs = array(
	'log_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'log_title' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'log_author_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'log_author_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'log_content' => array(
		'type' => 'TEXT'),
	'log_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'log_status' => array(
		'type' => 'ENUM',
		'constraint' => "'activated','saved','pending'",
		'default' => 'activated'),
	'log_tags' => array(
		'type' => 'TEXT'),
	'log_last_update' => array(
		'type' => $date_type,
		'constraint' => $date_constraint,
		'default' => 0),
);

$fields_personallogs_comments = array(
	'lcomment_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'lcomment_author_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'lcomment_author_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'lcomment_log' => array(
		'type' => 'INT',
		'constraint' => 8),
	'lcomment_content' => array(
		'type' => 'TEXT'),
	'lcomment_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'lcomment_status' => array(
		'type' => 'ENUM',
		'constraint' => "'activated','pending'",
		'default' => 'activated')
);

$fields_positions = array(
	'pos_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'pos_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'pos_desc' => array(
		'type' => 'TEXT'),
	'pos_dept' => array(
		'type' => 'INT',
		'constraint' => 10),
	'pos_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'pos_open' => array(
		'type' => 'INT',
		'constraint' => 5),
	'pos_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'pos_type' => array(
		'type' => 'ENUM',
		'constraint' => "'senior','officer','enlisted','other'",
		'default' => 'officer'),
	'pos_top_open' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n')
);

$fields_posts = array(
	'post_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'post_title' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'post_location' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'post_timeline' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'post_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'post_authors' => array(
		'type' => 'TEXT'),
	'post_authors_users' => array(
		'type' => 'TEXT'),
	'post_mission' => array(
		'type' => 'INT',
		'constraint' => 8),
	'post_saved' => array(
		'type' => $user_id_type,
		'constriant' => $user_id_constraint),
	'post_status' => array(
		'type' => 'ENUM',
		'constraint' => "'activated','saved','pending'",
		'default' => 'activated'),
	'post_content' => array(
		'type' => 'TEXT'),
	'post_tags' => array(
		'type' => 'TEXT'),
	'post_last_update' => array(
		'type' => $date_type,
		'constraint' => $date_constraint,
		'default' => 0),
	'post_participants' => array(
		'type' => 'TEXT'),
	'post_lock_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'post_lock_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
);

$fields_posts_comments = array(
	'pcomment_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'pcomment_author_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'pcomment_author_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'pcomment_post' => array(
		'type' => 'INT',
		'constraint' => 8),
	'pcomment_content' => array(
		'type' => 'TEXT'),
	'pcomment_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'pcomment_status' => array(
		'type' => 'ENUM',
		'constraint' => "'activated','pending'",
		'default' => 'activated')
);

$fields_privmsgs = array(
	'privmsgs_id' => array(
		'type' => 'BIGINT',
		'constraint' => 20,
		'auto_increment' => TRUE),
	'privmsgs_author_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'privmsgs_author_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'privmsgs_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'privmsgs_subject' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'privmsgs_content' => array(
		'type' => 'TEXT'),
	'privmsgs_author_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y')
);

$fields_privmsgs_to = array(
	'pmto_id' => array(
		'type' => 'BIGINT',
		'constraint' => 20,
		'auto_increment' => TRUE),
	'pmto_message' => array(
		'type' => 'BIGINT',
		'constraint' => 20),
	'pmto_recipient_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'pmto_recipient_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'pmto_unread' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'pmto_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y')
);

$fields_ranks = array(
	'rank_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'rank_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'rank_short_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 20,
		'default' => ''),
	'rank_image' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'rank_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'rank_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'rank_class' => array(
		'type' => 'INT',
		'constraint' => 5,
		'default' => 1)
);

$fields_security_questions = array(
	'question_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'question_value' => array(
		'type' => 'TEXT')
);

$fields_settings = array(
	'setting_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'setting_key' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'setting_value' => array(
		'type' => 'TEXT'),
	'setting_label' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'setting_user_created' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y')
);

$fields_sessions = array(
	'session_id' => array(
		'type' => 'VARCHAR',
		'constraint' => 40,
		'default' => '0'),
	'ip_address' => array(
		'type' => 'VARCHAR',
		'constraint' => 45,
		'default' => '0'),
	'user_agent' => array(
		'type' => 'VARCHAR',
		'constraint' => 120,
		'default' => ''),
	'last_activity' => array(
		'type' => $date_type,
		'constraint' => $date_constraint,
		'unsigned' => TRUE,
		'default' => 0),
	'user_data' => array(
		'type' => 'TEXT')
);

$fields_sim_type = array(
	'simtype_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'simtype_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => '')
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

$fields_specs_data = array(
	'data_id' => array(
		'type' => 'BIGINT',
		'constraint' => 20,
		'auto_increment' => TRUE),
	'data_item' => array(
		'type' => 'INT',
		'constraint' => 5),
	'data_field' => array(
		'type' => 'INT',
		'constraint' => 10),
	'data_value' => array(
		'type' => 'TEXT'),
	'data_updated' => array(
		'type' => $date_type,
		'constraint' => $date_constraint)
);

$fields_specs_fields = array(
	'field_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'field_type' => array(
		'type' => 'ENUM',
		'constraint' => "'text','select','textarea'",
		'default' => 'text'),
	'field_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'field_fid' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'field_class' => array(
		'type' => 'TEXT'),
	'field_label_page' => array(
		'type' => 'TEXT'),
	'field_value' => array(
		'type' => 'TEXT'),
	'field_selected' => array(
		'type' => 'VARCHAR',
		'constraint' => 20,
		'default' => ''),
	'field_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'field_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'field_rows' => array(
		'type' => 'INT',
		'constraint' => 3,
		'default' => 5),
	'field_section' => array(
		'type' => 'INT',
		'constraint' => 8,
		'default' => 1)
);

$fields_specs_sections = array(
	'section_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'section_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'section_order' => array(
		'type' => 'INT',
		'constraint' => 5)
);

$fields_specs_values = array(
	'value_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'value_field' => array(
		'type' => 'INT',
		'constraint' => 10),
	'value_type' => array(
		'type' => 'ENUM',
		'constraint' => "'option'",
		'default' => 'option'),
	'value_field_value' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'value_selected' => array(
		'type' => 'VARCHAR',
		'constraint' => 10,
		'default' => ''),
	'value_content' => array(
		'type' => 'TEXT'),
	'value_order' => array(
		'type' => 'INT',
		'constraint' => 5)
);

$fields_system_info = array(
	'sys_id' => array(
		'type' => 'INT',
		'constraint' => 4,
		'auto_increment' => TRUE),
	'sys_uid' => array(
		'type' => 'VARCHAR',
		'constraint' => 32,
		'default' => ''),
	'sys_install_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'sys_last_update' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'sys_version_major' => array(
		'type' => 'INT',
		'constraint' => 1),
	'sys_version_minor' => array(
		'type' => 'INT',
		'constraint' => 2),
	'sys_version_update' => array(
		'type' => 'INT',
		'constraint' => 4),
	'sys_version_ignore' => array(
		'type' => 'VARCHAR',
		'constraint' => 20,
		'default' => ''),
);

$fields_tour = array(
	'tour_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'tour_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'tour_order' => array(
		'type' => 'INT',
		'constraint' => 4),
	'tour_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'tour_images' => array(
		'type' => 'TEXT'),
	'tour_summary' => array(
		'type' => 'TEXT'),
	'tour_spec_item' => array(
		'type' => 'INT',
		'constraint' => 5),
);

$fields_tour_data = array(
	'data_id' => array(
		'type' => 'BIGINT',
		'constraint' => 20,
		'auto_increment' => TRUE),
	'data_tour_item' => array(
		'type' => 'INT',
		'constraint' => 5),
	'data_field' => array(
		'type' => 'INT',
		'constraint' => 10),
	'data_value' => array(
		'type' => 'TEXT'),
	'data_updated' => array(
		'type' => $date_type,
		'constraint' => $date_constraint)
);

$fields_tour_fields = array(
	'field_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'field_type' => array(
		'type' => 'ENUM',
		'constraint' => "'text','select','textarea'",
		'default' => 'text'),
	'field_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'field_fid' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'field_class' => array(
		'type' => 'TEXT'),
	'field_label_page' => array(
		'type' => 'TEXT'),
	'field_value' => array(
		'type' => 'TEXT'),
	'field_selected' => array(
		'type' => 'VARCHAR',
		'constraint' => 20,
		'default' => ''),
	'field_order' => array(
		'type' => 'INT',
		'constraint' => 5),
	'field_display' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'field_rows' => array(
		'type' => 'INT',
		'constraint' => 3,
		'default' => 5),
);

$fields_tour_values = array(
	'value_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'value_field' => array(
		'type' => 'INT',
		'constraint' => 10),
	'value_field_value' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'value_selected' => array(
		'type' => 'VARCHAR',
		'constraint' => 10,
		'default' => ''),
	'value_content' => array(
		'type' => 'TEXT'),
	'value_order' => array(
		'type' => 'INT',
		'constraint' => 5)
);

$fields_tour_decks = array(
	'deck_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'deck_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'deck_order' => array(
		'type' => 'INT',
		'constraint' => 10),
	'deck_content' => array(
		'type' => 'TEXT'),
	'deck_item' => array(
		'type' => 'INT',
		'constraint' => 5,
		'default' => 0),
);

$fields_uploads = array(
	'upload_id' => array(
		'type' => 'BIGINT',
		'constraint' => 20,
		'auto_increment' => TRUE),
	'upload_filename' => array(
		'type' => 'TEXT'),
	'upload_mime_type' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'upload_resource_type' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'upload_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'upload_ip' => array(
		'type' => 'VARCHAR',
		'constraint' => 45,
		'default' => ''),
	'upload_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
);

$fields_user_loa = array(
	'loa_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'loa_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'loa_start_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'loa_end_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'loa_duration' => array(
		'type' => 'TEXT'),
	'loa_reason' => array(
		'type' => 'TEXT'),
	'loa_type' => array(
		'type' => 'ENUM',
		'constraint' => "'active','loa','eloa'",
		'default' => 'loa'),
);

$fields_user_prefs = array(
	'pref_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'pref_key' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'pref_label' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'pref_default' => array(
		'type' => 'TEXT'),
);

$fields_user_prefs_values = array(
	'prefvalue_id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'prefvalue_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'prefvalue_key' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'prefvalue_value' => array(
		'type' => 'TEXT')
);

$fields_users = array(
	'userid' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint,
		'auto_increment' => TRUE),
	'status' => array(
		'type' => 'ENUM',
		'constraint' => "'active','inactive','pending'",
		'default' => 'active'),
	'name' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'email' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'password' => array(
		'type' => 'VARCHAR',
		'constraint' => 40,
		'default' => ''),
	'date_of_birth' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => ''),
	'instant_message' => array(
		'type' => 'TEXT'),
	'main_char' => array(
		'type' => 'INT',
		'constraint' => 5),
	'access_role' => array(
		'type' => 'INT',
		'constraint' => 5),
	'is_sysadmin' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'is_game_master' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'is_webmaster' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'is_firstlaunch' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'y'),
	'timezone' => array(
		'type' => 'VARCHAR',
		'constraint' => 5,
		'default' => 'UTC'),
	'daylight_savings' => array(
		'type' => 'VARCHAR',
		'constraint' => 1,
		'default' => '0'),
	'language' => array(
		'type' => 'VARCHAR',
		'constraint' => 50,
		'default' => 'english'),
	'join_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'leave_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'last_post' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'last_login' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'loa' => array(
		'type' => 'ENUM',
		'constraint' => "'active','loa','eloa'",
		'default' => 'active'),
	'display_rank' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => 'default'),
	'skin_main' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => 'default'),
	'skin_wiki' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => 'default'),
	'skin_admin' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => 'default'),
	'location' => array(
		'type' => 'TEXT'),
	'interests' => array(
		'type' => 'TEXT'),
	'bio' => array(
		'type' => 'TEXT'),
	'security_question' => array(
		'type' => 'INT',
		'constraint' => 5),
	'security_answer' => array(
		'type' => 'VARCHAR',
		'constraint' => 40,
		'default' => ''),
	'password_reset' => array(
		'type' => 'INT',
		'constraint' => 1,
		'default' => 0),
	'moderate_posts' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'moderate_logs' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'moderate_news' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'moderate_post_comments' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'moderate_log_comments' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'moderate_news_comments' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'moderate_wiki_comments' => array(
		'type' => 'ENUM',
		'constraint' => "'y','n'",
		'default' => 'n'),
	'my_links' => array(
		'type' => 'TEXT'),
	'last_update' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
);

$fields_wiki_categories = array(
	'wikicat_id' => array(
		'type' => 'INT',
		'constraint' => 8,
		'auto_increment' => TRUE),
	'wikicat_name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'wikicat_desc' => array(
		'type' => 'TEXT')
);

$fields_wiki_comments = array(
	'wcomment_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'wcomment_author_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'wcomment_author_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'wcomment_page' => array(
		'type' => 'INT',
		'constraint' => 10),
	'wcomment_date' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'wcomment_content' => array(
		'type' => 'TEXT'),
	'wcomment_status' => array(
		'type' => 'ENUM',
		'constraint' => "'activated','pending'",
		'default' => 'activated')
);

$fields_wiki_drafts = array(
	'draft_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'draft_id_old' => array(
		'type' => 'INT',
		'constraint' => 10),
	'draft_title' => array(
		'type' => 'VARCHAR',
		'constraint' => 255,
		'default' => ''),
	'draft_author_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'draft_author_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'draft_summary' => array(
		'type' => 'TEXT'),
	'draft_content' => array(
		'type' => 'LONGTEXT'),
	'draft_page' => array(
		'type' => 'INT',
		'constraint' => 10),
	'draft_created_at' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'draft_categories' => array(
		'type' => 'TEXT'),
	'draft_changed_comments' => array(
		'type' => 'TEXT'),
);

$fields_wiki_pages = array(
	'page_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'page_draft' => array(
		'type' => 'INT',
		'constraint' => 10),
	'page_created_at' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'page_created_by_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'page_created_by_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'page_updated_at' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'page_updated_by_user' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'page_updated_by_character' => array(
		'type' => $character_id_type,
		'constraint' => $character_id_constraint),
	'page_comments' => array(
		'type' => 'ENUM',
		'constraint' => "'open','closed'",
		'default' => 'open'),
	'page_type' => array(
		'type' => 'ENUM',
		'constraint' => "'standard','system'",
		'default' => 'standard'),
	'page_key' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
);

$fields_wiki_restrictions = array(
	'restr_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'restr_page' => array(
		'type' => 'INT',
		'constraint' => 10),
	'restr_created_at' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'restr_created_by' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'restr_updated_at' => array(
		'type' => $date_type,
		'constraint' => $date_constraint),
	'restr_updated_by' => array(
		'type' => $user_id_type,
		'constraint' => $user_id_constraint),
	'restrictions' => array(
		'type' => 'TEXT'),
);
