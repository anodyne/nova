<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Database Schema
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 */

$dbconfig		= Kohana::config('database');

$_user_field	= 'int(8)';
$_char_field	= 'int(8)';
$_date_field	= 'bigint(20)';

$_genre			= strtolower(Kohana::config('nova.genre'));
$_prefix		= $dbconfig['default']['table_prefix'];
$_charset		= 'DEFAULT CHARACTER SET '.$dbconfig['default']['charset'].' COLLATE '.$dbconfig['default']['collate'];

$fields = array(
"CREATE TABLE IF NOT EXISTS `${_prefix}access_groups` (
	`group_id` int(6) unsigned NOT NULL auto_increment,
	`group_name` varchar(255) NOT NULL default '',
	`group_order` int(4) NOT NULL default 99,
	PRIMARY KEY (`group_id`)
) $_charset",

"CREATE TABLE IF NOT EXISTS `${_prefix}access_pages` (
	`page_id` int(6) unsigned NOT NULL auto_increment,
	`page_name` varchar(255) NOT NULL default '',
	`page_url` varchar(255) NOT NULL default '',
	`page_level` varchar(3) NOT NULL default '',
	`page_group` int(6) NOT NULL default 0,
	`page_desc` text NOT NULL,
	PRIMARY KEY (`page_id`)
) $_charset",

"CREATE TABLE IF NOT EXISTS `${_prefix}access_groups` (
	`group_id` int(6) unsigned NOT NULL auto_increment,
	`group_name` varchar(255) NOT NULL default '',
	`group_order` int(4) NOT NULL default 99,
	PRIMARY KEY (`group_id`)
) $_charset",

