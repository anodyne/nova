<?php

$_genre = strtolower(\Config::get('nova.genre'));

$data = array(
	'roles' => array(),
	'roles_tasks' => array(),
	'tasks' => array(),
	'announcements' => array(),
	'announcement_categories' => array(),
	'applications' => array(),
	'awards' => array(),
	'awards_categories' => array(),
	'awards_queue' => array(),
	'awards_received' => array(),
	'bans' => array(),
	'catalog_modules' => array(),
	'catalog_ranks' => array(),
	'catalog_skins' => array(),
	'catalog_skinsecs' => array(),
	'catalog_widgets' => array(),
	'characters' => array(),
	'character_images' => array(),
	'character_positions' => array(),
	'character_promotions' => array(),
	'comments' => array(),
	'departments_'.$_genre => array('fields' => 'fields_departments'),
	'forms' => array(),
	'form_data' => array(),
	'form_fields' => array(),
	'form_sections' => array(),
	'form_tabs' => array(),
	'form_values' => array(),
	'manifests' => array(),
	'media' => array(),
	'messages' => array(),
	'message_recipients' => array(),
	'missions' => array(),
	'mission_groups' => array(),
	'moderation' => array(),
	'navigation' => array(),
	'personal_logs' => array(),
	'positions_'.$_genre => array('fields' => 'fields_positions'),
	'posts' => array(),
	'post_authors' => array(),
	'ranks_'.$_genre => array('fields' => 'fields_ranks'),
	'sessions' => array('id' => 'session_id', 'index' => array('previous_id')),
	'settings' => array(),
	'sim_types' => array(),
	'site_contents' => array(),
	'specs' => array(),
	'system_info' => array(),
	'system_events' => array(),
	'tour' => array(),
	'tour_decks' => array(),
	'users' => array(),
	'user_loas' => array(),
	'users_preferences' => array(),
	'users_suspended' => array(),
	'wiki_categories' => array(),
	'wiki_drafts' => array(),
	'wiki_pages' => array(),
	'wiki_restrictions' => array(),
);


$fields_roles = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
	'inherits' => array('type' => 'TEXT', 'null' => true),
);

$fields_roles_tasks = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'role_id' => array('type' => 'INT', 'constraint' => 11),
	'task_id' => array('type' => 'INT', 'constraint' => 11),
);

$fields_tasks = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'component' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'action' => array('type' => 'VARCHAR', 'constraint' => 11, 'default' => 'read'),
	'level' => array('type' => 'INT', 'constraint' => 2, 'default' => 0),
	'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'help' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
);

$fields_announcements = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'category_id' => array('type' => 'INT', 'constraint' => 11),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'content' => array('type' => 'BLOB'),
	'status' => array('type' => 'ENUM', 'constraint' => ""activated","saved","pending"", 'default' => 'activated'),
	'private' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'tags' => array('type' => 'TEXT', 'null' => true),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_announcement_categories = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_applications = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'email' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'user_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'character_name' => array('type' => 'TEXT', 'null' => true),
	'position' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'action' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'message' => array('type' => 'TEXT', 'null' => true),
);

$fields_awards = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'image' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'category_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
	'type' => array('type' => 'ENUM', 'constraint' => "'ic','ooc','both'", 'default' => 'ic'),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_awards_categories = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_awards_queue = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'receive_character_id' => array('type' => 'INT', 'constraint' => 11),
	'receive_user_id' => array('type' => 'INT', 'constraint' => 11),
	'nominate_character_id' => array('type' => 'INT', 'constraint' => 11),
	'award_id' => array('type' => 'INT', 'constraint' => 11),
	'reason' => array('type' => 'TEXT', 'null' => true),
	'status' => array('type' => 'ENUM', 'constraint' => "'pending','accepted','rejected'", 'default' => 'pending'),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_awards_received = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'receive_character_id' => array('type' => 'INT', 'constraint' => 11),
	'receive_user_id' => array('type' => 'INT', 'constraint' => 11),
	'nominate_character_id' => array('type' => 'INT', 'constraint' => 11),
	'award_id' => array('type' => 'INT', 'constraint' => 11),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'reason' => array('type' => 'TEXT', 'null' => true),
);

$fields_bans = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'level' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => true),
	'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'reason' => array('type' => 'TEXT', 'null' => true),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_catalog_modules = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'short_name' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
	'protected' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive'", 'default' => 'active'),
	'credits' => array('type' => 'TEXT', 'null' => true),
);

$fields_catalog_ranks = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'preview' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'preview.png'),
	'blank' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'blank.png'),
	'extension' => array('type' => 'VARCHAR', 'constraint' => 5, 'default' => '.png'),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
	'credits' => array('type' => 'TEXT'),
	'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'genre' => array('type' => 'VARCHAR', 'constraint' => 10, 'default' => '', 'null' => true),
);

$fields_catalog_skins = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'credits' => array('type' => 'TEXT', 'null' => true),
	'version' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => true),
);

$fields_catalog_skinsecs = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'section' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
	'skin' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'preview' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
	'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'nav' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'dropdown'),
);

