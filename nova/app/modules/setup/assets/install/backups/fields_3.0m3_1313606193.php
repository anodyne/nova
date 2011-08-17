<?php

$_genre = strtolower(Kohana::$config->load('nova.genre'));

$data = array(
	'access_groups' => array(),
	'access_pages' => array(),
	'access_roles' => array(),
	'applications' => array(),
	'awards' => array(),
	'awards_queue' => array(),
	'awards_received' => array(),
	'bans' => array(),
	'catalogue_modules' => array(),
	'catalogue_ranks' => array(),
	'catalogue_skins' => array(),
	'catalogue_skinsecs' => array(),
	'catalogue_widgets' => array(),
	'characters' => array(),
	'character_images' => array(),
	'character_promotions' => array(),
	'coc' => array(),
	'comments' => array(),
	'departments_'.$_genre => array('fields' => 'fields_departments'),
	'docking' => array(),
	'forms' => array(),
	'form_data' => array(),
	'form_fields' => array(),
	'form_sections' => array(),
	'form_tabs' => array(),
	'form_values' => array(),
	'login_attempts' => array(),
	'manifests' => array(),
	'menu_items' => array(),
	'menu_categories' => array(),
	'messages' => array(),
	'message_recipients' => array(),
	'missions' => array(),
	'mission_groups' => array(),
	'moderation' => array(),
	'news' => array(),
	'news_categories' => array(),
	'personal_logs' => array(),
	'positions_'.$_genre => array('fields' => 'fields_positions'),
	'posts' => array(),
	'post_authors' => array(),
	'ranks_'.$_genre => array('fields' => 'fields_ranks'),
	'security_questions' => array(),
	'sessions' => array('id' => 'session_id', 'index' => array('last_active')),
	'settings' => array(),
	'sim_types' => array(),
	'site_contents' => array(),
	'specs' => array(),
	'system_info' => array(),
	'system_components' => array(),
	'system_versions' => array(),
	'tour' => array(),
	'tour_decks' => array(),
	'uploads' => array(),
	'users' => array(),
	'user_loas' => array(),
	'user_prefs' => array(),
	'user_pref_values' => array(),
	'wiki_categories' => array(),
	'wiki_drafts' => array(),
	'wiki_pages' => array(),
);


$fields_access_groups = array(
	'id' => array('type' => 'INT', 'constraint' => 6, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5, 'default' => 0),
);

$fields_access_pages = array(
	'id' => array('type' => 'INT', 'constraint' => 6, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'url' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'level' => array('type' => 'INT', 'constraint' => 3, 'default' => 0),
	'group' => array('type' => 'INT', 'constraint' => 6, 'default' => 0),
	'desc' => array('type' => 'TEXT'),
);

$fields_access_roles = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'pages' => array('type' => 'TEXT'),
	'desc' => array('type' => 'TEXT'),
);

$fields_applications = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'email' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'default' => ''),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'user_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'character_name' => array('type' => 'TEXT'),
	'position' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'action' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'message' => array('type' => 'TEXT'),
);

$fields_awards = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'image' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'desc' => array('type' => 'TEXT'),
	'category' => array('type' => 'ENUM', 'constraint' => "'ic','ooc','both'", 'default' => 'ic'),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_awards_queue = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'receive_character_id' => array('type' => 'INT', 'constraint' => 8),
	'receive_user_id' => array('type' => 'INT', 'constraint' => 8),
	'nominate_character_id' => array('type' => 'INT', 'constraint' => 8),
	'award_id' => array('type' => 'INT', 'constraint' => 5),
	'reason' => array('type' => 'TEXT'),
	'status' => array('type' => 'ENUM', 'constraint' => "'pending','accepted','rejected'", 'default' => 'pending'),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_awards_received = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'receive_character_id' => array('type' => 'INT', 'constraint' => 8),
	'receive_user_id' => array('type' => 'INT', 'constraint' => 8),
	'nominate_character_id' => array('type' => 'INT', 'constraint' => 8),
	'award_id' => array('type' => 'INT', 'constraint' => 5),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'reason' => array('type' => 'TEXT'),
);

$fields_bans = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'level' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'default' => ''),
	'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'reason' => array('type' => 'TEXT'),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_catalogue_modules = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'short_name' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'desc' => array('type' => 'TEXT'),
	'protected' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive'", 'default' => 'active'),
	'credits' => array('type' => 'TEXT'),
);