"CREATE TABLE IF NOT EXISTS `${_prefix}access_pages` (
	`page_id` int(6) unsigned NOT NULL auto_increment,
	`page_name` varchar(255) NOT NULL default '',
	`page_url` varchar(255) NOT NULL default '',
	`page_level` varchar(3) NOT NULL default '',
	`page_group` int(6) NOT NULL default 0,
	`page_desc` text NOT NULL,
	PRIMARY KEY (`page_id`)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}access_roles (
	role_id int(5) unsigned NOT NULL auto_increment,
	role_name varchar(255) NOT NULL default '',
	role_access text NOT NULL,
	role_desc text NOT NULL,
	PRIMARY KEY (role_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}applications (
	app_id int(10) unsigned NOT NULL auto_increment,
	app_email varchar(255) NOT NULL default '',
	app_user ${_user_field} NOT NULL,
	app_user_name varchar(255) NOT NULL default '',
	app_character ${_char_field} NOT NULL,
	app_character_name text NOT NULL,
	app_position varchar(255) NOT NULL default '',
	app_date ${_date_field} NOT NULL,
	app_action varchar(100) NOT NULL default '',
	app_message text NOT NULL,
	PRIMARY KEY (app_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}awards (
	award_id int(5) unsigned NOT NULL auto_increment,
	award_name varchar(255) NOT NULL default '',
	award_image varchar(100) NOT NULL default '',
	award_order int(5) NOT NULL default 99,
	award_desc text NOT NULL,
	award_cat enum('ic','ooc','both') NOT NULL default 'ic',
	award_display enum('y','n') NOT NULL default 'y',
	PRIMARY KEY (award_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}awards_queue (
	queue_id int(8) unsigned NOT NULL auto_increment,
	queue_receive_character ${_char_field} NOT NULL,
	queue_receive_user ${_user_field} NOT NULL,
	queue_nominate ${_char_field} NOT NULL,
	queue_award int(5) NOT NULL,
	queue_reason text NOT NULL,
	queue_status enum('pending','accepted','rejected') NOT NULL default 'pending',
	queue_date ${_date_field} NOT NULL,
	PRIMARY KEY (queue_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}awards_received (
	awardrec_id int(8) unsigned NOT NULL auto_increment,
	awardrec_user ${_user_field} NOT NULL,
	awardrec_character ${_char_field} NOT NULL,
	awardrec_nominated_by ${_char_field} NOT NULL,
	awardrec_award int(5) NOT NULL,
	awardrec_date ${_date_field} NOT NULL,
	awardrec_reason text NOT NULL,
	PRIMARY KEY (awardrec_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}catalogue_ranks (
	rankcat_id int(5) unsigned NOT NULL auto_increment,
	rankcat_name varchar(100) NOT NULL default '',
	rankcat_location varchar(100) NOT NULL default '',
	rankcat_preview varchar(50) NOT NULL default 'preview.png',
	rankcat_blank varchar(50) NOT NULL default 'blank.png',
	rankcat_extension varchar(5) NOT NULL default '.png',
	rankcat_status enum('active','inactive','development') NOT NULL default 'active',
	rankcat_credits text NOT NULL,
	rankcat_url text NOT NULL,
	rankcat_default enum('y','n') NOT NULL default 'n',
	rankcat_genre varchar(10) NOT NULL default '${_genre}',
	PRIMARY KEY (rankcat_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}catalogue_skins (
	skin_id int(5) unsigned NOT NULL auto_increment,
	skin_name varchar(100) NOT NULL default '',
	skin_location varchar(100) NOT NULL default '',
	skin_credits text NOT NULL,
	PRIMARY KEY (skin_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}catalogue_skinsecs (
	skinsec_id int(10) unsigned NOT NULL auto_increment,
	skinsec_section varchar(50) NOT NULL default '',
	skinsec_skin varchar(100) NOT NULL default '',
	skinsec_image_preview varchar(50) NOT NULL default '',
	skinsec_status enum('active','inactive','development') NOT NULL default 'active',
	skinsec_default enum('y','n') NOT NULL default 'n',
	PRIMARY KEY (skinsec_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}characters (
	charid ${_char_field} unsigned NOT NULL auto_increment,
	user ${_user_field} NOT NULL,
	first_name varchar(50) NOT NULL default '',
	middle_name varchar(50) NOT NULL default '',
	last_name varchar(50) NOT NULL default '',
	suffix varchar(50) NOT NULL default '',
	crew_type enum('active','inactive','pending','npc') NOT NULL default 'active',
	_date_activate ${_date_field} NOT NULL,
	_date_deactivate ${_date_field} NOT NULL,
	images text NOT NULL,
	rank int(10) NOT NULL default 1,
	position_1 int(10) NOT NULL default 1,
	position_2 int(10) NOT NULL,
	last_post ${_date_field} NOT NULL,
	last_update ${_date_field} NOT NULL,
	PRIMARY KEY (charid)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}characters_promotions (
	prom_id bigint(20) unsigned NOT NULL auto_increment,
	prom_user ${_user_field} NOT NULL,
	prom_char ${_char_field} NOT NULL,
	prom_old_order int(8) NOT NULL,
	prom_old_rank varchar(100) NOT NULL default '',
	prom_new_order int(8) NOT NULL,
	prom_new_rank varchar(100) NOT NULL default '',
	prom_date ${_date_field} NOT NULL,
	PRIMARY KEY (prom_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}departments_${_genre} (
	dept_id int(10) unsigned NOT NULL auto_increment,
	dept_name varchar(255) NOT NULL default '',
	dept_desc text NOT NULL,
	dept_order int(5) NOT NULL,
	dept_display enum('y','n') NOT NULL default 'y',
	dept_type enum('playing','nonplaying') NOT NULL default 'playing',
	dept_parent int(10) NOT NULL default 0,
	PRIMARY KEY (dept_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}docking (
	docking_id int(5) unsigned NOT NULL auto_increment,
	docking_sim_name varchar(255) NOT NULL default '',
	docking_sim_url text NOT NULL,
	docking_gm_name varchar(255) NOT NULL default '',
	docking_gm_email varchar(255) NOT NULL default '',
	docking_status enum('active','inactive','pending') NOT NULL default 'pending',
	docking_date ${_date_field} NOT NULL,
	PRIMARY KEY (docking_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}forms (
	form_id int(5) NOT NULL auto_increment,
	form_key varchar(20) NOT NULL default '',
	form_name varchar(255) NOT NULL default '',
	form_desc text NOT NULL,
	form_status enum('active','inactive','development') NOT NULL default 'active',
	form_viewable enum('y','n') NOT NULL default 'y' comment 'Viewing is defined as seeing the content available in the form',
	form_displayable enum('y','n') NOT NULL default 'y' comment 'Displayable is defined as being able to display and complete the form',
	PRIMARY KEY (form_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}forms_data (
	data_id bigint(20) unsigned NOT NULL auto_increment,
	data_form bigint(20) unsigned NOT NULL,
	data_field bigint(20) unsigned NOT NULL,
	data_user ${_user_field} NOT NULL,
	data_character ${_char_field} NOT NULL,
	data_item int(10) NOT NULL,
	data_value text NOT NULL,
	data_last_update ${_date_field} NOT NULL,
	PRIMARY KEY (data_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}forms_fields (
	field_id bigint(20) unsigned NOT NULL auto_increment,
	field_form bigint(20) unsigned NOT NULL,
	field_section int(8) NOT NULL default 1,
	field_type enum('text','select','textarea','radio','checkbox') NOT NULL default 'text',
	field_html_name varchar(100) NOT NULL default '',
	field_html_id varchar(100) NOT NULL default '',
	field_html_class text NOT NULL,
	field_html_rows int(3) NOT NULL default 5,
	field_selected tinyint(1) NOT NULL default 0,
	field_value text NOT NULL,
	field_label text NOT NULL,
	field_order int(5) NOT NULL,
	field_display enum('y','n') NOT NULL default 'y',
	field_last_update ${_date_field} NOT NULL,
	PRIMARY KEY (field_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}forms_sections (
	section_id bigint(20) unsigned NOT NULL auto_increment,
	section_form bigint(20) NOT NULL,
	section_tab int(5) NOT NULL default 1,
	section_name varchar(255) NOT NULL default '',
	section_order int(5) NOT NULL,
	PRIMARY KEY (section_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}forms_tabs (
	tab_id bigint(20) unsigned NOT NULL auto_increment,
	tab_form bigint(20) NOT NULL,
	tab_name varchar(100) NOT NULL default '',
	tab_link_id varchar(50) NOT NULL default '',
	tab_order int(5) NOT NULL,
	tab_display enum('y','n') NOT NULL default 'y',
	PRIMARY KEY (tab_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}forms_values (
	value_id bigint(20) unsigned NOT NULL auto_increment,
	value_field bigint(20) NOT NULL,
	value_html_name varchar(50) NOT NULL default '',
	value_html_value varchar(255) NOT NULL default '',
	value_html_id varchar(50) NOT NULL default '',
	value_selected int(1) NOT NULL default 0,
	value_content text NOT NULL,
	value_order int(5) NOT NULL,
	PRIMARY KEY (value_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}login_attempts (
	login_id int(10) unsigned NOT NULL auto_increment,
	login_ip varchar(16) NOT NULL default '',
	login_email varchar(100) NOT NULL,
	login_time ${_date_field} NOT NULL,
	PRIMARY KEY (login_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}menu_categories (
	menucat_id int(5) unsigned NOT NULL auto_increment,
	menucat_order varchar(5) NOT NULL default 1,
	menucat_menu_cat varchar(20) NOT NULL default '',
	menucat_name varchar(100) NOT NULL default '',
	menucat_type enum('sub','adminsub') NOT NULL default 'sub',
	PRIMARY KEY (menucat_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}menu_items (
	menu_id int(8) unsigned NOT NULL auto_increment,
	menu_name varchar(150) NOT NULL default '',
	menu_group int(4) NOT NULL,
	menu_order int(5) NOT NULL,
	menu_url text NOT NULL,
	menu_link_type enum('onsite','offsite') NOT NULL default 'onsite',
	menu_need_login enum('y','n','none') NOT NULL default 'none',
	menu_use_access enum('y','n') NOT NULL default 'n',
	menu_access varchar(255) NOT NULL,
	menu_access_level int(4) NOT NULL default 0,
	menu_type enum('main','sub','adminsub') NOT NULL default 'main',
	menu_cat varchar(20) NOT NULL default '',
	menu_display enum('y','n') NOT NULL default 'y',
	menu_sim_type int(5) NOT NULL,
	PRIMARY KEY (menu_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}messages (
	message_id int(8) unsigned NOT NULL auto_increment,
	message_key varchar(255) NOT NULL default '',
	message_label varchar(255) NOT NULL default '',
	message_content text NOT NULL,
	message_type enum('title','message','other') NOT NULL default 'message',
	message_protected enum('y','n') NOT NULL default 'y',
	PRIMARY KEY (message_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}mission_groups (
	misgroup_id int(5) unsigned NOT NULL auto_increment,
	misgroup_name varchar(255) NOT NULL default '',
	misgroup_order int(5) NOT NULL,
	misgroup_desc text NOT NULL,
	PRIMARY KEY (misgroup_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}missions (
	mission_id int(8) unsigned NOT NULL auto_increment,
	mission_title varchar(255) NOT NULL default '',
	mission_images text NOT NULL,
	mission_order int(5) NOT NULL,
	mission_group int(5) NOT NULL,
	mission_status enum('upcoming','current','completed') NOT NULL default 'upcoming',
	mission_start ${_date_field} NOT NULL,
	mission_end ${_date_field} NOT NULL,
	mission_desc text NOT NULL,
	mission_summary text NOT NULL,
	mission_notes text NOT NULL,
	mission_notes_updated ${_date_field} NOT NULL,
	PRIMARY KEY (mission_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}news (
	news_id int(8) unsigned NOT NULL auto_increment,
	news_title varchar(255) NOT NULL default '',
	news_author_user ${_user_field} NOT NULL,
	news_author_character ${_char_field} NOT NULL,
	news_cat int(5) NOT NULL,
	news_content text NOT NULL,
	news_date ${_date_field} NOT NULL,
	news_status enum('activated','saved','pending') NOT NULL default 'activated',
	news_private enum('y','n') NOT NULL default 'n',
	news_tags text NOT NULL,
	news_last_update ${_date_field} NOT NULL,
	PRIMARY KEY (news_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}news_categories (
	newscat_id int(5) unsigned NOT NULL auto_increment,
	newscat_name varchar(255) NOT NULL default '',
	newscat_display enum('y','n') NOT NULL default 'y',
	PRIMARY KEY (newscat_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}news_comments (
	ncomment_id int(8) unsigned NOT NULL auto_increment,
	ncomment_author_user ${_user_field} NOT NULL,
	ncomment_author_character ${_char_field} NOT NULL,
	ncomment_news int(8) NOT NULL,
	ncomment_content text NOT NULL,
	ncomment_date ${_date_field} NOT NULL,
	ncomment_status enum('activated','pending') NOT NULL default 'activated',
	PRIMARY KEY (ncomment_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}personal_logs (
	log_id int(8) unsigned NOT NULL auto_increment,
	log_title varchar(255) NOT NULL default '',
	log_author_user ${_user_field} NOT NULL,
	log_author_character ${_char_field} NOT NULL,
	log_content text NOT NULL,
	log_date ${_date_field} NOT NULL,
	log_status enum('activated','saved','pending') NOT NULL default 'activated',
	log_tags text NOT NULL,
	log_last_update ${_date_field} NOT NULL,
	PRIMARY KEY (log_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}personal_logs_comments (
	lcomment_id int(8) unsigned NOT NULL auto_increment,
	lcomment_author_user ${_user_field} NOT NULL,
	lcomment_author_character ${_char_field} NOT NULL,
	lcomment_log int(8) NOT NULL,
	lcomment_content text NOT NULL,
	lcomment_date ${_date_field} NOT NULL,
	lcomment_status enum('activated','pending') NOT NULL default 'activated',
	PRIMARY KEY (lcomment_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}positions_${_genre} (
	pos_id int(10) unsigned NOT NULL auto_increment,
	pos_name varchar(255) NOT NULL default '',
	pos_desc text NOT NULL,
	pos_dept int(10) NOT NULL,
	pos_order int(5) NOT NULL,
	pos_open int(5) NOT NULL,
	pos_display enum('y','n') NOT NULL default 'y',
	pos_type enum('senior','officer','enlisted','other') NOT NULL default 'officer',
	PRIMARY KEY (pos_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}posts (
	post_id int(8) unsigned NOT NULL auto_increment,
	post_title varchar(255) NOT NULL default '',
	post_location varchar(255) NOT NULL default '',
	post_timeline varchar(255) NOT NULL default '',
	post_authors text NOT NULL,
	post_authors_user text NOT NULL,
	post_mission int(8) NOT NULL,
	post_saved ${_user_field} NOT NULL,
	post_status enum('activated','saved','pending') NOT NULL default 'activated',
	post_content text NOT NULL,
	post_date ${_date_field} NOT NULL,
	post_tags text NOT NULL,
	post_last_update ${_date_field} NOT NULL,
	PRIMARY KEY (post_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}posts_comments (
	pcomment_id int(8) unsigned NOT NULL auto_increment,
	pcomment_author_user ${_user_field} NOT NULL,
	pcomment_author_character ${_char_field} NOT NULL,
	pcomment_post int(8) NOT NULL,
	pcomment_content text NOT NULL,
	pcomment_date ${_date_field} NOT NULL,
	pcomment_status enum('activated','pending') NOT NULL default 'activated',
	PRIMARY KEY (pcomment_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}privmsgs (
	privmsgs_id bigint(20) unsigned NOT NULL auto_increment,
	privmsgs_author_user ${_user_field} NOT NULL,
	privmsgs_author_character ${_char_field} NOT NULL,
	privmsgs_subject varchar(255) NOT NULL default '',
	privmsgs_content text NOT NULL,
	privmsgs_date ${_date_field} NOT NULL,
	privmsgs_author_display enum('y','n') NOT NULL default 'y',
	PRIMARY KEY (privmsgs_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}privmsgs_to (
	pmto_id bigint(20) unsigned NOT NULL auto_increment,
	pmto_message bigint(20) NOT NULL,
	pmto_recipient_user ${_user_field} NOT NULL,
	pmto_recipient_character ${_char_field} NOT NULL,
	pmto_unread enum('y','n') NOT NULL default 'y',
	pmto_display enum('y','n') NOT NULL default 'y',
	PRIMARY KEY (pmto_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}ranks_${_genre} (
	rank_id int(10) unsigned NOT NULL auto_increment,
	rank_name varchar(100) NOT NULL default '',
	rank_short_name varchar(20) NOT NULL default '',
	rank_image varchar(100) NOT NULL default '',
	rank_order int(5) NOT NULL,
	rank_display enum('y','n') NOT NULL default 'y',
	rank_class int(5) NOT NULL default 1,
	PRIMARY KEY (rank_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}security_questions (
	question_id int(5) unsigned NOT NULL auto_increment,
	question_value text NOT NULL,
	PRIMARY KEY (question_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}settings (
	setting_id int(5) unsigned NOT NULL auto_increment,
	setting_key varchar(100) NOT NULL default '',
	setting_value text NOT NULL,
	setting_label varchar(255) NOT NULL default '',
	setting_user_created enum('y','n') NOT NULL default 'y',
	PRIMARY KEY (setting_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}sessions (
	session_id varchar(24) NOT NULL,
	last_active int unsigned NOT NULL,
	contents text NOT NULL,
	PRIMARY KEY (session_id),
	INDEX (last_active)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}sim_type (
	simtype_id int(5) unsigned NOT NULL auto_increment,
	simtype_name varchar(50) NOT NULL default '',
	PRIMARY KEY (simtype_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}specs (
	spec_id int(5) unsigned NOT NULL auto_increment,
	spec_name varchar(100) NOT NULL default '',
	spec_desc text NOT NULL,
	PRIMARY KEY (spec_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}system_components (
	comp_id int(5) unsigned NOT NULL auto_increment,
	comp_name varchar(255) NOT NULL default '',
	comp_version varchar(25) NOT NULL default '',
	comp_desc text NOT NULL,
	comp_url text NOT NULL,
	PRIMARY KEY (comp_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}system_info (
	sys_id tinyint(1) NOT NULL auto_increment,
	sys_uid varchar(32) NOT NULL default '',
	sys_install_date ${_date_field} NOT NULL,
	sys_last_update ${_date_field} NOT NULL,
	sys_version_major int(1) NOT NULL,
	sys_version_minor int(2) NOT NULL,
	sys_version_update int(4) NOT NULL,
	sys_version_ignore varchar(20) NOT NULL default '',
	PRIMARY KEY (sys_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}system_versions (
	version_id int(4) NOT NULL auto_increment,
	version varchar(25) NOT NULL default '',
	version_major int(1) NOT NULL,
	version_minor int(2) NOT NULL,
	version_update int(4) NOT NULL,
	version_date ${_date_field} NOT NULL,
	version_launch_notes text NOT NULL,
	version_changes text NOT NULL,
	PRIMARY KEY (version_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}tour (
	tour_id int(5) NOT NULL auto_increment,
	tour_name varchar(255) NOT NULL default '',
	tour_order int(5) NOT NULL,
	tour_display enum('y','n') NOT NULL default 'y',
	tour_images text NOT NULL,
	tour_summary text NOT NULL,
	PRIMARY KEY (tour_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}tour_decks (
	deck_id int(10) NOT NULL auto_increment,
	deck_name varchar(255) NOT NULL default '',
	deck_order int(5) NOT NULL,
	deck_content text NOT NULL,
	PRIMARY KEY (deck_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}user_loa (
	loa_id int(10) NOT NULL auto_increment,
	loa_user ${_user_field} NOT NULL,
	loa_start_date ${_date_field} NOT NULL,
	loa_end_date ${_date_field} NOT NULL,
	loa_duration text NOT NULL,
	loa_reason text NOT NULL,
	loa_type enum('active','loa','eloa') NOT NULL default 'loa',
	PRIMARY KEY (loa_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}user_prefs (
	pref_id int(5) NOT NULL auto_increment,
	pref_key varchar(100) NOT NULL default '',
	pref_label varchar(255) NOT NULL default '',
	pref_default text NOT NULL,
	PRIMARY KEY (pref_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}user_prefs_values (
	prefvalue_id int(5) NOT NULL auto_increment,
	prefvalue_user ${_user_field} NOT NULL,
	prefvalue_key varchar(100) NOT NULL default '',
	prefvalue_value text NOT NULL,
	PRIMARY KEY (prefvalue_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}users (
	userid ${_user_field} NOT NULL auto_increment,
	status enum('active','inactive','pending') NOT NULL default 'active',
	name varchar(255) NOT NULL default '',
	email varchar(100) NOT NULL default '',
	password varchar(40) NOT NULL default '',
	date_of_birth varchar(50) NOT NULL default '',
	instant_message text NOT NULL,
	main_char ${_char_field} NOT NULL,
	access_role int(5) NOT NULL,
	is_sysadmin enum('y','n') NOT NULL default 'n',
	is_game_master enum('y','n') NOT NULL default 'n',
	is_webmaster enum('y','n') NOT NULL default 'n',
	is_firstlaunch enum('y','n') NOT NULL default 'y',
	timezone varchar(100) NOT NULL default 'UTC',
	daylight_savings varchar(1) NOT NULL default '0',
	language varchar(50) NOT NULL default 'en-us',
	join_date ${_date_field} NOT NULL,
	leave_date ${_date_field} NOT NULL,
	last_post ${_date_field} NOT NULL,
	last_login ${_date_field} NOT NULL,
	last_update ${_date_field} NOT NULL,
	loa enum('active','loa','eloa') NOT NULL default 'active',
	display_rank varchar(100) NOT NULL default 'default',
	skin_main varchar(100) NOT NULL default 'default',
	skin_wiki varchar(100) NOT NULL default 'default',
	skin_admin varchar(100) NOT NULL default 'default',
	location text NOT NULL,
	interests text NOT NULL,
	bio text NOT NULL,
	security_question int(5) NOT NULL,
	security_answer varchar(40) NOT NULL default '',
	password_reset tinyint(1) NOT NULL default 0,
	my_links text NOT NULL,
	PRIMARY KEY (userid)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}wiki_categories (
	wikicat_id int(8) NOT NULL auto_increment,
	wikicat_name varchar(100) NOT NULL default '',
	wikicat_desc text NOT NULL,
	PRIMARY KEY (wikicat_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}wiki_comments (
	wcomment_id int(10) unsigned NOT NULL auto_increment,
	wcomment_author_user ${_user_field} NOT NULL,
	wcomment_author_character ${_char_field} NOT NULL,
	wcomment_page int(10) NOT NULL,
	wcomment_content text NOT NULL,
	wcomment_date ${_date_field} NOT NULL,
	wcomment_status enum('activated','pending') NOT NULL default 'activated',
	PRIMARY KEY (wcomment_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}wiki_drafts (
	draft_id int(10) NOT NULL auto_increment,
	draft_id_old int(10) NOT NULL,
	draft_title varchar(255) NOT NULL default '',
	draft_author_user ${_user_field} NOT NULL,
	draft_author_character ${_char_field} NOT NULL,
	draft_summary text NOT NULL,
	draft_content longtext NOT NULL,
	draft_page int(10) NOT NULL,
	draft_created_at ${_date_field} NOT NULL,
	draft_categories text NOT NULL,
	draft_changed_comments text NOT NULL,
	PRIMARY KEY (draft_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}wiki_pages (
	page_id int(10) NOT NULL auto_increment,
	page_draft int(10) NOT NULL,
	page_created_at ${_date_field} NOT NULL,
	page_created_by_user ${_user_field} NOT NULL,
	page_created_by_character ${_char_field} NOT NULL,
	page_updated_at ${_date_field} NOT NULL,
	page_updated_by_user ${_user_field} NOT NULL,
	page_updated_by_character ${_char_field} NOT NULL,
	page_comments enum('open','closed') NOT NULL default 'open',
	PRIMARY KEY (page_id)
) $_charset",

"CREATE TABLE IF NOT EXISTS ${_prefix}uploads (
	upload_id bigint(20) NOT NULL auto_increment,
	upload_filename text NOT NULL,
	upload_mime_type varchar(255) NOT NULL default '',
	upload_resource_type varchar(100) NOT NULL default '',
	upload_user ${_user_field} NOT NULL,
	upload_ip varchar(16) NOT NULL default '',
	upload_date ${_date_field} NOT NULL,
	PRIMARY KEY (upload_id)
) $_charset",
);

// End of file schema.php
// Location: modules/install/assets/schema.php