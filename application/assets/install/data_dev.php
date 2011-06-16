<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| INSTALL - DEV DATA
|---------------------------------------------------------------
|
| File: assets/install/install_data_dev.php
| System Version: 1.2.5
|
| Data file that includes all the data being inserted into the
| database after creating the tables.
|
*/

/*
|---------------------------------------------------------------
| Data array with the table/array names being used.
|---------------------------------------------------------------
*/
$data = array(
	'access_groups',
	'access_pages',
	'access_roles',
	'awards',
	'awards_queue',
	'awards_received',
	'catalogue_skins',
	'catalogue_skinsecs',
	'characters_data',
	'characters_fields',
	'characters_sections',
	'characters_tabs',
	'characters_values',
	'characters',
	'coc',
	'docking_fields',
	'docking_sections',
	'manifests',
	'menu_categories',
	'menu_items',
	'messages',
	'mission_groups',
	'missions',
	'news',
	'news_categories',
	'news_comments',
	'personallogs',
	'personallogs_comments',
	'user_prefs',
	'user_prefs_values',
	'users',
	'posts',
	'posts_comments',
	'security_questions',
	'settings',
	'sim_type',
	'specs_data',
	'specs_fields',
	'specs_sections',
	'system_components',
	'system_info',
	'system_versions',
	'tour',
	'tour_data',
	'tour_fields',
	'tour_decks'
);

/*
|---------------------------------------------------------------
| Arrays of data with the information being inserted into the
| database.
|---------------------------------------------------------------
*/

$access_groups = array(
	array(
		'group_name' => 'General Admin',
		'group_order' => 0),
	array(
		'group_name' => 'Writing Features',
		'group_order' => 1),
	array(
		'group_name' => 'Site Management',
		'group_order' => 2),
	array(
		'group_name' => 'Data Management',
		'group_order' => 3),
	array(
		'group_name' => 'Reports',
		'group_order' => 4),
	array(
		'group_name' => 'Characters',
		'group_order' => 5),
	array(
		'group_name' => 'Users',
		'group_order' => 6),
	array(
		'group_name' => 'Wiki',
		'group_order' => 7),
);

$access_roles = array(
	array(
		'role_name' => 'System Administrator',
		'role_access' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,31,33,35,36,37,38,39,40,41,42,43,44,45,46,49,50,53,55,56,58,60,63,64,65,66',
		'role_desc' => 'System administrators can take any action in the system. Only give this access level out to people you implicitly trust.'),
	array(
		'role_name' => 'Basic Administrator',
		'role_access' => '1,2,3,4,5,6,7,8,20,21,22,27,31,33,35,37,39,40,41,42,43,44,45,46,49,53,54,58,59,63,64',
		'role_desc' => 'Basic administrators have power to do some of the tasks system administrators do, but with more restrictions. This role is intended to be used for senior players on the RPG.'),
	array(
		'role_name' => 'Power User',
		'role_access' => '1,2,4,5,6,7,8,30,32,34,39,40,42,45,48,52,54,57,59,62',
		'role_desc' => 'Power users are users that can take more action than a standard user. This role is intended to be used for senior players on the RPG (department heads for example).'),
	array(
		'role_name' => 'Standard User',
		'role_access' => '1,2,4,5,6,7,8,30,32,34,39,40,42,45,51,54,57,59,61',
		'role_desc' => 'Standard users are generally the majority of players. This role gives them access to all the pieces they will need to play the game and use the system.'),
	array(
		'role_name' => 'Inactive User',
		'role_access' => '1,4,45,51,54,57',
		'role_desc' => 'Inactive players are players that have left the RPG. Instead of being completely locked out, the player can log in and take some very limited actions.')
);