$fields_catalogue_ranks = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'preview' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'preview.png'),
	'blank' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'blank.png'),
	'extension' => array('type' => 'VARCHAR', 'constraint' => 5, 'default' => '.png'),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
	'credits' => array('type' => 'TEXT'),
	'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'genre' => array('type' => 'VARCHAR', 'constraint' => 10, 'default' => 'bsg'),
);

$fields_catalogue_skins = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'credits' => array('type' => 'TEXT'),
	'version' => array('type' => 'VARCHAR', 'constraint' => 10, 'default' => ''),
);

$fields_catalogue_skinsecs = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'section' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
	'skin' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'preview' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
	'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
);

$fields_catalogue_widgets = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'page' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'zone' => array('type' => 'INT', 'constraint' => 3),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
	'credits' => array('type' => 'TEXT'),
);

$fields_characters = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'first_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'middle_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'last_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'suffix' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','pending','archived'", 'default' => 'pending'),
	'activated' => array('type' => 'BIGINT', 'constraint' => 20),
	'deactivated' => array('type' => 'BIGINT', 'constraint' => 20),
	'rank_id' => array('type' => 'INT', 'constraint' => 10, 'default' => 1),
	'position1_id' => array('type' => 'INT', 'constraint' => 10, 'default' => 1),
	'position2_id' => array('type' => 'INT', 'constraint' => 10),
	'last_post' => array('type' => 'BIGINT', 'constraint' => 20),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_character_images = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'image' => array('type' => 'TEXT'),
	'primary_image' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'created_by' => array('type' => 'INT', 'constraint' => 8),
	'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_character_promotions = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'old_order' => array('type' => 'INT', 'constraint' => 5),
	'old_rank' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'new_order' => array('type' => 'INT', 'constraint' => 5),
	'new_rank' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_coc = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'order' => array('type' => 'INT', 'constraint' => 5),
);

$fields_comments = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'type' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'item_id' => array('type' => 'INT', 'constraint' => 8),
	'content' => array('type' => 'TEXT'),
	'status' => array('type' => 'ENUM', 'constraint' => "'activated','pending'", 'default' => 'activated'),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_departments = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'desc' => array('type' => 'TEXT'),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'type' => array('type' => 'ENUM', 'constraint' => "'playing','nonplaying'", 'default' => 'playing'),
	'parent_id' => array('type' => 'INT', 'constraint' => 10, 'default' => 0),
	'manifest_id' => array('type' => 'INT', 'constraint' => 5, 'default' => 1),
);

$fields_docking = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'sim_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'sim_url' => array('type' => 'TEXT'),
	'gm_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'gm_email' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','pending'", 'default' => 'pending'),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_forms = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'key' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'desc' => array('type' => 'TEXT'),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
);

$fields_form_data = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'form_key' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'field_id' => array('type' => 'BIGINT', 'constraint' => 20),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'VARCHAR', 'constraint' => 8),
	'item_id' => array('type' => 'INT', 'constraint' => 10),
	'value' => array('type' => 'TEXT'),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_form_fields = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'form_key' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'section_id' => array('type' => 'INT', 'constraint' => 10),
	'type' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'text'),
	'html_name' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'html_id' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'html_class' => array('type' => 'TEXT'),
	'html_rows' => array('type' => 'INT', 'constraint' => 3, 'default' => 5),
	'selected' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
	'value' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'placeholder' => array('type' => 'TEXT'),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_form_sections = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'form_key' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'tab_id' => array('type' => 'INT', 'constraint' => 10),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5),
);

$fields_form_tabs = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'form_key' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'link_id' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_form_values = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'form_key' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'field_id' => array('type' => 'INT', 'constraint' => 10),
	'html_name' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'html_value' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'html_id' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'selected' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
	'content' => array('type' => 'TEXT'),
	'order' => array('type' => 'INT', 'constraint' => 5),
);

$fields_login_attempts = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'default' => ''),
	'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'time' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_manifests = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'desc' => array('type' => 'TEXT'),
	'header_content' => array('type' => 'TEXT'),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
);

$fields_menu_items = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'group' => array('type' => 'INT', 'constraint' => 4),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'url' => array('type' => 'TEXT'),
	'url_target' => array('type' => 'ENUM', 'constraint' => "'onsite','offsite'", 'default' => 'onsite'),
	'needs_login' => array('type' => 'ENUM', 'constraint' => "'y','n','none'", 'default' => 'none'),
	'use_access' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'access' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'access_level' => array('type' => 'INT', 'constraint' => 4, 'default' => 0),
	'type' => array('type' => 'ENUM', 'constraint' => "'main','sub','adminsub'", 'default' => 'main'),
	'category' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'sim_type' => array('type' => 'INT', 'constraint' => 5),
);