$fields_catalog_widgets = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'page' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'zone' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
	'credits' => array('type' => 'TEXT', 'null' => true),
);

$fields_characters = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
	'first_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'middle_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'last_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'suffix' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
	'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','pending','archived'", 'default' => 'pending'),
	'activated' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'deactivated' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'rank_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 1),
	'last_post' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_character_images = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'image' => array('type' => 'TEXT', 'null' => true),
	'primary_image' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
	'created_by' => array('type' => 'INT', 'constraint' => 11),
	'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_character_positions = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'position_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'primary' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
);

$fields_character_promotions = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'old_order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'old_rank' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'new_order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'new_rank' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_comments = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'type' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'item_id' => array('type' => 'INT', 'constraint' => 11),
	'content' => array('type' => 'TEXT', 'null' => true),
	'status' => array('type' => 'ENUM', 'constraint' => "'activated','pending'", 'default' => 'activated'),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_departments = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'type' => array('type' => 'ENUM', 'constraint' => "'playing','nonplaying'", 'default' => 'playing'),
	'parent_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
	'manifest_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 1),
);

$fields_forms = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'key' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'orientation' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'vertical'),
);

$fields_form_data = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
	'field_id' => array('type' => 'BIGINT', 'constraint' => 20),
	'user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'character_id' => array('type' => 'VARCHAR', 'constraint' => 11, 'null' => true),
	'item_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'value' => array('type' => 'TEXT', 'null' => true),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_form_fields = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
	'section_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'type' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'text'),
	'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'restriction' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'help' => array('type' => 'TEXT', 'null' => true),
	'selected' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
	'value' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'html_name' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'html_id' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'html_class' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => 'span4'),
	'html_rows' => array('type' => 'INT', 'constraint' => 3, 'default' => 5),
	'placeholder' => array('type' => 'TEXT', 'null' => true),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_form_sections = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
	'tab_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_form_tabs = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'form_key' => array('type' => 'VARCHAR', 'constraint' => 20),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'link_id' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_form_values = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'field_id' => array('type' => 'INT', 'constraint' => 11),
	'value' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'content' => array('type' => 'TEXT', 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
);

$fields_manifests = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
	'header_content' => array('type' => 'TEXT', 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
);

$fields_media = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'filename' => array('type' => 'TEXT', 'null' => true),
	'mime_type' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'resource_type' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16),
	'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_messages = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'subject' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'content' => array('type' => 'TEXT', 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_message_recipients = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'message_id' => array('type' => 'BIGINT', 'constraint' => 20),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'unread' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_missions = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'images' => array('type' => 'TEXT', 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'group_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'status' => array('type' => 'ENUM', 'constraint' => "'upcoming','current','completed'", 'default' => 'upcoming'),
	'start_date' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'end_date' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
	'summary' => array('type' => 'TEXT', 'null' => true),
	'notes' => array('type' => 'TEXT', 'null' => true),
	'notes_updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_mission_groups = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
	'parent_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
);

$fields_moderation = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'character_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'type' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_navigation = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'group' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'url' => array('type' => 'TEXT', 'null' => true),
	'url_target' => array('type' => 'ENUM', 'constraint' => "'onsite','offsite'", 'default' => 'onsite'),
	'needs_login' => array('type' => 'ENUM', 'constraint' => "'y','n','none'", 'default' => 'none'),
	'access' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'type' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'main'),
	'category' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'sim_type' => array('type' => 'INT', 'constraint' => 5, 'default' => 1),
);

$fields_personal_logs = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'content' => array('type' => 'TEXT', 'null' => true),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'status' => array('type' => 'ENUM', 'constraint' => "'activated','saved','pending'", 'default' => 'activated'),
	'tags' => array('type' => 'TEXT', 'null' => true),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_positions = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
	'dept_id' => array('type' => 'INT', 'constraint' => 11),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'open' => array('type' => 'INT', 'constraint' => 5, 'default' => 1),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'type' => array('type' => 'ENUM', 'constraint' => "'senior','officer','enlisted','other'", 'default' => 'officer'),
);

$fields_posts = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'timeline' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'date' => array('type' => 'BIGINT', 'constraint' => 20),
	'mission_id' => array('type' => 'INT', 'constraint' => 11),
	'saved_user_id' => array('type' => 'INT', 'null' => true),
	'status' => array('type' => 'ENUM', 'constraint' => "'activated','saved','pending'", 'default' => 'activated'),
	'content' => array('type' => 'TEXT', 'null' => true),
	'tags' => array('type' => 'TEXT', 'null' => true),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'participants' => array('type' => 'TEXT', 'null' => true),
	'lock_user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'lock_date' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
);

$fields_post_authors = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'post_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
);

$fields_ranks = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'short_name' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
	'image' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'class' => array('type' => 'INT', 'constraint' => 11, 'default' => 1),
);