$access_pages = array(
	array(
		'page_name' => "Admin Control Panel",
		'page_url' => 'admin/index',
		'page_group' => 1,
		'page_desc' => "Can access the admin control panel with recent posts, stats and other information"),
	array(
		'page_name' => "Upload Images",
		'page_url' => 'upload/index',
		'page_group' => 1,
		'page_desc' => "Can upload images to the server"),
	array(
		'page_name' => "Manage Uploads",
		'page_url' => 'upload/manage',
		'page_group' => 1,
		'page_desc' => "Can delete upload records"),
		
	array(
		'page_name' => "Private Messages",
		'page_url' => 'messages/index',
		'page_group' => 2,
		'page_desc' => "Can send and receive private messages"),
	array(
		'page_name' => "Writing Control Panel",
		'page_url' => 'write/index',
		'page_group' => 2,
		'page_desc' => "Can access the writing control panel with saved entries and recent posts"),
	array(
		'page_name' => "Write Mission Post",
		'page_url' => 'write/missionpost',
		'page_group' => 2,
		'page_desc' => "Can post a mission entry to the system"),
	array(
		'page_name' => "Write Personal Log",
		'page_url' => 'write/personallog',
		'page_group' => 2,
		'page_desc' => "Can post a personal log to the system"),
	array(
		'page_name' => "Write News Item",
		'page_url' => 'write/newsitem',
		'page_group' => 2,
		'page_desc' => "Can post a news items to the system"),
		
	array(
		'page_name' => "Site Settings",
		'page_url' => 'site/settings',
		'page_group' => 3,
		'page_desc' => "Can add, delete or edit any of the system settings"),
	array(
		'page_name' => "Site Messages",
		'page_url' => 'site/messages',
		'page_group' => 3,
		'page_desc' => "Can add, delete or edit any of the site messages for the system"),
	array(
		'page_name' => "Role Access",
		'page_url' => 'site/roles',
		'page_group' => 3,
		'page_desc' => "Can add, delete or edit access roles including access page sections and access pages"),
	array(
		'page_name' => "Bio/Join Form",
		'page_url' => 'site/bioform',
		'page_group' => 3,
		'page_desc' => "Can add to, edit or remove from the dynamic bio form including bio tabs and bio sections"),
	array(
		'page_name' => "Specs Form",
		'page_url' => 'site/specsform',
		'page_group' => 3,
		'page_desc' => "Can add to, edit or remove from the dynamic specifications form including specs sections"),
	array(
		'page_name' => "Tour Form",
		'page_url' => 'site/tourform',
		'page_group' => 3,
		'page_desc' => "Can add to, edit or remove from the dynamic tour form"),
	array(
		'page_name' => "Docking Form",
		'page_url' => 'site/dockingform',
		'page_group' => 3,
		'page_desc' => "Can add to, edit or remove from the dynamic docking form"),
	array(
		'page_name' => "Menus",
		'page_url' => 'site/menus',
		'page_group' => 3,
		'page_desc' => "Can add, delete and edit system menus"),
	array(
		'page_name' => "System Catalogue - Ranks",
		'page_url' => 'site/catalogueranks',
		'page_group' => 3,
		'page_desc' => "Can add, delete and edit system ranks"),
	array(
		'page_name' => "System Catalogue - Skins",
		'page_url' => 'site/catalogueskins',
		'page_group' => 3,
		'page_desc' => "Can add, delete and edit system skins"),
	array(
		'page_name' => "Manage Sim Types",
		'page_url' => 'site/simtypes',
		'page_group' => 3,
		'page_desc' => "Can add, delete and edit the different sim types"),
		
	array(
		'page_name' => "Specs",
		'page_url' => 'manage/specs',
		'page_group' => 4,
		'page_desc' => "Can update the specifications"),
	array(
		'page_name' => "Deck Listing",
		'page_url' => 'manage/decks',
		'page_group' => 4,
		'page_desc' => "Can add to, edit or remove from the deck listing"),
	array(
		'page_name' => "Manage Comments",
		'page_url' => 'manage/comments',
		'page_group' => 4,
		'page_desc' => "Can approve, delete and edit any comments"),
	array(
		'page_name' => "Manage Positions",
		'page_url' => 'manage/positions',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit positions"),
	array(
		'page_name' => "Manage Departments",
		'page_url' => 'manage/depts',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit departments"),
	array(
		'page_name' => "Manage Ranks",
		'page_url' => 'manage/ranks',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit ranks"),
	array(
		'page_name' => "Manage Awards",
		'page_url' => 'manage/awards',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit awards"),
	array(
		'page_name' => "Manage Tour Items",
		'page_url' => 'manage/tour',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit tour items"),
	array(
		'page_name' => "Manage Docked Items",
		'page_url' => 'manage/docked',
		'page_group' => 4,
		'page_desc' => "Can add, approve, delete, edit and reject docked items"),
	array(
		'page_name' => "Manage Missions",
		'page_url' => 'manage/missions',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit missions"),
	array(
		'page_name' => "Manage Mission Posts (Level 1)",
		'page_url' => 'manage/posts',
		'page_level' => 1,
		'page_group' => 4,
		'page_desc' => "Can delete and edit any of their own mission posts"),
	array(
		'page_name' => "Manage Mission Posts (Level 2)",
		'page_url' => 'manage/posts',
		'page_level' => 2,
		'page_group' => 4,
		'page_desc' => "Can delete and edit all mission posts in the system"),
	array(
		'page_name' => "Manage Personal Logs (Level 1)",
		'page_url' => 'manage/logs',
		'page_level' => 1,
		'page_group' => 4,
		'page_desc' => "Can delete and edit any of their own personal logs"),
	array(
		'page_name' => "Manage Personal Logs (Level 2)",
		'page_url' => 'manage/logs',
		'page_level' => 2,
		'page_group' => 4,
		'page_desc' => "Can delete and edit all personal logs in the system"),
	array(
		'page_name' => "Manage News Items (Level 1)",
		'page_url' => 'manage/news',
		'page_level' => 1,
		'page_group' => 4,
		'page_desc' => "Can delete and edit any of their own news items"),
	array(
		'page_name' => "Manage News Items (Level 2)",
		'page_url' => 'manage/news',
		'page_level' => 2,
		'page_group' => 4,
		'page_desc' => "Can delete and edit all news items in the system"),
	array(
		'page_name' => "Manage News Categories",
		'page_url' => 'manage/newscats',
		'page_group' => 4,
		'page_desc' => "Can manage all news categories available for news items"),
		
	array(
		'page_name' => "LOA Report",
		'page_url' => 'report/loa',
		'page_group' => 5,
		'page_desc' => "Can view a report on LOAs taken over the life of the system"),
	array(
		'page_name' => "System &amp; Versions",
		'page_url' => 'report/versions',
		'page_group' => 5,
		'page_desc' => "Can view a report on system information and all previous versions of the system"),
	array(
		'page_name' => "Crew Activity",
		'page_url' => 'report/activity',
		'page_group' => 5,
		'page_desc' => "Can view a report on active crew's activity levels"),
	array(
		'page_name' => "Posting Levels",
		'page_url' => 'report/posting',
		'page_group' => 5,
		'page_desc' => "Can view a report on posting levels for all playing characters"),
	array(
		'page_name' => "Moderation",
		'page_url' => 'report/moderation',
		'page_group' => 5,
		'page_desc' => "Can view a report on the moderation status of users"),
	array(
		'page_name' => "Milestones",
		'page_url' => 'report/milestones',
		'page_group' => 5,
		'page_desc' => "Can view a report on the milestones of users"),
	array(
		'page_name' => "Award Nominations",
		'page_url' => 'report/awardnominations',
		'page_group' => 5,
		'page_desc' => "Can view a report on all award nominations"),
	array(
		'page_name' => "Applications",
		'page_url' => 'report/applications',
		'page_group' => 5,
		'page_desc' => "Can view a report on all applications submitted through the system"),
	array(
		'page_name' => "Sim Statistics",
		'page_url' => 'report/stats',
		'page_group' => 5,
		'page_desc' => "Can view a report on sim statistics for the current and previous months"),
		
	array(
		'page_name' => "Character Management",
		'page_url' => 'characters/index',
		'page_group' => 6,
		'page_desc' => "Can manage all playing characters including accepting and rejecting applicants"),
	array(
		'page_name' => "NPC Management (Level 1)",
		'page_url' => 'characters/npcs',
		'page_level' => 1,
		'page_group' => 6,
		'page_desc' => "Can manage any non-playing characters in their primary department (first position only)"),
	array(
		'page_name' => "NPC Management (Level 2)",
		'page_url' => 'characters/npcs',
		'page_level' => 2,
		'page_group' => 6,
		'page_desc' => "Can manage any non-playing characters in any of their departments (first and second positions)"),
	array(
		'page_name' => "NPC Management (Level 3)",
		'page_url' => 'characters/npcs',
		'page_level' => 3,
		'page_group' => 6,
		'page_desc' => "Can manage all non-playing characters in the system"),
	array(
		'page_name' => "Chain of Command",
		'page_url' => 'characters/coc',
		'page_group' => 6,
		'page_desc' => "Can add, delete and edit the chain of command"),
	array(
		'page_name' => "Character Bio (Level 1)",
		'page_url' => 'characters/bio',
		'page_level' => 1,
		'page_group' => 6,
		'page_desc' => "Can edit the bio of any of their own characters"),
	array(
		'page_name' => "Character Bio (Level 2)",
		'page_url' => 'characters/bio',
		'page_level' => 2,
		'page_group' => 6,
		'page_desc' => "Can edit the bio of any of their characters as well as any NPC in the system"),
	array(
		'page_name' => "Character Bio (Level 3)",
		'page_url' => 'characters/bio',
		'page_level' => 3,
		'page_group' => 6,
		'page_desc' => "Can edit any character in the system, including rank and position"),
	array(
		'page_name' => "Create Character (Level 1)",
		'page_url' => 'characters/create',
		'page_level' => 1,
		'page_group' => 6,
		'page_desc' => "Can create playing and non-playing characters but playing characters require approval"),
	array(
		'page_name' => "Create Character (Level 2)",
		'page_url' => 'characters/create',
		'page_level' => 2,
		'page_group' => 6,
		'page_desc' => "Can create playing and non-playing characters without any approval"),
	array(
		'page_name' => "Give/Remove Award",
		'page_url' => 'characters/awards',
		'page_group' => 6,
		'page_desc' => "Can give/remove awards to/from any character in the system"),
	
	array(
		'page_name' => "User Account (Level 1)",
		'page_url' => 'user/account',
		'page_group' => 7,
		'page_level' => 1,
		'page_desc' => "Can update their own account settings"),
	array(
		'page_name' => "User Account (Level 2)",
		'page_url' => 'user/account',
		'page_group' => 7,
		'page_level' => 2,
		'page_desc' => "Can update any account in the system including moderation flags and admin items"),
	array(
		'page_name' => "Crew Award Nominations (Level 1)",
		'page_url' => 'user/nominate',
		'page_group' => 7,
		'page_level' => 1,
		'page_desc' => "Can nominate playing and non-playing characters for awards"),
	array(
		'page_name' => "Crew Award Nominations (Level 2)",
		'page_url' => 'user/nominate',
		'page_group' => 7,
		'page_level' => 2,
		'page_desc' => "Can nominate playing and non-playing characters for awards as well as approving/rejecting pending award nominations"),
		
	array(
		'page_name' => "Wiki Pages (Level 1)",
		'page_url' => 'wiki/page',
		'page_group' => 8,
		'page_level' => 1,
		'page_desc' => "Can create wiki pages and edit any pages they have created, including viewing history and reverting to previous drafts"),
	array(
		'page_name' => "Wiki Pages (Level 2)",
		'page_url' => 'wiki/page',
		'page_group' => 8,
		'page_level' => 2,
		'page_desc' => "Can create wiki pages and edit all pages, including viewing history and reverting to previous drafts"),
	array(
		'page_name' => "Wiki Pages (Level 3)",
		'page_url' => 'wiki/page',
		'page_group' => 8,
		'page_level' => 3,
		'page_desc' => "Can create, delete and edit all wiki pages, including viewing history and reverting to previous drafts"),
	array(
		'page_name' => "Wiki Categories",
		'page_url' => 'wiki/categories',
		'page_group' => 8,
		'page_desc' => "Can create, delete and edit wiki categories"),
		
	array(
		'page_name' => "Ban Controls",
		'page_url' => 'site/bans',
		'page_group' => 3,
		'page_desc' => "Can add or remove site bans"),
	array(
		'page_name' => "Site Manifests",
		'page_url' => 'site/manifests',
		'page_group' => 3,
		'page_desc' => "Can create, delete and edit site manifests"),
);

$awards = array(
	array(
		'award_name' => 'Silver Star',
		'award_order' => 0,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'ic',
		'award_image' => 'silver_star.jpg'),
	array(
		'award_name' => 'Bronze Medal',
		'award_order' => 1,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'both',
		'award_image' => 'bronze_medal.jpg')
);

$awards_queue = array(
	array(
		'queue_receive_character' => 2,
		'queue_receive_user' => 2,
		'queue_nominate' => 1,
		'queue_award' => 1,
		'queue_reason' => 'Jon definitely deserves the Silver Star because of what he did in our last mission.',
		'queue_status' => 'pending',
		'queue_date' => 1229483743),
	array(
		'queue_receive_character' => 1,
		'queue_receive_user' => 1,
		'queue_nominate' => 2,
		'queue_award' => 2,
		'queue_reason' => 'David deserves the Bronze Medal because he came in third in the race we were doing.',
		'queue_status' => 'pending',
		'queue_date' => 1229484743),
);

$awards_received = array(
	array(
		'awardrec_award' => 1,
		'awardrec_user' => 1,
		'awardrec_character' => 1,
		'awardrec_nominated_by' => 2,
		'awardrec_reason' => 'This is my first reason.',
		'awardrec_date' => 1229483743),
	array(
		'awardrec_award' => 2,
		'awardrec_user' => 1,
		'awardrec_character' => 1,
		'awardrec_nominated_by' => 2,
		'awardrec_reason' => 'This is my second reason.',
		'awardrec_date' => 1229483943),
	array(
		'awardrec_award' => 1,
		'awardrec_user' => 2,
		'awardrec_character' => 2,
		'awardrec_nominated_by' => 1,
		'awardrec_reason' => 'This is my third reason.',
		'awardrec_date' => 1229484143)
);

$catalogue_skins = array(
	array(
		'skin_name' => 'Pulsar',
		'skin_location' => 'default',
		'skin_credits' => 'The Pulsar skin was created by Anodyne Productions. Edits are permissible as long as original credits stay intact. The Pulsar skin includes the jQuery BlockUI plugin by Malsup. More information can be found at <a href="http://malsup.com/jquery/block/">http://malsup.com/jquery/block/</a>.'),
);

$catalogue_skinsecs = array(
	array(
		'skinsec_section' => 'main',
		'skinsec_skin' => 'default',
		'skinsec_image_preview' => 'preview-main.jpg',
		'skinsec_default' => 'y'),
	array(
		'skinsec_section' => 'admin',
		'skinsec_skin' => 'default',
		'skinsec_image_preview' => 'preview-admin.jpg',
		'skinsec_default' => 'y'),
	array(
		'skinsec_section' => 'wiki',
		'skinsec_skin' => 'default',
		'skinsec_image_preview' => 'preview-wiki.jpg',
		'skinsec_default' => 'y'),
	array(
		'skinsec_section' => 'login',
		'skinsec_skin' => 'default',
		'skinsec_image_preview' => 'preview-login.jpg',
		'skinsec_default' => 'y'),
);

$characters_data = array(
	array(
		'data_field' => 1,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Male'),
	array(
		'data_field' => 2,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Human'),
	array(
		'data_field' => 3,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => '59'),
	array(
		'data_field' => 4,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => '6\'0"'),
	array(
		'data_field' => 5,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => '225 lbs.'),
	array(
		'data_field' => 6,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Gray'),
	array(
		'data_field' => 7,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Brown'),
	array(
		'data_field' => 8,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
		
	array(
		'data_field' => 9,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => "Personality overview here.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."),
	array(
		'data_field' => 10,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => "Strengths and weaknesses go here.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."),
	array(
		'data_field' => 11,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => "Ambitions go here.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."),
	array(
		'data_field' => 12,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'All my hobbies and different interests go here.'),
		
	array(
		'data_field' => 13,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Father'),
	array(
		'data_field' => 14,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Mother'),
	array(
		'data_field' => 15,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Brother'),
	array(
		'data_field' => 16,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Sister'),
	array(
		'data_field' => 17,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => now(),
		'data_value' => 'Other Family'),
);

$characters_fields = array(
	array(
		'field_type' => 'select',
		'field_name' => 'gender',
		'field_fid' => 'gender',
		'field_label_page' => 'Gender',
		'field_order' => 1),
	array(
		'field_type' => 'text',
		'field_name' => 'species',
		'field_fid' => 'species',
		'field_class' => '',
		'field_label_page' => 'Species',
		'field_order' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'age',
		'field_fid' => 'age',
		'field_class' => 'small',
		'field_label_page' => 'Age',
		'field_order' => 3),
		
	array(
		'field_type' => 'text',
		'field_name' => 'height',
		'field_fid' => 'height',
		'field_class' => 'medium',
		'field_label_page' => 'Height',
		'field_order' => 1,
		'field_section' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'weight',
		'field_fid' => 'weight',
		'field_class' => 'medium',
		'field_label_page' => 'Weight',
		'field_order' => 2,
		'field_section' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'hair_color',
		'field_fid' => 'hair_color',
		'field_class' => '',
		'field_label_page' => 'Hair Color',
		'field_order' => 3,
		'field_section' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'eye_color',
		'field_fid' => 'eye_color',
		'field_class' => '',
		'field_label_page' => 'Eye Color',
		'field_order' => 4,
		'field_section' => 2),
	array(
		'field_type' => 'textarea',
		'field_name' => 'physical_desc',
		'field_fid' => 'physical_desc',
		'field_class' => '',
		'field_label_page' => 'Physical Description',
		'field_order' => 5,
		'field_section' => 2),
		
	array(
		'field_type' => 'textarea',
		'field_name' => 'personality',
		'field_fid' => 'personality',
		'field_class' => '',
		'field_label_page' => 'General Overview',
		'field_order' => 0,
		'field_section' => 4),
	array(
		'field_type' => 'textarea',
		'field_name' => 'strengths',
		'field_fid' => 'strengths',
		'field_class' => '',
		'field_label_page' => 'Strengths &amp; Weaknesses',
		'field_order' => 1,
		'field_section' => 4),
	array(
		'field_type' => 'textarea',
		'field_name' => 'ambitions',
		'field_fid' => 'ambitions',
		'field_class' => '',
		'field_label_page' => 'Ambitions',
		'field_order' => 2,
		'field_section' => 4),
	array(
		'field_type' => 'textarea',
		'field_name' => 'hobbies',
		'field_fid' => 'hobbies',
		'field_class' => '',
		'field_label_page' => 'Hobbies &amp; Interests',
		'field_order' => 3,
		'field_section' => 4),
		
	array(
		'field_type' => 'text',
		'field_name' => 'spouse',
		'field_fid' => 'spouse',
		'field_class' => '',
		'field_label_page' => 'Spouse',
		'field_order' => 0,
		'field_section' => 3),
	array(
		'field_type' => 'textarea',
		'field_name' => 'children',
		'field_fid' => 'children',
		'field_class' => '',
		'field_label_page' => 'Children',
		'field_order' => 1,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'father',
		'field_fid' => 'father',
		'field_class' => '',
		'field_label_page' => 'Father',
		'field_order' => 2,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'mother',
		'field_fid' => 'mother',
		'field_class' => '',
		'field_label_page' => 'Mother',
		'field_order' => 3,
		'field_section' => 3),
	array(
		'field_type' => 'textarea',
		'field_name' => 'brothers',
		'field_fid' => 'brothers',
		'field_class' => '',
		'field_label_page' => 'Brother(s)',
		'field_order' => 4,
		'field_section' => 3),
	array(
		'field_type' => 'textarea',
		'field_name' => 'sisters',
		'field_fid' => 'sisters',
		'field_class' => '',
		'field_label_page' => 'Sister(s)',
		'field_order' => 5,
		'field_section' => 3),
	array(
		'field_type' => 'textarea',
		'field_name' => 'other_family',
		'field_fid' => 'other_family',
		'field_class' => '',
		'field_label_page' => 'Other Family',
		'field_order' => 6,
		'field_section' => 3),
		
	array(
		'field_type' => 'textarea',
		'field_name' => 'history',
		'field_fid' => 'history',
		'field_class' => '',
		'field_label_page' => 'Personal History',
		'field_order' => 0,
		'field_section' => 5,
		'field_rows' => 15),
	array(
		'field_type' => 'textarea',
		'field_name' => 'service_record',
		'field_fid' => 'service_record',
		'field_class' => '',
		'field_label_page' => 'Service Record',
		'field_order' => 1,
		'field_section' => 5,
		'field_rows' => 15),
);

$characters_sections = array(
	array(
		'section_name' => 'Character Information',
		'section_order' => 0,
		'section_tab' => 1),
	array(
		'section_name' => 'Physical Appearance',
		'section_order' => 1,
		'section_tab' => 1),
	array(
		'section_name' => 'Family',
		'section_order' => 2,
		'section_tab' => 1),
	array(
		'section_name' => 'Personality &amp; Traits',
		'section_order' => 0,
		'section_tab' => 2),
	array(
		'section_name' => '',
		'section_order' => 0,
		'section_tab' => 3),
);

$characters_tabs = array(
	array(
		'tab_order' => 1,
		'tab_name' => 'Basic Info',
		'tab_link_id' => 'one'),
	array(
		'tab_order' => 2,
		'tab_name' => 'Personality',
		'tab_link_id' => 'two'),
	array(
		'tab_order' => 3,
		'tab_name' => 'History',
		'tab_link_id' => 'three'),
);

$characters_values = array(
	array(
		'value_field' => 1,
		'value_field_value' => 'Male',
		'value_content' => 'Male',
		'value_order' => 1),
	array(
		'value_field' => 1,
		'value_field_value' => 'Female',
		'value_content' => 'Female',
		'value_order' => 2),
	array(
		'value_field' => 1,
		'value_field_value' => 'Hermaphrodite',
		'value_content' => 'Hermaphrodite',
		'value_order' => 3),
	array(
		'value_field' => 1,
		'value_field_value' => 'Neuter',
		'value_content' => 'Neuter',
		'value_order' => 4)
);

$characters = array(
	array(
		'first_name' => 'William',
		'last_name' => 'Adama',
		'position_1' => 1,
		'rank' => 2,
		'date_activate' => now(),
		'user' => 1),
	array(
		'first_name' => 'Saul',
		'last_name' => 'Tigh',
		'position_1' => 2,
		'rank' => 4,
		'date_activate' => now(),
		'user' => 2),
	array(
		'first_name' => 'Lee',
		'last_name' => 'Adama',
		'position_1' => 9,
		'rank' => 6,
		'date_activate' => now(),
		'user' => 3),
	array(
		'first_name' => 'Kara',
		'last_name' => 'Thrace',
		'position_1' => 10,
		'rank' => 7,
		'date_activate' => now(),
		'user' => 4),
	array(
		'first_name' => 'Gaius',
		'last_name' => 'Baltar',
		'position_1' => 26,
		'rank' => 20,
		'crew_type' => 'npc',
		'date_activate' => now()),
	array(
		'first_name' => 'Karl',
		'last_name' => 'Agathon',
		'position_1' => 14,
		'rank' => 7,
		'date_activate' => now(),
		'user' => 5),
	array(
		'first_name' => 'Sharon',
		'last_name' => 'Valerii',
		'position_1' => 13,
		'rank' => 9,
		'date_activate' => now(),
		'user' => 5),
	array(
		'first_name' => 'Galen',
		'last_name' => 'Tyrol',
		'position_1' => 15,
		'rank' => 12,
		'date_activate' => now(),
		'user' => 2),
	array(
		'first_name' => 'Felix',
		'last_name' => 'Gaeta',
		'position_1' => 4,
		'rank' => 9,
		'date_activate' => now(),
		'user' => 4),
	array(
		'first_name' => 'Samuel',
		'last_name' => 'Anders',
		'position_1' => 11,
		'rank' => 10,
		'crew_type' => 'npc',
		'date_activate' => now()),
	array(
		'first_name' => 'Anastasia',
		'last_name' => 'Dualla',
		'position_1' => 5,
		'rank' => 15,
		'crew_type' => 'npc',
		'date_activate' => now()),
	array(
		'first_name' => 'Brendan',
		'last_name' => 'Costanza',
		'position_1' => 11,
		'rank' => 9,
		'crew_type' => 'npc',
		'date_activate' => now()),
	array(
		'first_name' => 'Louanne',
		'last_name' => 'Katraine',
		'position_1' => 10,
		'rank' => 7,
		'crew_type' => 'npc',
		'date_activate' => now()),
);

$coc = array(
	array(
		'coc_crew' => 1,
		'coc_order' => 1),
	array(
		'coc_crew' => 2,
		'coc_order' => 2),
	array(
		'coc_crew' => 3,
		'coc_order' => 3),
	array(
		'coc_crew' => 4,
		'coc_order' => 4)
);

$docking_fields = array(
	array(
		'field_type' => 'text',
		'field_name' => 'duration',
		'field_label_page' => 'Duration',
		'field_order' => 0,
		'field_section' => 1),
	array(
		'field_type' => 'textarea',
		'field_name' => 'reason',
		'field_label_page' => 'Reason for Docking',
		'field_order' => 1,
		'field_section' => 1),
);

$docking_sections = array(
	array(
		'section_name' => 'Details',
		'section_order' => 0)
);

$manifests = array(
	array(
		'manifest_name' => 'Primary Manifest',
		'manifest_desc' => "This is the primary manifest used by the sim.",
		'manifest_header_content' => "Update your manifest header content from the manifest management page.",
		'manifest_order' => 0,
		'manifest_display' => 'y',
		'manifest_default' => 'y'),
	array(
		'manifest_name' => 'Secondary Manifest',
		'manifest_desc' => "This is the secondary manifest used by the sim.",
		'manifest_header_content' => "Update your manifest header content from the manifest management page.",
		'manifest_order' => 1,
		'manifest_display' => 'y',
		'manifest_default' => 'n'),
	array(
		'manifest_name' => 'Tertiary Manifest',
		'manifest_desc' => "This is the tertiary manifest used by the sim.",
		'manifest_header_content' => "Update your manifest header content from the manifest management page.",
		'manifest_order' => 0,
		'manifest_display' => 'y',
		'manifest_default' => 'n'),
);

$menu_categories = array(
	array(
		'menucat_name' => 'Main',
		'menucat_order' => 0,
		'menucat_menu_cat' => 'main',
		'menucat_type' => 'sub'),
	array(
		'menucat_name' => 'Personnel',
		'menucat_order' => 1,
		'menucat_menu_cat' => 'personnel',
		'menucat_type' => 'sub'),
	array(
		'menucat_name' => 'The Sim',
		'menucat_order' => 2,
		'menucat_menu_cat' => 'sim',
		'menucat_type' => 'sub'),
	array(
		'menucat_name' => 'Admin Control Panel',
		'menucat_order' => 3,
		'menucat_menu_cat' => 'admin',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Write',
		'menucat_order' => 4,
		'menucat_menu_cat' => 'write',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Private Messages',
		'menucat_order' => 5,
		'menucat_menu_cat' => 'messages',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Site Management',
		'menucat_order' => 6,
		'menucat_menu_cat' => 'site',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Management',
		'menucat_order' => 7,
		'menucat_menu_cat' => 'manage',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Characters',
		'menucat_order' => 8,
		'menucat_menu_cat' => 'characters',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'User',
		'menucat_order' => 9,
		'menucat_menu_cat' => 'user',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Reports',
		'menucat_order' => 10,
		'menucat_menu_cat' => 'report',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Wiki',
		'menucat_order' => 11,
		'menucat_menu_cat' => 'wiki',
		'menucat_type' => 'sub'),
);

$menu_items = array(
	array(
		'menu_name' => 'Main',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'main/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Personnel',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'personnel/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Sim',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'sim/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Wiki',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'wiki/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main',
		'menu_display' => 'y'),
	array(
		'menu_name' => 'Search',
		'menu_group' => 0,
		'menu_order' => 4,
		'menu_link' => 'search/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Control Panel',
		'menu_group' => 0,
		'menu_order' => 5,
		'menu_link' => 'admin/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main',
		'menu_need_login' => 'y'),
	array(
		'menu_name' => 'Login',
		'menu_group' => 0,
		'menu_order' => 6,
		'menu_link' => 'login/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main',
		'menu_need_login' => 'n'),
	array(
		'menu_name' => 'Logout',
		'menu_group' => 0,
		'menu_order' => 7,
		'menu_link' => 'login/logout',
		'menu_sim_type' => 1,
		'menu_cat' => 'main',
		'menu_need_login' => 'y'),
		
	array(
		'menu_name' => 'Main',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'main/index',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'News',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'main/news',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Contact',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'main/contact',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Credits',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'main/credits',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Join',
		'menu_group' => 0,
		'menu_order' => 4,
		'menu_link' => 'main/join',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Search',
		'menu_group' => 0,
		'menu_order' => 5,
		'menu_link' => 'search/index',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
		
	array(
		'menu_name' => 'Manifest',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'personnel/index',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'personnel'),
	array(
		'menu_name' => 'Chain of Command',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'personnel/coc',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'personnel'),
	array(
		'menu_name' => 'Crew Awards',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'sim/awards',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'personnel'),
	array(
		'menu_name' => 'Join',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'main/join',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'personnel'),
	
	array(
		'menu_name' => 'The Sim',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'sim/index',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Missions',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'sim/missions',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Mission Groups',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'sim/missions/group',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Personal Logs',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'sim/listlogs',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Stats',
		'menu_group' => 0,
		'menu_order' => 4,
		'menu_link' => 'sim/stats',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Crew Awards',
		'menu_group' => 0,
		'menu_order' => 5,
		'menu_link' => 'sim/awards',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Tour',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'sim/tour',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Specifications',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'sim/specs',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Deck Listing',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'sim/decks',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Departments',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'sim/departments',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Docked Items',
		'menu_group' => 2,
		'menu_order' => 0,
		'menu_link' => 'sim/docked',
		'menu_sim_type' => 3,
		'menu_display' => 'n',
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Docking Request',
		'menu_group' => 2,
		'menu_order' => 1,
		'menu_link' => 'sim/dockingrequest',
		'menu_sim_type' => 3,
		'menu_display' => 'n',
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
		
	array(
		'menu_name' => 'Main Page',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'wiki/index',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Recent Changes',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'wiki/recent',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Categories',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'wiki/categories',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Manage Pages',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'wiki/managepages',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_use_access' => 'y',
		'menu_access' => 'wiki/page',
		'menu_need_login' => 'y',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Manage Categories',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'wiki/managecategories',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_use_access' => 'y',
		'menu_access' => 'wiki/categories',
		'menu_need_login' => 'y',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Create New Page',
		'menu_group' => 2,
		'menu_order' => 0,
		'menu_link' => 'wiki/page',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_use_access' => 'y',
		'menu_access' => 'wiki/page',
		'menu_need_login' => 'y',
		'menu_cat' => 'wiki'),
		
	array(
		'menu_name' => 'Control Panel',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'admin/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'admin',
		'menu_use_access' => 'y',
		'menu_access' => 'admin/index'),
	array(
		'menu_name' => "What's New",
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'admin/whatsnew',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'admin',
		'menu_use_access' => 'y',
		'menu_access' => 'admin/index'),
		
	array(
		'menu_name' => 'Writing Control Panel',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'write/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'write',
		'menu_use_access' => 'y',
		'menu_access' => 'write/index'),
	array(
		'menu_name' => 'Write Mission Post',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'write/missionpost',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'write',
		'menu_use_access' => 'y',
		'menu_access' => 'write/missionpost'),
	array(
		'menu_name' => 'Write Personal Log',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'write/personallog',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'write',
		'menu_use_access' => 'y',
		'menu_access' => 'write/personallog'),
	array(
		'menu_name' => 'Write News Item',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'write/newsitem',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'write',
		'menu_use_access' => 'y',
		'menu_access' => 'write/newsitem'),
		
	array(
		'menu_name' => 'Inbox',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'messages/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'messages',
		'menu_use_access' => 'y',
		'menu_access' => 'messages/index'),
	array(
		'menu_name' => 'Sent Messages',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'messages/index/sent',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'messages',
		'menu_use_access' => 'y',
		'menu_access' => 'messages/index'),
	array(
		'menu_name' => 'Write New Message',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'messages/write',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'messages',
		'menu_use_access' => 'y',
		'menu_access' => 'messages/index'),
		
	array(
		'menu_name' => 'Settings',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'site/settings',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/settings'),
	array(
		'menu_name' => 'Messages &amp; Titles',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'site/messages',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/messages'),
	array(
		'menu_name' => 'Menu Items',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'site/menus',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/menus'),
	array(
		'menu_name' => 'Access Roles',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'site/roles',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/roles'),
	array(
		'menu_name' => 'Ban Controls',
		'menu_group' => 0,
		'menu_order' => 4,
		'menu_link' => 'site/bans',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/bans'),
	array(
		'menu_name' => 'Site Manifests',
		'menu_group' => 0,
		'menu_order' => 5,
		'menu_link' => 'site/manifests',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/manifests'),
	array(
		'menu_name' => 'Bio Form',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'site/bioform',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/bioform'),
	array(
		'menu_name' => 'Specs Form',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'site/specsform',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/specsform'),
	array(
		'menu_name' => 'Tour Form',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'site/tourform',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/tourform'),
	array(
		'menu_name' => 'Docking Form',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'site/dockingform',
		'menu_sim_type' => 3,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/dockingform'),
	array(
		'menu_name' => 'Sim Types',
		'menu_group' => 2,
		'menu_order' => 0,
		'menu_link' => 'site/simtypes',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/simtypes'),
	array(
		'menu_name' => 'Rank Catalogue',
		'menu_group' => 2,
		'menu_order' => 1,
		'menu_link' => 'site/catalogueranks',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/catalogueranks'),
	array(
		'menu_name' => 'Skin Catalogue',
		'menu_group' => 2,
		'menu_order' => 2,
		'menu_link' => 'site/catalogueskins',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/catalogueskins'),
		
	array(
		'menu_name' => 'Awards',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'manage/awards',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/awards'),
	array(
		'menu_name' => 'Departments',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'manage/depts',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/depts'),
	array(
		'menu_name' => 'Positions',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'manage/positions',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/positions'),
	array(
		'menu_name' => 'Ranks',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'manage/ranks',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/ranks'),
	array(
		'menu_name' => 'Missions',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'manage/missions',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/missions'),
	array(
		'menu_name' => 'Mission Groups',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'manage/missiongroups',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/missions'),
	array(
		'menu_name' => 'Mission Posts',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'manage/posts',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/posts'),
	array(
		'menu_name' => 'Personal Logs',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'manage/logs',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/logs'),
	array(
		'menu_name' => 'News Items',
		'menu_group' => 1,
		'menu_order' => 4,
		'menu_link' => 'manage/news',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/news'),
	array(
		'menu_name' => 'News Categories',
		'menu_group' => 1,
		'menu_order' => 5,
		'menu_link' => 'manage/newscats',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/newscats'),
	array(
		'menu_name' => 'Comments',
		'menu_group' => 1,
		'menu_order' => 6,
		'menu_link' => 'manage/comments',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/comments'),
	array(
		'menu_name' => 'Specs',
		'menu_group' => 2,
		'menu_order' => 0,
		'menu_link' => 'manage/specs',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/specs'),
	array(
		'menu_name' => 'Tour',
		'menu_group' => 2,
		'menu_order' => 1,
		'menu_link' => 'manage/tour',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/tour'),
	array(
		'menu_name' => 'Deck Listing',
		'menu_group' => 2,
		'menu_order' => 2,
		'menu_link' => 'manage/decks',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/decks'),
	array(
		'menu_name' => 'Docked Items',
		'menu_group' => 2,
		'menu_order' => 3,
		'menu_link' => 'manage/docked',
		'menu_sim_type' => 3,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'n',
		'menu_access' => 'manage/docked'),
		
	array(
		'menu_name' => 'Upload Images',
		'menu_group' => 3,
		'menu_order' => 0,
		'menu_link' => 'upload/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'n'),
	array(
		'menu_name' => 'Manage Uploads',
		'menu_group' => 3,
		'menu_order' => 1,
		'menu_link' => 'upload/manage',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'upload/manage'),
		
	array(
		'menu_name' => 'All Characters',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'characters/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/index'),
	array(
		'menu_name' => 'All NPCs',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'characters/npcs',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/npcs'),
	array(
		'menu_name' => 'Create Character',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'characters/create',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/create'),
	array(
		'menu_name' => 'Chain of Command',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'characters/coc',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/coc'),
	array(
		'menu_name' => 'Give/Remove Awards',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'characters/awards',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/awards'),
		
	array(
		'menu_name' => 'My Account',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'user/account',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account'),
	array(
		'menu_name' => 'My Bio',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'characters/bio',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/bio'),
	array(
		'menu_name' => 'Site Options',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'user/options',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account'),
	array(
		'menu_name' => 'Request LOA',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'user/status',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account'),
	array(
		'menu_name' => 'Award Nominations',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'user/nominate',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/nominate'),
	array(
		'menu_name' => 'All Users',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'user/all',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account',
		'menu_access_level' => 2),
	array(
		'menu_name' => 'Link Characters',
		'menu_group' => 1,
		'menu_order' => 4,
		'menu_link' => 'user/characterlink',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account',
		'menu_access_level' => 2),
		
	array(
		'menu_name' => 'Crew Activity',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'report/activity',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/activity'),
	array(
		'menu_name' => 'Posting Levels',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'report/posting',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/posting'),
	array(
		'menu_name' => 'Sim Statistics',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'report/stats',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/stats'),
	array(
		'menu_name' => 'Moderation',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'report/moderation',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/moderation'),
	array(
		'menu_name' => 'Milestones',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'report/milestones',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/milestones'),
	array(
		'menu_name' => 'LOA Records',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'report/loa',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/loa'),
	array(
		'menu_name' => 'Award Nominations',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'report/awardnominations',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/awardnominations'),
	array(
		'menu_name' => 'Applications',
		'menu_group' => 1,
		'menu_order' => 4,
		'menu_link' => 'report/applications',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/applications'),
	array(
		'menu_name' => 'System &amp; Versions',
		'menu_group' => 1,
		'menu_order' => 5,
		'menu_link' => 'report/versions',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/versions'),
);

$messages = array(
	array(
		'message_key' => 'welcome_msg',
		'message_label' => 'Welcome Page Message',
		'message_content' => "Define your welcome message through the Site Messages page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'sim',
		'message_label' => 'Sim Message',
		'message_content' => "Define your sim message through the Site Messages page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'wiki_main',
		'message_label' => 'Wiki Main Page Message',
		'message_content' => "Welcome to Thresher Release 1, Anodyne's integrated mini-wiki included with Nova. You can change this message through the Site Messages page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'credits_perm',
		'message_label' => 'Permanent Credits',
		'message_content' => "Nova has been developed on the <a href='http://www.codeigniter.com' target='_blank'>CodeIgniter</a> PHP framework by <a href='http://www.ellislab.com' target='_blank'>EllisLab</a>.\r\n\r\nIcons used throughout Nova were created by <a href='http://www.famfamfam.com'>FamFamFam</a> and <a href='http://www.pinvoke.com'>Pinvoke</a>.",
		'message_protected' => 'y',
		'message_type' => 'message'),
	array(
		'message_key' => 'credits',
		'message_label' => 'Credits',
		'message_content' => "Define your site credits through the Site Messages page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'join_disclaimer',
		'message_label' => 'Join Disclaimer',
		'message_content' => "Members are expected to follow the rules and regulations of both the sim and fleet at all times, both in character and out of character. By continuing, you affirm that you will sim in a proper and adequate manner. Members who choose to make ultra short posts, post very infrequently, or post posts with explicit content (above PG-13) will be removed immediately, and by continuing, you agree to this. In addition, in compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), we do not accept players under the age of 13.  Any players found to be under the age of 13 will be immediately removed without question.  By agreeing to these terms, you are also saying that you are above the age of 13.",
		'message_type' => 'other'),
	array(
		'message_key' => 'join_instructions',
		'message_label' => 'Join Instructions',
		'message_content' => "Define your join instructions through the Site Message page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'join_post',
		'message_label' => 'Join Sample Post',
		'message_content' => "Define your join sample post through the Site Message page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'accept_message',
		'message_label' => 'User Acceptance Email',
		'message_content' => "Define your user acceptance message through the Site Message page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'reject_message',
		'message_label' => 'User Rejection Message',
		'message_content' => "Define your user rejection message through the Site Messages page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'docking_accept_message',
		'message_label' => 'Docking Acceptance Email',
		'message_content' => "Define your docking acceptance message through the Site Message page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'docking_reject_message',
		'message_label' => 'Docking Rejection Message',
		'message_content' => "Define your docking rejection message through the Site Messages page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'contact',
		'message_label' => 'Contact Instructions',
		'message_content' => 'Please use the form below to contact the sim with questions. You can choose to email the game master, the command staff, or the webmaster with your questions and/or comments.',
		'message_type' => 'message'),
	
	array(
		'message_key' => 'welcome_head',
		'message_label' => 'Welcome Header',
		'message_content' => "Welcome to Nova Beta!",
		'message_type' => 'title'),
	array(
		'message_key' => 'main_credits_title',
		'message_label' => 'Site Credits Header',
		'message_content' => 'Site Credits',
		'message_type' => 'title'),
	array(
		'message_key' => 'main_join_title',
		'message_label' => 'Join Page Header',
		'message_content' => 'Join',
		'message_type' => 'title'),
);

$mission_groups = array(
	array(
		'misgroup_name' => 'Mission Group 1',
		'misgroup_order' => 0,
		'misgroup_desc' => 'This is the first mission group I have'),
	array(
		'misgroup_name' => 'Mission Group 2',
		'misgroup_order' => 1,
		'misgroup_desc' => 'This is the second mission group I have'),
);

$missions = array(
	array(
		'mission_title' => 'Encounter at Farpoint',
		'mission_images' => 'yellow.jpg, green.jpg',
		'mission_order' => 0,
		'mission_status' => 'completed',
		'mission_start' => 1167631200,
		'mission_end' => 1170309600,
		'mission_group' => 1,
		'mission_desc' => "Captain Jean-Luc Picard leads the crew of the USS Enterprise-D on its maiden voyage, to examine a new planetary station for trade with the Federation. On the way, they encounter Q, an omnipotent extra-dimensional being, who challenges humanity as a barbaric, inferior species. Picard and his new crew must hold off Q's challenge and solve the puzzle of Farpoint station on Deneb IV, a base that is far more than it seems to be."),
	array(
		'mission_title' => 'The Naked Now',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 1,
		'mission_status' => 'completed',
		'mission_start' => 1170309600,
		'mission_end' => 1172728800,
		'mission_group' => 1,
		'mission_desc' => "The crew of the Enterprise is subjected to an exotic illness that drives them to unusual manic behavior."),
	array(
		'mission_title' => 'Code of Honor',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 2,
		'mission_status' => 'completed',
		'mission_start' => 1172728800,
		'mission_end' => 1175403600,
		'mission_group' => 2,
		'mission_desc' => "A mission of mercy is jeopardized when a planetary ruler decides he wants an Enterprise officer as his wife."),
	array(
		'mission_title' => 'The Last Outpost',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 3,
		'mission_status' => 'completed',
		'mission_start' => 1175403600,
		'mission_end' =>  1177995600,
		'mission_group' => 1,
		'mission_desc' => "In pursuit of Ferengi marauders, the Enterprise and its quarry become trapped by a mysterious planet that is draining both ship's energies."),
	array(
		'mission_title' => 'Where No One Has Gone Before',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 4,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_desc' => "When a specialist in propulsion makes modifications to the Enterprise's warp drive that send it 2.7 million light years out of the galaxy, it is his assistant, a mysterious alien, and Wesley Crusher that must bring it back home."),
	array(
		'mission_title' => 'Lonely Among Us',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 5,
		'mission_status' => 'completed',
		'mission_start' => 1180674000,
		'mission_end' =>  1183266000,
		'mission_desc' => "While transporting delegates, Picard and his crew are enveloped by a cloud that seizes control of their minds and alters their behavior."),
	array(
		'mission_title' => 'Justice',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 6,
		'mission_status' => 'completed',
		'mission_start' => 1183266000,
		'mission_end' =>  1185944400,
		'mission_desc' => "The Enterprise takes shore leave on a pleasurable and peaceful planet. However, things quickly turn ugly when Wesley Crusher is sentenced to death for a seemingly slight rules violation."),
	array(
		'mission_title' => 'The Battle',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 7,
		'mission_status' => 'completed',
		'mission_start' => 1185944400,
		'mission_end' =>  1188622800,
		'mission_desc' => "A Ferengi captain returns the abandoned Stargazer to its former captain, Jean-Luc Picard. Picard, who experiences severe headaches, begins to relive the \"Battle of Maxia\" in which he lost the ship."),
	array(
		'mission_title' => 'Hide and Q',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 8,
		'mission_status' => 'completed',
		'mission_start' => 1188622800,
		'mission_end' => 1191214800,
		'mission_desc' => "Q returns to the Enterprise to tempt Commander Riker into joining the Q Continuum with the lure of Q's powers."),
	array(
		'mission_title' => 'Haven',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 9,
		'mission_status' => 'completed',
		'mission_start' => 1191214800,
		'mission_end' => 1193893200,
		'mission_desc' => "Lwaxana Troi visits her daughter, Counselor Troi, and prepares her for an arranged marriage."),
	array(
		'mission_title' => 'The Big Goodbye',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 10,
		'mission_status' => 'completed',
		'mission_start' => 1193893200,
		'mission_end' => 1196488800,
		'mission_desc' => "A computer malfunction traps Picard, Data, and Beverly in a Dixon Hill holodeck program set in early 20th-century Earth."),
	array(
		'mission_title' => 'Datalore',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 11,
		'mission_status' => 'completed',
		'mission_start' => 1196488800,
		'mission_end' => 1199167200,
		'mission_desc' => "The Enterprise crew finds a disassembled android identical to Data at the site of the Omicron Theta colony—where Data was found—which was destroyed by a life form dubbed \"the Crystalline Entity.\" The reassembled android, Lore, brings the Crystalline Entity to the Enterprise."),
	array(
		'mission_title' => 'Angel One',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 12,
		'mission_status' => 'completed',
		'mission_start' => 1199167200,
		'mission_end' => 1201845600,
		'mission_desc' => "The Enterprise visits a world dominated by women to rescue survivors of a downed freighter."),
	array(
		'mission_title' => '11001001',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 13,
		'mission_status' => 'completed',
		'mission_start' => 1201845600,
		'mission_end' => 1204351200,
		'mission_desc' => "Bynars upgrade the Enterprise's computers in spacedock. Riker and Picard become distracted by a surprisingly realistic holodeck character."),
	array(
		'mission_title' => 'Too Short a Season',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 14,
		'mission_status' => 'completed',
		'mission_start' => 1204351200,
		'mission_end' => 1207026000,
		'mission_desc' => "The Enterprise transports a legendary geriatric admiral who must once again negotiate a hostage situation involving a man from decades earlier in his career. The admiral is mysteriously growing younger; by the time the Enterprise arrives he is a young man."),
	array(
		'mission_title' => 'When the Bough Breaks',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 15,
		'mission_status' => 'completed',
		'mission_start' => 1207026000,
		'mission_end' => 1209618000,
		'mission_desc' => "A planet formerly existing only in legend uncloaks and requests help from the Enterprise. Their cloaking device causes sterility, and they want to adopt children from the Enterprise - by force, if necessary."),
	array(
		'mission_title' => 'Home Soil',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 16,
		'mission_status' => 'completed',
		'mission_start' => 1209618000,
		'mission_end' => 1212296400,
		'mission_desc' => "The crew of the Enterprise discovers a crystalline lifeform with murderous intelligence that has been killing the scientists on a terraforming project."),
	array(
		'mission_title' => 'Coming of Age',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 17,
		'mission_status' => 'completed',
		'mission_start' => 1212296400,
		'mission_end' => 1214888400,
		'mission_desc' => "While Wesley takes a Starfleet Academy entrance exam, the senior staff of the Enterprise are placed under investigation by Starfleet."),
	array(
		'mission_title' => 'Heart of Glory',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 18,
		'mission_status' => 'completed',
		'mission_start' => 1214888400,
		'mission_end' => 1217566800,
		'mission_desc' => "Fugitive Klingons seeking battle attempt to hijack the Enterprise, and ask Worf to join them."),
	array(
		'mission_title' => 'The Arsenal of Freedom',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 19,
		'mission_status' => 'completed',
		'mission_start' => 1217566800,
		'mission_end' => 1217566800,
		'mission_desc' => "Trapped on the surface of an abandoned planet, an away team becomes unwitting participants in the demonstration of an advanced weapons system."),
	array(
		'mission_title' => 'Symbiosis',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 20,
		'mission_status' => 'completed',
		'mission_start' => 1217566800,
		'mission_end' => 1220245200,
		'mission_desc' => "Picard tries to mediate a trade dispute between two neighboring planets, one of which it is the sole supplier of a drug to treat the other's apparently fatal disease."),
	array(
		'mission_title' => 'Skin of Evil',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 21,
		'mission_status' => 'completed',
		'mission_start' => 1220245200,
		'mission_end' => 1222837200,
		'mission_desc' => "An evil, tar-like creature holds Troi hostage on an alien world. During a rescue mission, one of the Enterprise crew is killed."),
	array(
		'mission_title' => "We'll Always Have Paris",
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 22,
		'mission_status' => 'completed',
		'mission_start' => 1222837200,
		'mission_end' => 1225515600,
		'mission_desc' => "Picard meets an old flame, whose husband has been affected by a dimensional experiment accident."),
	array(
		'mission_title' => "Conspiracy",
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 23,
		'mission_status' => 'current',
		'mission_start' => 1225515600,
		'mission_desc' => "The strange behavior of high-ranking officers - which earlier prompted the investigation of the crew (in \"Coming of Age\") - leads Picard to uncover a conspiracy within Starfleet."),
	array(
		'mission_title' => "The Neutral Zone",
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 24,
		'mission_status' => 'upcoming',
		'mission_desc' => "A derelict satellite is found containing cryonically frozen humans from the 20th century as the Enterprise is sent to investigate the destruction of outposts near Romulan space."),
);

$news = array(
	array(
		'news_title' => 'Welcome to Nova',
		'news_author_user' => 1,
		'news_author_character' => 1,
		'news_content' => "Nova is the start of something very special and something that's going to make a big difference in the way that people manage their RPGs. No more is Anodyne focusing on Star Trek; now, we are providing a multitude of genres for game masters to choose from. We're offering everything from DS9 to Enterprise to Battlestar Galactica. Check out Nova and RPG management evolved.",
		'news_date' => 1229483743,
		'news_cat' => 1,
		'news_status' => 'activated'),
	array(
		'news_title' => 'Nova Says Hello to Comments',
		'news_author_user' => 1,
		'news_author_character' => 1,
		'news_content' => "One of the new features that's found its way into Nova is comments. Users are now able to leave comments on personal logs, news items, and mission posts. Later on, comments will be available on the wiki as well!",
		'news_date' => 1229484743,
		'news_cat' => 1,
		'news_status' => 'activated'),
	array(
		'news_title' => 'Nova Goes Private',
		'news_author_user' => 1,
		'news_author_character' => 1,
		'news_private' => 'y',
		'news_content' => "A feature that's making it's way over from SMS is private news items. Sometimes, you just don't want everyone to see what you're telling the crew, or you need an easy way to get in touch with all of them quickly. Private news items insure that only your crew can see the news item. If a user navigates to the page, they won't ever know that there are more news items than what's shown.",
		'news_date' => 1229485743,
		'news_cat' => 4,
		'news_status' => 'activated')
);

$news_categories = array(
	array('newscat_name' => 'General News'),
	array('newscat_name' => 'Out of Character'),
	array('newscat_name' => 'Sim Announcement'),
	array('newscat_name' => 'Website Update')
);

$news_comments = array(
	array(
		'ncomment_author_user' => 2,
		'ncomment_author_character' => 2,
		'ncomment_news' => 1,
		'ncomment_content' => "This is really cool to hear! I've been running a BSG sim for a couple years now and it's kind of frustrating that I've had to modify SMS 2 so much, especially when a new release comes out. Nova should make things a lot easier. Thank you!",
		'ncomment_date' => 1229483783),
	array(
		'ncomment_author_user' => 1,
		'ncomment_author_character' => 1,
		'ncomment_news' => 1,
		'ncomment_content' => "No problem! That's the whole goal of Nova - to make it easier. Though if you're still using SMS 2, you'll definitely want to check out the official BSG MOD that we released. It'll turn SMS 2 into a BSG sim in a couple of minutes. Enjoy!",
		'ncomment_date' => 1229483813)
);

$personallogs = array(
	array(
		'log_title' => 'First Personal Log',
		'log_author_user' => 1,
		'log_author_character' => 1,
		'log_content' => 'This is the content of my first personal log!',
		'log_date' => 1229483743),
	array(
		'log_title' => 'Second Personal Log',
		'log_author_user' => 2,
		'log_author_character' => 2,
		'log_content' => 'This is the content of the second personal log!',
		'log_date' => 1229483843)
);

$personallogs_comments = array(
	array(
		'lcomment_author_character' => 2,
		'lcomment_author_user' => 2,
		'lcomment_log' => 1,
		'lcomment_content' => 'Very good first personal log!',
		'lcomment_date' => 1229483843),
	array(
		'lcomment_author_character' => 1,
		'lcomment_author_user' => 1,
		'lcomment_log' => 1,
		'lcomment_content' => 'Thank you, I really enjoyed writing this one! You should give it a try sometime.',
		'lcomment_date' => 1229483943),
	array(
		'lcomment_author_character' => 2,
		'lcomment_author_user' => 2,
		'lcomment_log' => 1,
		'lcomment_content' => "I was actually thinking about it.\r\n\r\nWhat do you think I should write mine about though?",
		'lcomment_date' => 1229484143)
);

$user_prefs = array(
	array(
		'pref_key' => 'email_new_news_comments',
		'pref_label' => 'Email News Comments',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_new_log_comments',
		'pref_label' => 'Email Log Comments',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_new_post_comments',
		'pref_label' => 'Email Post Comments',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_new_wiki_comments',
		'pref_label' => 'Email Wiki Comments',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_private_message',
		'pref_label' => 'Email Private Messages',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_personal_logs',
		'pref_label' => 'Email Personal Logs',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_news_items',
		'pref_label' => 'Email News Items',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_mission_posts',
		'pref_label' => 'Email Mission Posts',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_mission_posts_save',
		'pref_label' => 'Email Mission Post Saved Notifications',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_mission_posts_delete',
		'pref_label' => 'Email Mission Post Delete Notifications',
		'pref_default' => 'y'),
);

$user_prefs_values = array();

$users = array(
	array(
		'name' => 'John Doe',
		'email' => 'john@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 1,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UTC'),
	array(
		'name' => 'Jane Doe',
		'email' => 'jane@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 2,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UM8'),
	array(
		'name' => 'Bill Doe',
		'email' => 'bill@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 3,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UM3'),
	array(
		'name' => 'Deb Doe',
		'email' => 'deb@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 4,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UM10'),
	array(
		'name' => 'Joe Doe',
		'email' => 'joe@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 5,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UM2'),
);

$posts = array(
	array(
		'post_title' => '101-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1167631200,
		'post_mission' => 1),
	array(
		'post_title' => '101-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1167632200,
		'post_mission' => 1),
	array(
		'post_title' => '101-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1167633200,
		'post_mission' => 1),
	array(
		'post_title' => '101-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1167634200,
		'post_mission' => 1),
	
	array(
		'post_title' => '102-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1170309600,
		'post_mission' => 2),
	array(
		'post_title' => '102-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1170310600,
		'post_mission' => 2),
	array(
		'post_title' => '102-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1170311600,
		'post_mission' => 2),
	array(
		'post_title' => '102-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1170312600,
		'post_mission' => 2),
		
	array(
		'post_title' => '103-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1172729800,
		'post_mission' => 3),
	array(
		'post_title' => '103-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1172730800,
		'post_mission' => 3),
	array(
		'post_title' => '103-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1172731800,
		'post_mission' => 3),
	array(
		'post_title' => '103-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1172732800,
		'post_mission' => 3),
		
	array(
		'post_title' => '104-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1175403600,
		'post_mission' => 4),
	array(
		'post_title' => '104-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1175404600,
		'post_mission' => 4),
	array(
		'post_title' => '104-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1175405600,
		'post_mission' => 4),
	array(
		'post_title' => '104-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1175406600,
		'post_mission' => 4),
	
	array(
		'post_title' => '105-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1177995600,
		'post_mission' => 5),
	array(
		'post_title' => '105-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1177996600,
		'post_mission' => 5),
	array(
		'post_title' => '105-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1177997600,
		'post_mission' => 5),
	array(
		'post_title' => '105-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1177998600,
		'post_mission' => 5),
		
	array(
		'post_title' => '106-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1180674000,
		'post_mission' => 6),
	array(
		'post_title' => '103-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1180675000,
		'post_mission' => 6),
	array(
		'post_title' => '106-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1180676000,
		'post_mission' => 6),
	array(
		'post_title' => '106-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1180677000,
		'post_mission' => 6),
		
	array(
		'post_title' => '107-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1183266000,
		'post_mission' => 7),
	array(
		'post_title' => '107-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1183267000,
		'post_mission' => 7),
	array(
		'post_title' => '107-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1183268000,
		'post_mission' => 7),
	array(
		'post_title' => '107-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1183269000,
		'post_mission' => 7),
	
	array(
		'post_title' => '108-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1185944400,
		'post_mission' => 8),
	array(
		'post_title' => '108-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1185945400,
		'post_mission' => 8),
	array(
		'post_title' => '108-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1185946400,
		'post_mission' => 8),
	array(
		'post_title' => '108-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1185947400,
		'post_mission' => 8),
		
	array(
		'post_title' => '109-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1188622800,
		'post_mission' => 9),
	array(
		'post_title' => '109-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1188623800,
		'post_mission' => 9),
	array(
		'post_title' => '109-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1188624800,
		'post_mission' => 9),
	array(
		'post_title' => '109-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1188625800,
		'post_mission' => 9),
		
	array(
		'post_title' => '110-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1191214800,
		'post_mission' => 10),
	array(
		'post_title' => '110-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1191215800,
		'post_mission' => 10),
	array(
		'post_title' => '110-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1191216800,
		'post_mission' => 10),
	array(
		'post_title' => '110-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1191217800,
		'post_mission' => 10),
	
	array(
		'post_title' => '111-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1193893200,
		'post_mission' => 11),
	array(
		'post_title' => '111-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1193894200,
		'post_mission' => 11),
	array(
		'post_title' => '111-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1193895200,
		'post_mission' => 11),
	array(
		'post_title' => '111-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1193896200,
		'post_mission' => 11),
		
	array(
		'post_title' => '112-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1196488800,
		'post_mission' => 12),
	array(
		'post_title' => '112-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1196489800,
		'post_mission' => 12),
	array(
		'post_title' => '112-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1196490800,
		'post_mission' => 12),
	array(
		'post_title' => '112-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1196491800,
		'post_mission' => 12),
		
	array(
		'post_title' => '113-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1199167200,
		'post_mission' => 13),
	array(
		'post_title' => '113-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1199168200,
		'post_mission' => 13),
	array(
		'post_title' => '113-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1199169200,
		'post_mission' => 13),
	array(
		'post_title' => '113-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1199170200,
		'post_mission' => 13),
	
	array(
		'post_title' => '114-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1201845600,
		'post_mission' => 14),
	array(
		'post_title' => '114-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1201846600,
		'post_mission' => 14),
	array(
		'post_title' => '114-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1201847600,
		'post_mission' => 14),
	array(
		'post_title' => '114-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1201848600,
		'post_mission' => 14),
		
	array(
		'post_title' => '115-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1204351200,
		'post_mission' => 15),
	array(
		'post_title' => '115-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1204352200,
		'post_mission' => 15),
	array(
		'post_title' => '115-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1204353200,
		'post_mission' => 15),
	array(
		'post_title' => '115-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1204354200,
		'post_mission' => 15),
		
	array(
		'post_title' => '116-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1207026000,
		'post_mission' => 16),
	array(
		'post_title' => '116-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1207027000,
		'post_mission' => 16),
	array(
		'post_title' => '116-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1207028000,
		'post_mission' => 6),
	array(
		'post_title' => '116-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1207029000,
		'post_mission' => 16),
	
	array(
		'post_title' => '117-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1209618000,
		'post_mission' => 17),
	array(
		'post_title' => '117-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1209619000,
		'post_mission' => 17),
	array(
		'post_title' => '117-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1209620000,
		'post_mission' => 17),
	array(
		'post_title' => '117-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1209621000,
		'post_mission' => 17),
		
	array(
		'post_title' => '118-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1212296400,
		'post_mission' => 18),
	array(
		'post_title' => '118-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1212297400,
		'post_mission' => 18),
	array(
		'post_title' => '118-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1212298400,
		'post_mission' => 18),
	array(
		'post_title' => '118-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1212299400,
		'post_mission' => 18),
		
	array(
		'post_title' => '119-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1214888400,
		'post_mission' => 19),
	array(
		'post_title' => '119-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1214889400,
		'post_mission' => 19),
	array(
		'post_title' => '119-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1214890400,
		'post_mission' => 19),
	array(
		'post_title' => '119-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1214891400,
		'post_mission' => 19),
	
	array(
		'post_title' => '120-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1217566800,
		'post_mission' => 20),
	array(
		'post_title' => '120-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1217567800,
		'post_mission' => 20),
	array(
		'post_title' => '120-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1217568800,
		'post_mission' => 20),
	array(
		'post_title' => '120-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1217569800,
		'post_mission' => 20),
		
	array(
		'post_title' => '121-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1220245200,
		'post_mission' => 21),
	array(
		'post_title' => '121-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1220246200,
		'post_mission' => 21),
	array(
		'post_title' => '121-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1220247200,
		'post_mission' => 21),
	array(
		'post_title' => '121-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1220248200,
		'post_mission' => 21),
		
	array(
		'post_title' => '122-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1222837200,
		'post_mission' => 22),
	array(
		'post_title' => '122-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1222838200,
		'post_mission' => 22),
	array(
		'post_title' => '122-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1222839200,
		'post_mission' => 22),
	array(
		'post_title' => '122-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1222840200,
		'post_mission' => 22),
	
	array(
		'post_title' => '123-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1225515600,
		'post_mission' => 23),
	array(
		'post_title' => '123-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1225516600,
		'post_mission' => 23),
	array(
		'post_title' => '123-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1225517600,
		'post_mission' => 23),
	array(
		'post_title' => '123-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1225518600,
		'post_mission' => 23),
		
	array(
		'post_title' => '124-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1228111200,
		'post_mission' => 24),
	array(
		'post_title' => '124-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1228112200,
		'post_mission' => 24),
	array(
		'post_title' => '124-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1228113200,
		'post_mission' => 24),
	array(
		'post_title' => '124-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1228114200,
		'post_mission' => 24),
		
	array(
		'post_title' => '125-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1230789600,
		'post_mission' => 25),
	array(
		'post_title' => '125-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1230790600,
		'post_mission' => 25),
	array(
		'post_title' => '125-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1230791600,
		'post_mission' => 25),
	array(
		'post_title' => '125-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1230792600,
		'post_mission' => 25),
);

$posts_comments = array(
	array(
		'pcomment_author_user' => 2,
		'pcomment_author_character' => 2,
		'pcomment_post' => 1,
		'pcomment_content' => 'Very good first mission post!',
		'pcomment_date' => now()),
	array(
		'pcomment_author_user' => 1,
		'pcomment_author_character' => 1,
		'pcomment_post' => 2,
		'pcomment_content' => 'Thanks, I really enjoyed writing this one. You and I should do one soon.',
		'pcomment_date' => now()),
	array(
		'pcomment_author_user' => 2,
		'pcomment_author_character' => 2,
		'pcomment_post' => 1,
		'pcomment_content' => 'Sounds like a plan, just drop me a note when you want to get started.',
		'pcomment_date' => now())
);

$security_questions = array(
	array('question_value' => "What is your father's middle name?"),
	array('question_value' => "What was the name of your first pet?"),
	array('question_value' => "What city were you born in?"),
	array('question_value' => "What is your favorite animal?"),
	array('question_value' => "Who was your favorite teacher?"),
	array('question_value' => "What is the last book you read?")
);

$settings = array(
	array(
		'setting_key' => 'sim_name',
		'setting_value' => 'Nova Beta',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'sim_year',
		'setting_value' => '2386',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'sim_type',
		'setting_value' => 2,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'maintenance',
		'setting_value' => 'off',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_main',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_admin',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_wiki',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_login',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'display_rank',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'bio_num_awards',
		'setting_value' => 10,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'allowed_chars_playing',
		'setting_value' => 1,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'allowed_chars_npc',
		'setting_value' => 3,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'system_email',
		'setting_value' => 'on',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'email_subject',
		'setting_value' => '[Nova Beta]',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'timezone',
		'setting_value' => 'UTC',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'daylight_savings',
		'setting_value' => 'FALSE',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'date_format',
		'setting_value' => '%D %M %j%S, %Y @ %g:%i%a',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'list_logs_num',
		'setting_value' => 25,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'list_posts_num',
		'setting_value' => 25,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'manifest_defaults',
		'setting_value' => "$('tr.active').show();,$('tr.npc').show();",
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'updates',
		'setting_value' => 'all',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'show_news',
		'setting_value' => 'y',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'post_count_format',
		'setting_value' => 'multiple',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'use_sample_post',
		'setting_value' => 'y',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'default_email_name',
		'setting_value' => 'Nova',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'default_email_address',
		'setting_value' => 'nova@anodyne-productions.com',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'use_mission_notes',
		'setting_value' => 'y',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'online_timespan',
		'setting_value' => '5',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'posting_requirement',
		'setting_value' => 14,
		'setting_user_created' => 'n'),
);

$sim_type = array(
	array('simtype_name' => 'all'),
	array('simtype_name' => 'ship'),
	array('simtype_name' => 'base'),
	array('simtype_name' => 'colony'),
	array('simtype_name' => 'unit'),
	array('simtype_name' => 'realm'),
	array('simtype_name' => 'planet'),
	array('simtype_name' => 'organization')
);

$specs = array(
	array(
		'specs_name' => 'Item 1',
		'specs_order' => 0,
		'specs_summary' => 'Lorem ipsum...'),
	array(
		'specs_name' => 'Item 2',
		'specs_order' => 1,
		'specs_summary' => 'Lorem ipsum...'),
);

$specs_data = array(
	array(
		'data_field' => 1,
		'data_value' => 'Prometheus',
		'data_item' => 1),
	array(
		'data_field' => 2,
		'data_value' => 'Heavy Cruiser',
		'data_item' => 1),
	array(
		'data_field' => 3,
		'data_value' => '75 years',
		'data_item' => 1),
	array(
		'data_field' => 4,
		'data_value' => '5 years',
		'data_item' => 1),
	array(
		'data_field' => 5,
		'data_value' => '1 year',
		'data_item' => 1),
	array(
		'data_field' => 6,
		'data_value' => '445 meters',
		'data_item' => 1),
	array(
		'data_field' => 7,
		'data_value' => '100 meters',
		'data_item' => 1),
	array(
		'data_field' => 8,
		'data_value' => '45 meters',
		'data_item' => 1),
	array(
		'data_field' => 9,
		'data_value' => '15',
		'data_item' => 1),
	array(
		'data_field' => 10,
		'data_value' => '10',
		'data_item' => 1),
	array(
		'data_field' => 11,
		'data_value' => '20',
		'data_item' => 1),
	array(
		'data_field' => 12,
		'data_value' => '30',
		'data_item' => 1),
	array(
		'data_field' => 13,
		'data_value' => '40',
		'data_item' => 1),
	array(
		'data_field' => 14,
		'data_value' => '500',
		'data_item' => 1),
	array(
		'data_field' => 15,
		'data_value' => 'Warp 7',
		'data_item' => 1),
	array(
		'data_field' => 16,
		'data_value' => 'Warp 9.8',
		'data_item' => 1),
	array(
		'data_field' => 17,
		'data_value' => 'Warp 9.9975',
		'data_item' => 1),
	array(
		'data_field' => 18,
		'data_value' => 'Shields',
		'data_item' => 1),
	array(
		'data_field' => 19,
		'data_value' => 'Weapon systems',
		'data_item' => 1),
	array(
		'data_field' => 20,
		'data_value' => 'Default load out',
		'data_item' => 1),
	array(
		'data_field' => 21,
		'data_value' => '2',
		'data_item' => 1),
	array(
		'data_field' => 22,
		'data_value' => '2 Standard Shuttles',
		'data_item' => 1),
	array(
		'data_field' => 23,
		'data_value' => '5 Fighters',
		'data_item' => 1),
	array(
		'data_field' => 24,
		'data_value' => '1 Runabout',
		'data_item' => 1),
		
	array(
		'data_field' => 1,
		'data_value' => 'Prometheus',
		'data_item' => 2),
	array(
		'data_field' => 2,
		'data_value' => 'Heavy Cruiser',
		'data_item' => 2),
	array(
		'data_field' => 3,
		'data_value' => '75 years',
		'data_item' => 2),
	array(
		'data_field' => 4,
		'data_value' => '5 years',
		'data_item' => 2),
	array(
		'data_field' => 5,
		'data_value' => '1 year',
		'data_item' => 2),
	array(
		'data_field' => 6,
		'data_value' => '445 meters',
		'data_item' => 2),
	array(
		'data_field' => 7,
		'data_value' => '100 meters',
		'data_item' => 2),
	array(
		'data_field' => 8,
		'data_value' => '45 meters',
		'data_item' => 2),
	array(
		'data_field' => 9,
		'data_value' => '15',
		'data_item' => 2),
	array(
		'data_field' => 10,
		'data_value' => '10',
		'data_item' => 2),
	array(
		'data_field' => 11,
		'data_value' => '20',
		'data_item' => 2),
	array(
		'data_field' => 12,
		'data_value' => '30',
		'data_item' => 2),
	array(
		'data_field' => 13,
		'data_value' => '40',
		'data_item' => 2),
	array(
		'data_field' => 14,
		'data_value' => '500',
		'data_item' => 2),
	array(
		'data_field' => 15,
		'data_value' => 'Warp 7',
		'data_item' => 2),
	array(
		'data_field' => 16,
		'data_value' => 'Warp 9.8',
		'data_item' => 2),
	array(
		'data_field' => 17,
		'data_value' => 'Warp 9.9975',
		'data_item' => 2),
	array(
		'data_field' => 18,
		'data_value' => 'Shields',
		'data_item' => 2),
	array(
		'data_field' => 19,
		'data_value' => 'Weapon systems',
		'data_item' => 2),
	array(
		'data_field' => 20,
		'data_value' => 'Default load out',
		'data_item' => 2),
	array(
		'data_field' => 21,
		'data_value' => '2',
		'data_item' => 2),
	array(
		'data_field' => 22,
		'data_value' => '2 Standard Shuttles',
		'data_item' => 2),
	array(
		'data_field' => 23,
		'data_value' => '5 Fighters',
		'data_item' => 2),
	array(
		'data_field' => 24,
		'data_value' => '1 Runabout',
		'data_item' => 2),
);

$specs_fields = array(
	array(
		'field_type' => 'text',
		'field_name' => 'class',
		'field_fid' => 'class',
		'field_class' => '',
		'field_label_page' => 'Class',
		'field_order' => 0,
		'field_section' => 1),
	array(
		'field_type' => 'text',
		'field_name' => 'role',
		'field_fid' => 'role',
		'field_class' => '',
		'field_label_page' => 'Role',
		'field_order' => 1,
		'field_section' => 1),
	array(
		'field_type' => 'text',
		'field_name' => 'duration',
		'field_fid' => 'duration',
		'field_class' => '',
		'field_label_page' => 'Duration',
		'field_order' => 2,
		'field_section' => 1),
	array(
		'field_type' => 'text',
		'field_name' => 'refit',
		'field_fid' => 'refit',
		'field_class' => '',
		'field_label_page' => 'Time Between Refits',
		'field_order' => 3,
		'field_section' => 1),
	array(
		'field_type' => 'text',
		'field_name' => 'resupply',
		'field_fid' => 'resupply',
		'field_class' => '',
		'field_label_page' => 'Time Between Resupply',
		'field_order' => 4,
		'field_section' => 1),
		
	array(
		'field_type' => 'text',
		'field_name' => 'length',
		'field_fid' => 'length',
		'field_class' => '',
		'field_label_page' => 'Length',
		'field_order' => 0,
		'field_section' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'width',
		'field_fid' => 'width',
		'field_class' => '',
		'field_label_page' => 'Width',
		'field_order' => 1,
		'field_section' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'height',
		'field_fid' => 'height',
		'field_class' => '',
		'field_label_page' => 'Height',
		'field_order' => 2,
		'field_section' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'decks',
		'field_fid' => 'decks',
		'field_class' => 'medium',
		'field_label_page' => 'Decks',
		'field_order' => 3,
		'field_section' => 2),
		
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_officers',
		'field_fid' => 'compliment_officers',
		'field_class' => 'medium',
		'field_label_page' => 'Officers',
		'field_order' => 0,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_enlisted',
		'field_fid' => 'compliment_enlisted',
		'field_class' => 'medium',
		'field_label_page' => 'Enlisted Crew',
		'field_order' => 1,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_marines',
		'field_fid' => 'compliment_marines',
		'field_class' => 'medium',
		'field_label_page' => 'Marines',
		'field_order' => 2,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_civilians',
		'field_fid' => 'compliment_civilians',
		'field_class' => 'medium',
		'field_label_page' => 'Civilians',
		'field_order' => 3,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_emergency',
		'field_fid' => 'compliment_emergency',
		'field_class' => 'medium',
		'field_label_page' => 'Emergency Capacity',
		'field_order' => 4,
		'field_section' => 3),
		
	array(
		'field_type' => 'text',
		'field_name' => 'speed_normal',
		'field_fid' => 'speed_normal',
		'field_class' => 'medium',
		'field_label_page' => 'Cruise Speed',
		'field_order' => 0,
		'field_section' => 4),
	array(
		'field_type' => 'text',
		'field_name' => 'speed_max',
		'field_fid' => 'speed_max',
		'field_class' => 'medium',
		'field_label_page' => 'Maximum Speed',
		'field_order' => 1,
		'field_section' => 4),
	array(
		'field_type' => 'text',
		'field_name' => 'speed_emergency',
		'field_fid' => 'speed_emergency',
		'field_class' => 'medium',
		'field_label_page' => 'Emergency Speed',
		'field_order' => 2,
		'field_section' => 4),
		
	array(
		'field_type' => 'textarea',
		'field_name' => 'defensive',
		'field_fid' => 'defensive',
		'field_class' => '',
		'field_label_page' => 'Shields',
		'field_order' => 0,
		'field_section' => 5,
		'field_rows' => 5),
	array(
		'field_type' => 'textarea',
		'field_name' => 'weapons',
		'field_fid' => 'weapons',
		'field_class' => '',
		'field_label_page' => 'Weapon Systems',
		'field_order' => 1,
		'field_section' => 5,
		'field_rows' => 5),
	array(
		'field_type' => 'textarea',
		'field_name' => 'armament',
		'field_fid' => 'armament',
		'field_class' => '',
		'field_label_page' => 'Armament',
		'field_order' => 2,
		'field_section' => 5,
		'field_rows' => 5),
		
	array(
		'field_type' => 'text',
		'field_name' => 'shuttlebays',
		'field_fid' => 'shuttlebays',
		'field_class' => 'small',
		'field_label_page' => 'Shuttlebays',
		'field_order' => 0,
		'field_section' => 6),
	array(
		'field_type' => 'textarea',
		'field_name' => 'shuttles',
		'field_fid' => 'shuttles',
		'field_class' => '',
		'field_label_page' => 'Shuttles',
		'field_order' => 1,
		'field_section' => 6,
		'field_rows' => 5),
	array(
		'field_type' => 'textarea',
		'field_name' => 'fighters',
		'field_fid' => 'fighters',
		'field_class' => '',
		'field_label_page' => 'Fighters',
		'field_order' => 2,
		'field_section' => 6,
		'field_rows' => 5),
	array(
		'field_type' => 'textarea',
		'field_name' => 'runabouts',
		'field_fid' => 'runabouts',
		'field_class' => '',
		'field_label_page' => 'Runabouts',
		'field_order' => 3,
		'field_section' => 6,
		'field_rows' => 5),
);

$specs_sections = array(
	array(
		'section_name' => 'General',
		'section_order' => 0),
	array(
		'section_name' => 'Dimensions',
		'section_order' => 1),
	array(
		'section_name' => 'Personnel',
		'section_order' => 2),
	array(
		'section_name' => 'Speed',
		'section_order' => 3),
	array(
		'section_name' => 'Weapons &amp; Defensive Systems',
		'section_order' => 4),
	array(
		'section_name' => 'Auxiliary Craft',
		'section_order' => 5),
);

$system_components = array(
	array(
		'comp_name' => 'CodeIgniter',
		'comp_version' => '1.7.3',
		'comp_url' => 'http://codeigniter.com/',
		'comp_desc' => 'CodeIgniter is an open source web application framework for use in building dynamic web sites with PHP. It enables developers to build applications faster - compared to coding from scratch - by providing a rich set of libraries for commonly needed tasks, as well as a simple interface and a logical structure to access these libraries.'),
	array(
		'comp_name' => 'Thresher',
		'comp_version' => 'Release 1',
		'comp_url' => '',
		'comp_desc' => "Thresher is Anodyne Productions' integrated mini-wiki for Nova."),
	array(
		'comp_name' => 'Template Library',
		'comp_version' => '1.4.1',
		'comp_desc' => "The Template library, written for the CodeIgniter PHP-framework, is a wrapper for CI's View implementation. Template is a reaction to the numerous questions from the CI community regarding how one would display multiple views for one controller, and how to embed \"views within views\" in a standardized fashion. In addition, Template provides extra Views loading capabilities, the ability to utilize any template parser (like Smarty), and shortcuts for including CSS, JavaScript, and other common elements in your final rendered HTML.",
		'comp_url' => 'http://www.williamsconcepts.com/ci/codeigniter/libraries/template/index.html'),
	array(
		'comp_name' => 'jQuery',
		'comp_version' => '1.4.4',
		'comp_url' => 'http://www.jquery.com/',
		'comp_desc' => 'jQuery is a lightweight JavaScript library that emphasizes interaction between JavaScript and HTML.'),
	array(
		'comp_name' => 'jQuery UI',
		'comp_version' => '1.8.9',
		'comp_url' => 'http://jqueryui.com/',
		'comp_desc' => 'jQuery UI is a lightweight, easily customizable interface library for the jQuery Javascript library.'),
	array(
		'comp_name' => 'prettyPhoto',
		'comp_version' => '3.0.1',
		'comp_desc' => "prettyPhoto is a jQuery lightbox clone. Not only does it support images, it also support for videos, flash, YouTube, iframes. It's a full blown media lightbox.",
		'comp_url' => 'http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/'),
	array(
		'comp_name' => 'Facebox',
		'comp_version' => '1.2',
		'comp_desc' => "Facebox is a jQuery-based lightbox which can display images, divs, or entire remote pages.",
		'comp_url' => 'http://famspam.com/facebox'),
	array(
		'comp_name' => 'AjaxQ',
		'comp_version' => '0.0.1',
		'comp_desc' => "AjaxQ is a jQuery plugin that implements an AJAX request queueing mechanism.",
		'comp_url' => 'http://plugins.jquery.com/project/ajaxq'),
	array(
		'comp_name' => 'qTip',
		'comp_version' => '1.0-r29',
		'comp_desc' => "qTip is an advanced tooltip plugin for the ever popular jQuery JavaScript framework. Built from the ground up to be user friendly, yet feature rich, qTip provides you with tonnes of features like rounded corners and speech bubble tips, and best of all... it's completely free under the MIT license!",
		'comp_url' => 'http://craigsworks.com/projects/qtip/'),
	array(
		'comp_name' => 'Lazy',
		'comp_version' => '1.3.1',
		'comp_desc' => "Lazy is an on-demand jQuery plugin loader, also known as a lazy loader. Instead of downloading all jQuery plugins you might or might not need when the page loads, Lazy downloads the plugins when you actually use them. Lazy is very lightweight, super fast, and smart. Lazy will keep track of all your plugins and dependencies and make sure that they are only downloaded once.",
		'comp_url' => 'http://www.unwrongest.com/projects/lazy/'),
	array(
		'comp_name' => 'jQuery Reflection',
		'comp_version' => '1.0.3',
		'comp_desc' => "This is an improved version of the reflection.js script rewritten for the jQuery Javascript library. It allows you to add instantaneous reflection effects to your images in modern browsers, in less than 2 KB.",
		'comp_url' => 'http://www.digitalia.be/software/reflectionjs-for-jquery'),
	array(
		'comp_name' => 'jQuery QuickSearch',
		'comp_version' => '',
		'comp_desc' => "QuickSearch is a simple plugin for filtering tables, lists and paragraphs.",
		'comp_url' => 'http://rikrikrik.com/jquery/quicksearch/'),
	array(
		'comp_name' => 'markItUp!',
		'comp_version' => '1.1.9',
		'comp_desc' => "markItUp! is a JavaScript plugin built on the jQuery library that allows you to turn any textarea into a markup editor.",
		'comp_url' => 'http://markitup.jaysalvat.com/home/'),
	array(
		'comp_name' => 'Textile',
		'comp_version' => '2.0.0',
		'comp_desc' => "Textile is a lightweight markup language that converts its marked-up text input to valid, well-formed XHTML and also inserts character entity references for apostrophes, opening and closing single and double quotation marks, ellipses and em dashes.",
		'comp_url' => 'http://textpattern.com/download'),
	array(
		'comp_name' => 'PHP Markdown Extra',
		'comp_version' => '1.2.4',
		'comp_desc' => "PHP Markdown is a port to PHP of the Markdown program written by John Gruber. Markdown is two things: a plain text markup syntax, and a software tool that converts the plain text markup to HTML for publishing on the web.",
		'comp_url' => 'http://michelf.com/projects/php-markdown/'),
	array(
		'comp_name' => 'YAYparser',
		'comp_version' => '',
		'comp_desc' => "YAYparser is a regular expression driven YAML parser that is aimed to be small and easy to use.",
		'comp_url' => 'http://codeigniter.com/wiki/YAYparser/'),
	array(
		'comp_name' => 'jQuery Countdown',
		'comp_version' => '',
		'comp_desc' => "A simple plugin that counts down and updates the text every second.",
		'comp_url' => 'http://davidwalsh.name/jquery-countdown-plugin'),
	array(
		'comp_name' => 'Uniform',
		'comp_version' => '1.5',
		'comp_desc' => "Uniform masks your standard form controls with custom themed controls. It works in sync with your real form elements to ensure accessibility and compatibility.",
		'comp_url' => 'http://pixelmatrixdesign.com/uniform/'),
);

$system_info = array(
	array(
		'sys_uid' => random_string('alnum', 32),
		'sys_install_date' => now(),
		'sys_version_major' => 1,
		'sys_version_minor' => 2,
		'sys_version_update' => 5)
);

$system_versions = array(
	array(
		'version' => '1.0.0',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '0',
		'version_date' => 1271393940,
		'version_launch'	=> 'Nova 1.0 is the first release of the next generation RPG management software from Anodyne Productions.',
		'version_changes'	=> "* Initial release"),
	array(
		'version' => '1.0.1',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '1',
		'version_date' => 1271424600,
		'version_launch'	=> 'Nova 1.0.1 is a maintenance release that fixes two important issues with Nova 1.0. The release fixes a bug where the upgrade process did not create a necessary field in the missions table as well as two issues with installations oh PHP4 servers. This update is recommended for all users who have upgraded from SMS and/or are running on a PHP4 server.',
		'version_changes'	=> "* fixed bug in the upgrade process where a database field wasn't added to the table
* fixed bug where models couldn't be autoloaded because Base4 doesn't extend MY_Loader
* fixed error that was thrown because the date_default_timezone_set function doesn't exist in PHP before version 5.1"),
	array(
		'version' => '1.0.2',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '2',
		'version_date' => 1271817000,
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
* fixed bug where the mission dropdown wasn't properly populated when viewing a saved post"),
	array(
		'version' => '1.0.3',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '3',
		'version_date' => 1272321000,
		'version_launch'	=> "Nova 1.0.3 is the third maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, several bugs with Thresher, changes to the update center to allow users to update even if they can't get the update information from the Anodyne server, NPC removal issues, updates to the user removal process and much more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.0.3 update file
* updated the install data
    * menu items
    * version info
* updated the language files
    * [base\_lang] added labels_you
    * [text\_lang] added character_change
* updated the versions array file
* updated the ajax controller to have a separate method for removing NPCs instead of piggybacking off of the delete character method
* updated the characters controller to put the NPC removal inside its own method instead of using the character removal process
* updated the posts model to clean some code up and added a parameter to the unattended posts method
* updated the dynamic form management pages (bio, docking, specs) to show notices if there are no fields in a section
* updated the panel tabs on the control panel to display a notice if there's no content available
* updated thresher to use the proper regions in the template config file
* updated the user deactivation process to deactivate a users' characters at the same time
* updated the update center to show the links to start the update regardless of whether there's information about the update or not
* updated the auth library to add some debugging code to help track down the remember me bug
* updated the process of updating the system to remove dependence on the versions array file and instead pull a listing of the update directory (we still use the versions array file in the event the directory listing fails)
* fixed bug where the create wiki entry page wasn't showing up in the sub navigation menu
* fixed bug where the posts model wasn't accurately counting unattended posts when a character ID was passed in as an integer instead of array
* fixed bug where errors were thrown when deleting characters and NPCs
* fixed an error being thrown on the write mission post page
* fixed bug where the post notification stayed active even after the post had been updated and/or sent out
* fixed errors that were thrown when adding a rank
* fixed error thrown when there are no fields in a specs form section
* fixed error thrown in the dashboard
* fixed bug where wiki pages were being put in the uncategorized section even if they had categories
* fixed error thrown for missing option parameters
* fixed error thrown during accepting/rejecting a docked ship application"),
	array(
		'version' => '1.0.4',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '4',
		'version_date' => 1273705200,
		'version_launch'	=> "Nova 1.0.4 is the fourth maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, bugs with emails not being sent out on some servers, user access errors and filtering text before going into the database. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.0.4 update file
* added the MY\_Email library file
* updated the version update files to make sure the values get reset at the start of every file
* updated jquery ui to version 1.8.1
* updated markItUp! to version 1.1.7
* updated the textile parser to fix some bugs (thanks to dustin for catching this)
* updated the wiki controller to show an error message if the server is running php 4
* updated the archives controller to show an error message if the server is running php 4
* updated the MY\_Input library to try and do filtering for MS Word characters a little better
* fixed error thrown when a user with level 1 user account privileges updates their account
* fixed bug where saved personal logs could be shown in along with activated logs for users with multiple characters associated with their account
* fixed bug where IE threw an exception on the post, log, news and docked item management pages
* fixed error thrown on the contact page
* fixed errors thrown on the manage bio page for users with level 1 privileges
* fixed bug with the manage bio page where positions were updated when they shouldn't be
* fixed bug where the status change request email wasn't populated properly"),
	array(
		'version' => '1.0.5',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '5',
		'version_date' => 1275865200,
		'version_launch'	=> "Nova 1.0.5 is the fifth maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, a bug that wouldn't allow unlinked NPCs to use newly created bio fields, a security issue with the docking form and more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.0.5 update file
* fixed errors after upgrade on the characters management page
* fixed error after upgrade on the npc management page
* fixed errors thrown when editing a wiki page
* fixed bug in the positions dropdown menu where hidden departments' positions were still shown
* fixed bug where a wrong variable was using in a model method
* fixed security issue where docking request data wasn't filtered for xss attacks
* fixed bugs with the email sent to GMs when a docking request is submitted
* fixed error thrown when updating a user to be inactive
* fixed bug we weren't doing any sanity checking on the type of variable we needed when handling character deactivation
* fixed errors thrown when rejecting a docking request
* fixed bug where unlinked NPCs wouldn't be able to use newly created fields
* fixed bug where site options didn't allow skin admins to select in development skins
* fixed bug where join instructions weren't displayed"),
	array(
		'version' => '1.0.6',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '6',
		'version_date' => 1279148400,
		'version_launch'	=> "Nova 1.0.6 is the sixth and final maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, a critical CodeIgniter security bug, several bugs with character management, a bug with user management and setting email preferences, updates to the jQuery UI library and other plugins and more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users. Additionally, active testing is underway for Nova 1.1 that will add several new features to the system and will be available later this summer.",
		'version_changes'	=> "* added the 1.0.6 update file
* updated the character bio management page to show a loader until everything has finished loading to help with load time
* updated jquery ui to version 1.8.2
* updated the auth library to remove some debug code since the autologin bug seems to have been solved
* updated the index page to turn down the error reporting (fatal errors and database errors will still be shown)
* updated the select menu on the write PM page to separate active and inactive characters
* updated colorbox to version 1.3.8
* updated the characters model to include a method for inserting promotion records
* updated the language file with a new item (_labels\_from_)
* updated the users model with a new method for removing user preference values
* updated CI's core upload class to fixing a security hole
* fixed error thrown when posting a comment on a mission post
* fixed error thrown when attempting to delete a character
* fixed error thrown during step 2 of the update process for some users
* fixed error thrown when there's only one mission image set on the mission detail page
* fixed error thrown when there's only one tour image set on the tour detail page
* fixed error thrown when there's only one character image set on the character bio page
* fixed bug where acceptance and rejection messages were sent without any changes an admin made
* fixed bug where changing a character's state to and from active wouldn't set the open slots of their position(s)
* fixed bug where the position dropdowns when creating a character showed all positions instead of open positions
* fixed bug where rank history information wasn't being populated correctly
* fixed bug where turning off update notification still attempted to run the check (before running in to another check)
* fixed bug where a user's email preferences remained active even after the user was set to inactive
* fixed bug where a user's email preferences weren't deleted when the user was deleted"),
	array(
		'version' => '1.1.0',
		'version_major' => '1',
		'version_minor' => '1',
		'version_update' => '0',
		'version_date' => 1283635800,
		'version_launch'	=> "Nova 1.1 is the first update to Nova that adds additional features to the system. Included in this release is the ability to create multiple specification items and to associate tour items with specific specification items as well as bug fixes (a bug where editing existing tour items wouldn't update the current item, but the first item). A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.1 update file
* added the ability to have multiple specification items
* added the ability to associate tour items with a specification item
* added the fancybox plugin
* added the jquery reflection plugin
* added _specitem\_select_ language item in the text\_lang file
* added _specitem\_empty\_fields_ lanuage item in the text\_lang file
* removed the colorbox plugin
* removed the reflection.js plugin
* updated the system to use the new jquery reflection plugin instead of reflection.js
* updated the image upload system to be able to handle spec images as well
* updated the specifications model with new methods for handling spec items
* updated the mission groups listing with a style fix
* updated jquery ui to version 1.8.4
* fixed bug where ordered and unordered lists weren't properly styled in Thresher
* fixed bug in mission group pages where missions didn't respect the mission order that was set for them
* fixed bug where the private message dropdown didn't populate with an author when replying to a message
* fixed bug where mission post next/previous links could be wrong under certain circumstances
* fixed bug where news item next/previous links could be wrong under certain circumstances
* fixed bug where personal log next/previous links could be wrong under certain circumstances
* fixed bug where the command staff, game master and webmaster get email methods pulled all users, not just active users
* fixed error thrown with an undefined class method when deleting uploaded items"),
	array(
		'version' => '1.1.1',
		'version_major' => '1',
		'version_minor' => '1',
		'version_update' => '1',
		'version_date' => 1285628400,
		'version_launch'	=> "Nova 1.1.1 is a maintenance update addressing several outstanding issues with Nova 1.1. This update to Nova bumps the jQuery UI to version 1.8.5 and fixes an issue with tour item display when there are no general tour items available. In addition, we've taken steps to address a bug where CodeIgniter wouldn't be able to load the template files and would throw an error. Finally, a presentation issue with skins with a dashboard panel trigger has been fixed as well. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.1.1 update file
* updated the comments in the login controller
* updated jquery ui to version 1.8.5
* updated markitup plugin to version 1.1.8
* fixed bug where nova wouldn't display if the template file couldn't be found
* fixed bug where the general tour items category would be shown even if there weren't any general tour items
* fixed bug where skins with dashboard handles were showing bullets and having weird spacing issues"),
	array(
		'version' => '1.1.2',
		'version_major' => '1',
		'version_minor' => '1',
		'version_update' => '2',
		'version_date' => 1287097200,
		'version_launch'	=> "Nova 1.1.2 is a maintenance update addressing several issues with Nova 1.1. This update fixes issues with Quick Install, an error thrown when updating a user profile and usability issues with the character picking process with writing and managing mission posts. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.1.2 update file
* updated the form helper to extend the form\_dropdown function
* updated the write/missionpost and manage/posts pages to take saved/activated posts in to account for the author selection dropdown (thanks to Patrick for helping with this)
* fixed bug with the add author selection in manage/posts and write/missionpost (thanks to Patrick for this fix)
* fixed bug where nova would try to update a user's profile with a field that doesn't exist
* fixed bug where, under very strange circumstances, quick install wouldn't work the way it's supposed to"),
	array(
		'version' => '1.2.0',
		'version_major' => '1',
		'version_minor' => '2',
		'version_update' => '0',
		'version_date' => 1292889600,
		'version_launch'	=> "Nova 1.2 is the second major update to Nova 1 and add new functionality to the system to help admin run their RPG even better. In addition to patching nearly two dozen bugs from Nova 1.0 and 1.1, version 1.2 adds ban controls for dealing with pesky users, deck listing improvements, contact page improvements and multiple manifests. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.2 update file
* added the ability to ban users from applying or even getting to the site
* added a page that level 2 bans are redirected to
* added the validation error image to the assets directory
* added the assignment image to the admin \_base directory
* added prettyPhoto jquery plugin to replace fancybox
* removed fancybox jquery plugin
* updated the applications report to show email address and IP address of the user who applied
* updated the email sent to the game master from the join form to show the IP address of the applicant
* updated the contact form to be simpler and use proper form validation
* updated the departments model with methods for handling multiple manifests
* updated codeigniter to version 1.7.3
* updated jquery to version 1.4.4
* updated jquery ui to version 1.8.7
* updated markItUp! plugin to version 1.1.9
* updated the autoload config item to not try and autoload the input library since CI loads it by default
* updated the user model with a method to pull user information based on characters in the database
* updated department management with a better interface for working with departments
* updated position management to split departments out by manifest
* updated the write controller to check for whether a user has a character associated with their account and if they don't redirct them to an error page
* updated some of the model methods to correct for situations where the user or character ID might not be present and throw errors
* updated the basic and dev install data to fix a typo
* updated the language files
    * [base\_lang] added _labels\_ban_
    * [base\_lang] added _labels\_bans_
    * [base\_lang] added _labels\_ipaddr_
    * [base\_lang] added _labels\_header_
    * [base\_lang] added _labels\_listings_
    * [base\_lang] added _labels\_manifests_
    * [base\_lang] added _labels\_refresh_
    * [base\_lang] added _labels\_unassigned_
    * [base\_lang] added _misc\_level1\_only_
    * [email\_lang] updated _email\_content\_private\_message_
    * [error\_lang] added _error\_wcp\_1_
    * [text\_lang] added _text\_bans_
    * [text\_lang] added _text\_ban\_join_
    * [text\_lang] added _text\_manifest\_delete\_departments_
    * [text\_lang] added _text\_manifest_
    * [text\_lang] added _text\_manifest\_assign_
    * [text\_lang] added _text\_duplicate\_dept_
    * [text\_lang] updated _text\_manage\_depts_
* fixed bug where users without an active character would be shown in the activity warning panel on the ACP
* fixed bug where the sample post in the join application email was just a massive wall of text
* fixed bug where the specifications weren't properly upgraded during the sms upgrade process
* fixed bug with a missing closing tag on the create characters page
* fixed bug where timezone menu in site/settings pulled the wrong value to populate the field with
* fixed bug where the join page was pulling an image from the wrong location
* fixed spacing bug in access role management
* fixed spacing bug in news item management
* fixed spacing bug in log management
* fixed spacing bug in post management
* fixed spacing bug in department management
* fixed some errors being thrown throughout the system
* fixed bug where the flash message view couldn't be overridden with seamless substitution
* fixed bug where post emails were sent out with the user's primary character name attached even if the primary character wasn't associated with the post
* fixed bug where the private message email didn't contain the content of the private message
* fixed some errors thrown through the system when a user without a character tried moving through the system
* fixed bug where personal logs don't have the right date when they're saved first
* fixed bug where pending users would appear in the dropdown of potential recipients for a PM
* fixed bug where changing a dynamic form field from text/textarea to dropdown wouldn't trigger the dropdown values section to open, rendering the field pretty much useless"),
	array(
		'version' => '1.2.1',
		'version_major' => '1',
		'version_minor' => '2',
		'version_update' => '1',
		'version_date' => 1293121800,
		'version_launch'	=> "Nova 1.2.1 is the first maintenance release for Nova 1.2 and addresses several bugs discovered after the initial release of the new version. Bugs fixed in this release include a bug where positions would disappear after being updated and errors thrown throughout the system. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.2.1 update file
* fixed bug where positions would disappear when being updated
* fixed errors thrown when trying to update character images when there aren't any images present
* fixed error thrown from the RSS feed"),
	array(
		'version' => '1.2.2',
		'version_major' => '1',
		'version_minor' => '2',
		'version_update' => '2',
		'version_date' => 1293759000,
		'version_launch'	=> "Nova 1.2.2 is the second maintenance release for Nova 1.2 and two bugs discovered after the release of Nova 1.2.1. Bugs fixed in this release include a bug where sub departments couldn't be managed from the department management page and a bug with the display of post authors in emails. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.2.2 update file
* fixed bug where sub departments couldn't be managed from the department management page
* fixed bug where post emails sent out didn't display the authors properly
* fixed bug in the 1.1.2 to 1.2 update file that would cause access issues"),
	array(
		'version'			=> '1.2.3',
		'version_major'		=> 1,
		'version_minor'		=> 2,
		'version_update'	=> 3,
		'version_date'		=> 1294185600,
		'version_launch'	=> "Nova 1.2.3 is the third maintenance release for Nova 1.2 and fixes a bug with handling deck listings with multiple specification items. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.2.3 update file
* fixed bug with handling deck listings and multiple specification items"),
	array(
		'version'			=> '1.2.4',
		'version_major'		=> 1,
		'version_minor'		=> 2,
		'version_update'	=> 4,
		'version_date'		=> 1296000000,
		'version_launch'	=> "Nova 1.2.4 is the fourth maintenance release for Nova 1.2 and fixes bugs with inaccurate mission post counts (thanks to Jordan for finding this issue), the acceptance email sent out to users and a manifest issue in Internet Explorer 7. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.2.4 update file
* updated the jquery ui to version 1.8.9
* fixed bug where nova wasn't accurately counting mission posts
* fixed bug where the user acceptance email was CCed to more people than it needed to be
* fixed bug where IE7 choked on the manifest"),
	array(
		'version'			=> '1.2.5',
		'version_major'		=> 1,
		'version_minor'		=> 2,
		'version_update'	=> 5,
		'version_date'		=> 1308265200,
		'version_launch'	=> "Nova 1.2.5 is the fifth maintenance release for Nova 1.2 and fixes a bug where old specification items would hold the value of a new field when they were updated. Additionally, several bugs related to activating and deactivating users have been fixed as well. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.2.5 update file
* fixed bug where specification data wouldn't get added to the table for old items if a new field was added
* fixed bug where deactivated users would retain their account flags (sysadmin, game master, etc) and wouldn't have their access role changed
* fixed bug where reactivated users wouldn't have a reasonable access role"),
);

$tour = array(
	array(
		'tour_name' => 'Main Bridge',
		'tour_order' => 0,
		'tour_summary' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
		'tour_spec_item' => 1),
	array(
		'tour_name' => 'Main Engineering',
		'tour_order' => 1,
		'tour_summary' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
		'tour_spec_item' => 2),
);

$tour_data = array(
	array(
		'data_field' => 1,
		'data_tour_item' => 1,
		'data_value' => 'Deck 1',
		'data_updated' => now()),
	array(
		'data_field' => 2,
		'data_tour_item' => 1,
		'data_value' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
		'data_updated' => now()),
);

$tour_fields = array(
	array(
		'field_type' => 'text',
		'field_name' => 'location',
		'field_fid' => 'location',
		'field_class' => '',
		'field_label_page' => 'Location',
		'field_order' => 0),
	array(
		'field_type' => 'textarea',
		'field_name' => 'long_desc',
		'field_fid' => 'long_desc',
		'field_class' => '',
		'field_label_page' => 'Description',
		'field_order' => 1,
		'field_rows' => 8),
);

$tour_decks = array(
	array(
		'deck_name' => 'Deck 1',
		'deck_order' => 1,
		'deck_content' => "Main Bridge\r\nCO's Ready Room\r\nObservation Lounge"),
	array(
		'deck_name' => 'Beta Deck',
		'deck_order' => 2,
		'deck_content' => "CO's Quarters"),
);

/* End of file install_data_dev.php */
/* Location: ./application/assets/install/install_data_dev.php */