$fields_menu_categories = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'category' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'type' => array('type' => 'ENUM', 'constraint' => "'sub','adminsub'", 'default' => 'sub'),
	'landing_page' => array('type' => 'TEXT'),
);

$fields_messages = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'subject' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'content' => array('type' => 'TEXT'),
	'author_display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_message_recipients = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'message_id' => array('type' => 'BIGINT', 'constraint' => 20),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'unread' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_missions = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'images' => array('type' => 'TEXT'),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'group_id' => array('type' => 'INT', 'constraint' => 5),
	'status' => array('type' => 'ENUM', 'constraint' => "'upcoming','current','completed'", 'default' => 'upcoming'),
	'start' => array('type' => 'BIGINT', 'constraint' => 20),
	'end' => array('type' => 'BIGINT', 'constraint' => 20),
	'desc' => array('type' => 'TEXT'),
	'summary' => array('type' => 'TEXT'),
	'notes' => array('type' => 'TEXT'),
	'notes_updated' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_mission_groups = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'desc' => array('type' => 'TEXT'),
	'parent_id' => array('type' => 'INT', 'constraint' => 5),
);

$fields_moderation = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'type' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_news = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'category_id' => array('type' => 'INT', 'constraint' => 5),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'content' => array('type' => 'TEXT'),
	'status' => array('type' => 'ENUM', 'constraint' => "'activated','saved','pending'", 'default' => 'activated'),
	'private' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'tags' => array('type' => 'TEXT'),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'default' => 0),
);

$fields_news_categories = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_personal_logs = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'content' => array('type' => 'TEXT'),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'status' => array('type' => 'ENUM', 'constraint' => "'activated','saved','pending'", 'default' => 'activated'),
	'tags' => array('type' => 'TEXT'),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_positions = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'desc' => array('type' => 'TEXT'),
	'dept_id' => array('type' => 'INT', 'constraint' => 10),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'open' => array('type' => 'INT', 'constraint' => 5),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'type' => array('type' => 'ENUM', 'constraint' => "'senior','officer','enlisted','other'", 'default' => 'officer'),
);

$fields_posts = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'timeline' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'mission_id' => array('type' => 'INT', 'constraint' => 8),
	'saved_user_id' => array('type' => 'INT'),
	'status' => array('type' => 'ENUM', 'constraint' => "'activated','saved','pending'", 'default' => 'activated'),
	'content' => array('type' => 'TEXT'),
	'tags' => array('type' => 'TEXT'),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'participants' => array('type' => 'TEXT'),
	'lock_user_id' => array('type' => 'INT', 'constraint' => 8),
	'lock_date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_post_authors = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'post_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
);

$fields_ranks = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'short_name' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
	'image' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'class' => array('type' => 'INT', 'constraint' => 5, 'default' => 1),
);

$fields_security_questions = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'value' => array('type' => 'TEXT'),
);

$fields_sessions = array(
	'session_id' => array('type' => 'VARCHAR', 'constraint' => 24, 'default' => 0),
	'last_active' => array('type' => 'INT'),
	'contents' => array('type' => 'TEXT'),
);

$fields_settings = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'key' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'value' => array('type' => 'TEXT'),
	'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'user_created' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_sim_types = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
);

$fields_site_contents = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'key' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'content' => array('type' => 'TEXT'),
	'type' => array('type' => 'ENUM', 'constraint' => "'title','header','message','other'", 'default' => 'message'),
	'section' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
	'page' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'protected' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
);

$fields_specs = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'images' => array('type' => 'TEXT'),
	'summary' => array('type' => 'TEXT'),
);

$fields_system_info = array(
	'id' => array('type' => 'INT', 'constraint' => 4, 'auto_increment' => true),
	'uid' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => ''),
	'install_date' => array('type' => 'BIGINT', 'constraint' => 20),
	'last_update' => array('type' => 'BIGINT', 'constraint' => 20),
	'version_major' => array('type' => 'INT', 'constraint' => 1),
	'version_minor' => array('type' => 'INT', 'constraint' => 2),
	'version_update' => array('type' => 'INT', 'constraint' => 4),
	'version_ignore' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
);