$fields_sessions = array(
	'session_id' => array('type' => 'VARCHAR', 'constraint' => 40),
	'previous_id' => array('type' => 'VARCHAR', 'constraint' => 40),
	'user_agent' => array('type' => 'TEXT'),
	'ip_hash' => array('type' => 'CHAR', 'constraint' => 32),
	'created' => array('type' => 'INT', 'constraint' => 11),
	'updated' => array('type' => 'INT', 'constraint' => 11),
	'payload' => array('type' => 'LONGTEXT'),
);

$fields_settings = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'key' => array('type' => 'VARCHAR', 'constraint' => 100),
	'value' => array('type' => 'TEXT', 'null' => true),
	'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'help' => array('type' => 'TEXT', 'null' => true),
	'user_created' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
);

$fields_sim_types = array(
	'id' => array('type' => 'INT', 'constraint' => 2, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 50),
);

$fields_site_contents = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'key' => array('type' => 'VARCHAR', 'constraint' => 255),
	'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'content' => array('type' => 'TEXT', 'null' => true),
	'type' => array('type' => 'ENUM', 'constraint' => "'title','header','message','other'", 'default' => 'message'),
	'section' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
	'page' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'protected' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
);

$fields_specs = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'images' => array('type' => 'TEXT', 'null' => true),
	'summary' => array('type' => 'TEXT', 'null' => true),
);

$fields_system_info = array(
	'id' => array('type' => 'INT', 'constraint' => 1, 'auto_increment' => true),
	'uid' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => true),
	'install_date' => array('type' => 'BIGINT', 'constraint' => 20),
	'last_update' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'version_major' => array('type' => 'INT', 'constraint' => 1, 'default' => 3),
	'version_minor' => array('type' => 'INT', 'constraint' => 2),
	'version_update' => array('type' => 'INT', 'constraint' => 4),
	'version_ignore' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
);

$fields_system_events = array(
	'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
	'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'ip' => array('type' => 'VARCHAR', 'constraint' => 16),
	'user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'character_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'content' => array('type' => 'TEXT'),
	'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_tour = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'images' => array('type' => 'TEXT', 'null' => true),
	'summary' => array('type' => 'TEXT', 'null' => true),
	'spec_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
);

$fields_tour_decks = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
	'content' => array('type' => 'TEXT', 'null' => true),
	'tour_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
);

$fields_users = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'status' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'pending'),
	'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'email' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'password' => array('type' => 'VARCHAR', 'constraint' => 96, 'null' => true),
	'character_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
	'role_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
	'join_date' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'leave_date' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'last_post' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'last_login' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'password_reset_hash' => array('type' => 'VARCHAR', 'constraint' => 24, 'null' => true),
	'temp_password' => array('type' => 'VARCHAR', 'constraint' => 96, 'null' => true),
	'remember_me' => array('type' => 'VARCHAR', 'constraint' => 24, 'null' => true),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => true),
);

$fields_user_loas = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'start' => array('type' => 'BIGINT', 'constraint' => 20),
	'end' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'duration' => array('type' => 'TEXT', 'null' => true),
	'reason' => array('type' => 'TEXT', 'null' => true),
	'type' => array('type' => 'ENUM', 'constraint' => "'active','loa','eloa'", 'default' => 'loa'),
);

$fields_users_preferences = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
	'key' => array('type' => 'VARCHAR', 'constraint' => 50),
	'value' => array('type' => 'TEXT', 'null' => true),
);

$fields_users_suspended = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'login_id' => array('type' => 'VARCHAR', 'constraint' => 50),
	'attempts' => array('type' => 'INT', 'constraint' => 50),
	'ip' => array('type' => 'VARCHAR', 'constraint' => 16),
	'last_attempt_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'suspended_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'unsuspend_at' => array('type' => 'BIGINT', 'constraint' => 20),
);

$fields_wiki_categories = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'name' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	'desc' => array('type' => 'TEXT', 'null' => true),
);

$fields_wiki_drafts = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'id_old' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	'user_id' => array('type' => 'INT', 'constraint' => 11),
	'character_id' => array('type' => 'INT', 'constraint' => 11),
	'summary' => array('type' => 'TEXT', 'null' => true),
	'content' => array('type' => 'TEXT', 'null' => true),
	'page_id' => array('type' => 'INT', 'constraint' => 11),
	'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'categories' => array('type' => 'TEXT', 'null' => true),
	'change_comments' => array('type' => 'TEXT', 'null' => true),
);

$fields_wiki_pages = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'draft_id' => array('type' => 'INT', 'constraint' => 11),
	'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'created_by_user' => array('type' => 'INT', 'constraint' => 11),
	'created_by_character' => array('type' => 'INT', 'constraint' => 11),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'updated_by_user' => array('type' => 'INT', 'constraint' => 11),
	'updated_by_character' => array('type' => 'INT', 'constraint' => 11),
	'comments' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
	'type' => array('type' => 'ENUM', 'constraint' => "'standard','system'", 'default' => 'standard'),
	'key' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
);

$fields_wiki_restrictions = array(
	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
	'page_id' => array('type' => 'INT', 'constraint' => 11),
	'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
	'created_by' => array('type' => 'INT', 'constraint' => 11),
	'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
	'updated_by' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
	'restrictions' => array('type' => 'TEXT', 'null' => true),
);