$fields_system_components = array(
	'id' => array('type' => 'INT', 'constraint' => 4, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'version' => array('type' => 'VARCHAR', 'constraint' => 25, 'default' => ''),
	'url' => array('type' => 'TEXT'),
	'desc' => array('type' => 'TEXT'),
);

$fields_system_versions = array(
	'id' => array('type' => 'INT', 'constraint' => 4, 'auto_increment' => true),
	'version' => array('type' => 'VARCHAR', 'constraint' => 25, 'default' => ''),
	'major' => array('type' => 'INT', 'constraint' => 1),
	'minor' => array('type' => 'INT', 'constraint' => 2),
	'update' => array('type' => 'INT', 'constraint' => 4),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'launch' => array('type' => 'TEXT'),
	'changes' => array('type' => 'TEXT'),
);

$fields_tour = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'images' => array('type' => 'TEXT'),
	'summary' => array('type' => 'TEXT'),
	'spec_id' => array('type' => 'INT', 'constraint' => 5),
);

$fields_tour_decks = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5),
	'content' => array('type' => 'TEXT'),
	'spec_id' => array('type' => 'INT', 'constraint' => 5),
);

$fields_uploads = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'filename' => array('type' => 'TEXT'),
	'mime_type' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'resource_type' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'default' => ''),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_users = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'password' => array('type' => 'VARCHAR', 'constraint' => 40, 'default' => ''),
	'date_of_birth' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'role_id' => array('type' => 'INT', 'constraint' => 5),
	'is_sysadmin' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'is_game_master' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'is_webmaster' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'is_firstlaunch' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'timezone' => array('type' => 'VARCHAR', 'constraint' => 5, 'default' => 'UTC'),
	'daylight_savings' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'email_format' => array('type' => 'VARCHAR', 'constraint' => 4, 'default' => 'html'),
	'language' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'en-us'),
	'join_date' => array('type' => 'BIGINT', 'constraint' => 20),
	'leave_date' => array('type' => 'BIGINT', 'constraint' => 20),
	'last_post' => array('type' => 'BIGINT', 'constraint' => 20),
	'last_login' => array('type' => 'BIGINT', 'constraint' => 20),
	'loa' => array('type' => 'ENUM', 'constraint' => "'active','loa','eloa'", 'default' => 'active'),
	'display_rank' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => 'default'),
	'skin_main' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default'),
	'skin_admin' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default'),
	'security_question' => array('type' => 'INT', 'constraint' => 5),
	'security_answer' => array('type' => 'VARCHAR', 'constraint' => 40, 'default' => ''),
	'password_reset' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'my_links' => array('type' => 'TEXT'),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_user_loas = array(
	'id' => array('type' => 'INT', 'constraint' => 10, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'start' => array('type' => 'BIGINT', 'constraint' => 20),
	'end' => array('type' => 'BIGINT', 'constraint' => 20),
	'duration' => array('type' => 'TEXT'),
	'reason' => array('type' => 'TEXT'),
	'type' => array('type' => 'ENUM', 'constraint' => "'active','loa','eloa'", 'default' => 'loa'),
);

$fields_user_prefs = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'key' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'default' => array('type' => 'TEXT'),
);

$fields_user_pref_values = array(
	'id' => array('type' => 'INT', 'constraint' => 5, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'key' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'value' => array('type' => 'TEXT'),
);

$fields_wiki_categories = array(
	'id' => array('type' => 'INT', 'constraint' => 8, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
	'desc' => array('type' => 'TEXT'),
);

$fields_wiki_drafts = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'id_old' => array('type' => 'INT', 'constraint' => 11),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'user_id' => array('type' => 'INT', 'constraint' => 8),
	'character_id' => array('type' => 'INT', 'constraint' => 8),
	'summary' => array('type' => 'TEXT'),
	'content' => array('type' => 'TEXT'),
	'page_id' => array('type' => 'INT', 'constraint' => 11),
	'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'categories' => array('type' => 'TEXT'),
	'changed_comments' => array('type' => 'TEXT'),
);

$fields_wiki_pages = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'draft_id' => array('type' => 'INT', 'constraint' => 11),
	'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'created_by_user' => array('type' => 'INT', 'constraint' => 8),
	'created_by_character' => array('type' => 'INT', 'constraint' => 8),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'updated_by_user' => array('type' => 'INT', 'constraint' => 8),
	'updated_by_character' => array('type' => 'INT', 'constraint' => 8),
	'comments' => array('type' => 'TEXT'),
);

