<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Database Data
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 */

/**
 * Data array with the table/array names used
 */
$data = array(
	'access_groups',
	'access_pages',
	'access_roles',
	'catalogue_modules',
	'catalogue_skins',
	'catalogue_skinsecs',
	'forms',
	'form_fields',
	'form_sections',
	'form_tabs',
	'form_values',
	'menu_categories',
	'menu_items',
	'news_categories',
	'security_questions',
	'settings',
	'sim_types',
	'site_contents',
	'system_components',
	'system_info',
	'system_versions',
	'user_prefs',
);

/**
 * Arrays of data with the information being inserted into the database
 */
$access_groups = array(
	array(
		'name' => 'General Admin',
		'order' => 0),
	array(
		'name' => 'Writing Features',
		'order' => 1),
	array(
		'name' => 'Site Management',
		'order' => 2),
	array(
		'name' => 'Data Management',
		'order' => 3),
	array(
		'name' => 'Reports',
		'order' => 4),
	array(
		'name' => 'Characters',
		'order' => 5),
	array(
		'name' => 'Users',
		'order' => 6),
	array(
		'name' => 'Wiki',
		'order' => 7),
);

$access_pages = array(
	array(
		'name' => "Admin Control Panel",
		'url' => 'admin/index',
		'group' => 1,
		'desc' => "Can access the admin control panel with recent posts, stats and other information"),
	array(
		'name' => "Upload Images",
		'url' => 'upload/index',
		'group' => 1,
		'desc' => "Can upload images to the server"),
	array(
		'name' => "Manage Uploads",
		'url' => 'upload/manage',
		'group' => 1,
		'desc' => "Can delete upload records"),
		
	array(
		'name' => "Private Messages",
		'url' => 'messages/index',
		'group' => 2,
		'desc' => "Can send and receive private messages"),
	array(
		'name' => "Writing Control Panel",
		'url' => 'write/index',
		'group' => 2,
		'desc' => "Can access the writing control panel with saved entries and recent posts"),
	array(
		'name' => "Write Mission Post",
		'url' => 'write/missionpost',
		'group' => 2,
		'desc' => "Can post a mission entry to the system"),
	array(
		'name' => "Write Personal Log",
		'url' => 'write/personallog',
		'group' => 2,
		'desc' => "Can post a personal log to the system"),
	array(
		'name' => "Write News Item",
		'url' => 'write/newsitem',
		'group' => 2,
		'desc' => "Can post a news items to the system"),
		
	array(
		'name' => "Site Settings",
		'url' => 'site/settings',
		'group' => 3,
		'desc' => "Can add, delete or edit any of the system settings"),
	array(
		'name' => "Site Messages",
		'url' => 'site/messages',
		'group' => 3,
		'desc' => "Can add, delete or edit any of the site messages for the system"),
	array(
		'name' => "Role Access",
		'url' => 'site/roles',
		'group' => 3,
		'desc' => "Can add, delete or edit access roles including access page sections and access pages"),
	array(
		'name' => "Bio/Join Form",
		'url' => 'site/bioform',
		'group' => 3,
		'desc' => "Can add to, edit or remove from the dynamic bio form including bio tabs and bio sections"),
	array(
		'name' => "Specs Form",
		'url' => 'site/specsform',
		'group' => 3,
		'desc' => "Can add to, edit or remove from the dynamic specifications form including specs sections"),
	array(
		'name' => "Tour Form",
		'url' => 'site/tourform',
		'group' => 3,
		'desc' => "Can add to, edit or remove from the dynamic tour form"),
	array(
		'name' => "Docking Form",
		'url' => 'site/dockingform',
		'group' => 3,
		'desc' => "Can add to, edit or remove from the dynamic docking form"),
	array(
		'name' => "Menus",
		'url' => 'site/menus',
		'group' => 3,
		'desc' => "Can add, delete and edit system menus"),
	array(
		'name' => "System Catalogue - Ranks",
		'url' => 'site/catalogueranks',
		'group' => 3,
		'desc' => "Can add, delete and edit system ranks"),
	array(
		'name' => "System Catalogue - Skins",
		'url' => 'site/catalogueskins',
		'group' => 3,
		'desc' => "Can add, delete and edit system skins"),
	array(
		'name' => "Manage Sim Types",
		'url' => 'site/simtypes',
		'group' => 3,
		'desc' => "Can add, delete and edit the different sim types"),
		
	array(
		'name' => "Specs",
		'url' => 'manage/specs',
		'group' => 4,
		'desc' => "Can update the specifications"),
	array(
		'name' => "Deck Listing",
		'url' => 'manage/decks',
		'group' => 4,
		'desc' => "Can add to, edit or remove from the deck listing"),
	array(
		'name' => "Manage Comments",
		'url' => 'manage/comments',
		'group' => 4,
		'desc' => "Can approve, delete and edit any comments"),
	array(
		'name' => "Manage Positions",
		'url' => 'manage/positions',
		'group' => 4,
		'desc' => "Can add, delete and edit positions"),
	array(
		'name' => "Manage Departments",
		'url' => 'manage/depts',
		'group' => 4,
		'desc' => "Can add, delete and edit departments"),
	array(
		'name' => "Manage Ranks",
		'url' => 'manage/ranks',
		'group' => 4,
		'desc' => "Can add, delete and edit ranks"),
	array(
		'name' => "Manage Awards",
		'url' => 'manage/awards',
		'group' => 4,
		'desc' => "Can add, delete and edit awards"),
	array(
		'name' => "Manage Tour Items",
		'url' => 'manage/tour',
		'group' => 4,
		'desc' => "Can add, delete and edit tour items"),
	array(
		'name' => "Manage Docked Items",
		'url' => 'manage/docked',
		'group' => 4,
		'desc' => "Can add, approve, delete, edit and reject docked items"),
	array(
		'name' => "Manage Missions",
		'url' => 'manage/missions',
		'group' => 4,
		'desc' => "Can add, delete and edit missions"),
	array(
		'name' => "Manage Mission Posts (Level 1)",
		'url' => 'manage/posts',
		'level' => 1,
		'group' => 4,
		'desc' => "Can delete and edit any of their own mission posts"),
	array(
		'name' => "Manage Mission Posts (Level 2)",
		'url' => 'manage/posts',
		'level' => 2,
		'group' => 4,
		'desc' => "Can delete and edit all mission posts in the system"),
	array(
		'name' => "Manage Personal Logs (Level 1)",
		'url' => 'manage/logs',
		'level' => 1,
		'group' => 4,
		'desc' => "Can delete and edit any of their own personal logs"),
	array(
		'name' => "Manage Personal Logs (Level 2)",
		'url' => 'manage/logs',
		'level' => 2,
		'group' => 4,
		'desc' => "Can delete and edit all personal logs in the system"),
	array(
		'name' => "Manage News Items (Level 1)",
		'url' => 'manage/news',
		'level' => 1,
		'group' => 4,
		'desc' => "Can delete and edit any of their own news items"),
	array(
		'name' => "Manage News Items (Level 2)",
		'url' => 'manage/news',
		'level' => 2,
		'group' => 4,
		'desc' => "Can delete and edit all news items in the system"),
	array(
		'name' => "Manage News Categories",
		'url' => 'manage/newscats',
		'group' => 4,
		'desc' => "Can manage all news categories available for news items"),
		
	array(
		'name' => "LOA Report",
		'url' => 'report/loa',
		'group' => 5,
		'desc' => "Can view a report on LOAs taken over the life of the system"),
	array(
		'name' => "System &amp; Versions",
		'url' => 'report/versions',
		'group' => 5,
		'desc' => "Can view a report on system information and all previous versions of the system"),
	array(
		'name' => "Crew Activity",
		'url' => 'report/activity',
		'group' => 5,
		'desc' => "Can view a report on active crew's activity levels"),
	array(
		'name' => "Posting Levels",
		'url' => 'report/posting',
		'group' => 5,
		'desc' => "Can view a report on posting levels for all playing characters"),
	array(
		'name' => "Moderation",
		'url' => 'report/moderation',
		'group' => 5,
		'desc' => "Can view a report on the moderation status of users"),
	array(
		'name' => "Milestones",
		'url' => 'report/milestones',
		'group' => 5,
		'desc' => "Can view a report on the milestones of users"),
	array(
		'name' => "Award Nominations",
		'url' => 'report/awardnominations',
		'group' => 5,
		'desc' => "Can view a report on all award nominations"),
	array(
		'name' => "Applications",
		'url' => 'report/applications',
		'group' => 5,
		'desc' => "Can view a report on all applications submitted through the system"),
	array(
		'name' => "Sim Statistics",
		'url' => 'report/stats',
		'group' => 5,
		'desc' => "Can view a report on sim statistics for the current and previous months"),
		
	array(
		'name' => "Character Management",
		'url' => 'characters/index',
		'group' => 6,
		'desc' => "Can manage all playing characters including accepting and rejecting applicants"),
	array(
		'name' => "NPC Management (Level 1)",
		'url' => 'characters/npcs',
		'level' => 1,
		'group' => 6,
		'desc' => "Can manage any non-playing characters in their primary department (first position only)"),
	array(
		'name' => "NPC Management (Level 2)",
		'url' => 'characters/npcs',
		'level' => 2,
		'group' => 6,
		'desc' => "Can manage any non-playing characters in any of their departments (first and second positions)"),
	array(
		'name' => "NPC Management (Level 3)",
		'url' => 'characters/npcs',
		'level' => 3,
		'group' => 6,
		'desc' => "Can manage all non-playing characters in the system"),
	array(
		'name' => "Chain of Command",
		'url' => 'characters/coc',
		'group' => 6,
		'desc' => "Can add, delete and edit the chain of command"),
	array(
		'name' => "Character Bio (Level 1)",
		'url' => 'characters/bio',
		'level' => 1,
		'group' => 6,
		'desc' => "Can edit the bio of any of their own characters"),
	array(
		'name' => "Character Bio (Level 2)",
		'url' => 'characters/bio',
		'level' => 2,
		'group' => 6,
		'desc' => "Can edit the bio of any of their characters as well as any NPC in the system"),
	array(
		'name' => "Character Bio (Level 3)",
		'url' => 'characters/bio',
		'level' => 3,
		'group' => 6,
		'desc' => "Can edit any character in the system, including rank and position"),
	array(
		'name' => "Create Character (Level 1)",
		'url' => 'characters/create',
		'level' => 1,
		'group' => 6,
		'desc' => "Can create playing and non-playing characters but playing characters require approval"),
	array(
		'name' => "Create Character (Level 2)",
		'url' => 'characters/create',
		'level' => 2,
		'group' => 6,
		'desc' => "Can create playing and non-playing characters without any approval"),
	array(
		'name' => "Give/Remove Award",
		'url' => 'characters/awards',
		'group' => 6,
		'desc' => "Can give/remove awards to/from any character in the system"),
	
	array(
		'name' => "User Account (Level 1)",
		'url' => 'users/account',
		'group' => 7,
		'level' => 1,
		'desc' => "Can update their own account settings"),
	array(
		'name' => "User Account (Level 2)",
		'url' => 'users/account',
		'group' => 7,
		'level' => 2,
		'desc' => "Can update any account in the system including moderation flags and admin items"),
	array(
		'name' => "Crew Award Nominations (Level 1)",
		'url' => 'users/nominate',
		'group' => 7,
		'level' => 1,
		'desc' => "Can nominate playing and non-playing characters for awards"),
	array(
		'name' => "Crew Award Nominations (Level 2)",
		'url' => 'users/nominate',
		'group' => 7,
		'level' => 2,
		'desc' => "Can nominate playing and non-playing characters for awards as well as approving/rejecting pending award nominations"),
		
	array(
		'name' => "Wiki Pages (Level 1)",
		'url' => 'wiki/page',
		'group' => 8,
		'level' => 1,
		'desc' => "Can create wiki pages and edit any pages they have created, including viewing history and reverting to previous drafts"),
	array(
		'name' => "Wiki Pages (Level 2)",
		'url' => 'wiki/page',
		'group' => 8,
		'level' => 2,
		'desc' => "Can create wiki pages and edit all pages, including viewing history and reverting to previous drafts"),
	array(
		'name' => "Wiki Pages (Level 3)",
		'url' => 'wiki/page',
		'group' => 8,
		'level' => 3,
		'desc' => "Can create, delete and edit all wiki pages, including viewing history and reverting to previous drafts"),
	array(
		'name' => "Wiki Categories",
		'url' => 'wiki/categories',
		'group' => 8,
		'desc' => "Can create, delete and edit wiki categories"),
);

$access_roles = array(
	array(
		'name' => 'System Administrator',
		'pages' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,31,33,35,36,37,38,39,40,41,42,43,44,45,46,49,50,53,55,56,58,60,63,64',
		'desc' => 'System administrators can take any action in the system. Only give this access level out to people you implicitly trust.'),
	array(
		'name' => 'Basic Administrator',
		'pages' => '1,2,3,4,5,6,7,8,20,21,22,27,31,33,35,37,39,40,41,42,43,44,45,46,49,53,54,58,59,63,64',
		'desc' => 'Basic administrators have power to do some of the tasks system administrators do, but with more restrictions. This role is intended to be used senior players on the RPG.'),
	array(
		'name' => 'Power User',
		'pages' => '1,2,4,5,6,7,8,30,32,34,39,40,42,45,48,52,54,57,59,62',
		'desc' => 'Power users are users that can take more action than a standard user. This role is intended to be used for senior players on the RPG (department heads for example).'),
	array(
		'name' => 'Standard User',
		'pages' => '1,2,4,5,6,7,8,30,32,34,39,40,42,45,51,54,57,59,61',
		'desc' => 'Standard users are generally the majority of players. This role gives them access to all the pieces they will need to play the game and use the system.'),
	array(
		'name' => 'Inactive User',
		'pages' => '1,4,45,51,54,57',
		'desc' => 'Inactive players are players that have left the RPG. Instead of being completely locked out, the player can log in and take some very limited actions.')
);

$catalogue_modules = array(
	array(
		'name' => 'SMS Upgrade',
		'short_name' => 'upgrade',
		'location' => 'nova/upgrade',
		'desc' => "The SMS Upgrade module allows for upgrading from SMS 2.6.9 or higher to Nova 2.",
		'protected' => 1,
		'status' => 'active',
		'credits' => "The SMS Upgrade module was developed by Anodyne Productions."),
	array(
		'name' => 'Nova User Guide',
		'short_name' => 'userguide',
		'location' => 'kohana/userguide',
		'desc' => "The Nova User Guide is meant for getting quick information about Nova and for developers looking for a full blown API Browser for Nova's various classes.",
		'protected' => 1,
		'status' => 'active',
		'credits' => "The Nova User Guide was developed by Anodyne Productions."),
	array(
		'name' => 'About Nova',
		'short_name' => 'about_nova',
		'location' => 'third_party/about_nova',
		'desc' => "The About Nova module is a test 3rd party module that should be used as a guide for how to develop modules for Nova 2.",
		'protected' => 0,
		'status' => 'inactive',
		'credits' => "The About Nova module was developed by Anodyne Productions."),
);

$catalogue_skins = array(
	array(
		'name' => 'Beta',
		'location' => 'beta',
		'credits' => 'The Beta skin was created by Anodyne Productions. Edits are permissible provided the original credits remain intact.',
		'version' => '1.0'),
);

$catalogue_skinsecs = array(
	array(
		'section' => 'main',
		'skin' => 'beta',
		'preview' => 'preview-main.jpg',
		'default' => 1),
	array(
		'section' => 'login',
		'skin' => 'beta',
		'preview' => 'preview-login.jpg',
		'default' => 1),
	array(
		'section' => 'admin',
		'skin' => 'beta',
		'preview' => 'preview-admin.jpg',
		'default' => 1),
);

$forms = array(
	array(
		'key' => 'bio',
		'name' => 'Bio/Join Form'),
	array(
		'key' => 'specs',
		'name' => 'Specifications Form'),
	array(
		'key' => 'tour',
		'name' => 'Tour Form'),
	array(
		'key' => 'docking',
		'name' => 'Docking Form'),
	array(
		'key' => 'user',
		'name' => 'User Information'),
);

$form_fields = array(
	array(
		'form_key' => 'bio',
		'section_id' => 1,
		'type' => 'select',
		'html_name' => 'gender',
		'html_id' => 'gender',
		'html_rows' => 0,
		'label' => 'Gender',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 1,
		'type' => 'text',
		'html_name' => 'species',
		'html_id' => 'species',
		'html_rows' => 0,
		'label' => 'Species',
		'placeholder' => 'e.g. Human',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'section_id' => 1,
		'type' => 'text',
		'html_name' => 'age',
		'html_id' => 'age',
		'html_rows' => 0,
		'html_class' => 'small',
		'label' => 'Age',
		'placeholder' => 'Age',
		'order' => 3),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'text',
		'html_name' => 'height',
		'html_id' => 'height',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Height',
		'placeholder' => 'e.g. 6\'2"',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'text',
		'html_name' => 'weight',
		'html_id' => 'weight',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Weight',
		'placeholder' => 'e.g. 215 lbs.',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'text',
		'html_name' => 'hair_color',
		'html_id' => 'hair_color',
		'html_rows' => 0,
		'label' => 'Hair Color',
		'placeholder' => 'Hair Color',
		'order' => 3),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'text',
		'html_name' => 'eye_color',
		'html_id' => 'eye_color',
		'html_rows' => 0,
		'label' => 'Eye Color',
		'placeholder' => 'Eye Color',
		'order' => 4),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'textarea',
		'html_name' => 'physical_desc',
		'html_id' => 'physical_desc',
		'html_rows' => 3,
		'label' => 'Physical Description',
		'placeholder' => 'Enter your physical description here',
		'order' => 5),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'text',
		'html_name' => 'spouse',
		'html_id' => 'spouse',
		'html_rows' => 0,
		'label' => 'Spouse',
		'placeholder' => 'Spouse',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'textarea',
		'html_name' => 'children',
		'html_id' => 'children',
		'html_rows' => 3,
		'label' => 'Children',
		'placeholder' => 'Enter your character\'s children here',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'text',
		'html_name' => 'father',
		'html_id' => 'father',
		'html_rows' => 0,
		'label' => 'Father',
		'placeholder' => 'Father',
		'order' => 3),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'text',
		'html_name' => 'mother',
		'html_id' => 'mother',
		'html_rows' => 0,
		'label' => 'Mother',
		'placeholder' => 'Mother',
		'order' => 4),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'textarea',
		'html_name' => 'siblings',
		'html_id' => 'siblings',
		'html_rows' => 3,
		'label' => 'Siblings',
		'placeholder' => 'Enter your character\'s siblings here',
		'order' => 5),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'text',
		'html_name' => 'other_family',
		'html_id' => 'other_family',
		'html_rows' => 3,
		'label' => 'Other Family',
		'placeholder' => 'Enter your character\'s other family here',
		'order' => 6),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'personality',
		'html_id' => 'personality',
		'html_rows' => 5,
		'label' => 'General Overview',
		'placeholder' => 'Enter your character\'s general personality overview here',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'strengths',
		'html_id' => 'strengths',
		'html_rows' => 5,
		'label' => 'Strengths &amp; Weaknesses',
		'placeholder' => 'Enter your character\'s strengths and weaknesses here',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'ambitions',
		'html_id' => 'ambitions',
		'html_rows' => 5,
		'label' => 'Ambitions',
		'placeholder' => 'Enter your character\'s ambitions here',
		'order' => 3),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'hobbies',
		'html_id' => 'hobbies',
		'html_rows' => 5,
		'label' => 'Hobbies &amp; Interests',
		'placeholder' => 'Enter your character\'s hobbies and interests here',
		'order' => 4),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'languages',
		'html_id' => 'languages',
		'html_rows' => 2,
		'label' => 'Languages',
		'placeholder' => 'Enter your character\'s known languages here',
		'order' => 5),
	array(
		'form_key' => 'bio',
		'section_id' => 5,
		'type' => 'textarea',
		'html_name' => 'history',
		'html_id' => 'history',
		'html_rows' => 15,
		'label' => 'History',
		'placeholder' => 'Enter your character\'s personal history here',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 5,
		'type' => 'textarea',
		'html_name' => 'service_record',
		'html_id' => 'service_record',
		'html_rows' => 15,
		'label' => 'Service Record',
		'placeholder' => 'Enter your character\'s service record here',
		'order' => 2),
	array(
		'form_key' => 'docking',
		'section_id' => 6,
		'type' => 'text',
		'html_name' => 'duration',
		'html_id' => 'duration',
		'html_rows' => 0,
		'label' => 'Duration',
		'placeholder' => 'Enter the duration of your stay',
		'order' => 1),
	array(
		'form_key' => 'docking',
		'section_id' => 6,
		'type' => 'textarea',
		'html_name' => 'reason',
		'html_id' => 'reason',
		'html_rows' => 5,
		'label' => 'Reason for Docking',
		'placeholder' => 'Enter your reason for docking here',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'class',
		'html_id' => 'class',
		'html_rows' => 0,
		'label' => 'Class',
		'placeholder' => 'Enter the class of vessel',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'role',
		'html_id' => 'role',
		'html_rows' => 0,
		'label' => 'Role',
		'placeholder' => 'Enter the role of the vessel',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'duration',
		'html_id' => 'duration',
		'html_rows' => 0,
		'label' => 'Duration',
		'placeholder' => 'Enter the duration of the vessel',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'refit',
		'html_id' => 'refit',
		'html_rows' => 0,
		'label' => 'Time Between Refits',
		'placeholder' => 'Enter the time between refits for this vessel',
		'order' => 3),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'resupply',
		'html_id' => 'resupply',
		'html_rows' => 0,
		'label' => 'Time Between Resupply',
		'placeholder' => 'Enter the time between resupply of this vessel',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 8,
		'type' => 'text',
		'html_name' => 'length',
		'html_id' => 'length',
		'html_rows' => 0,
		'label' => 'Length',
		'placeholder' => 'e.g. 415 meters',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 8,
		'type' => 'text',
		'html_name' => 'width',
		'html_id' => 'width',
		'html_rows' => 0,
		'label' => 'Width',
		'placeholder' => 'e.g. 75 meters',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 8,
		'type' => 'text',
		'html_name' => 'height',
		'html_id' => 'height',
		'html_rows' => 0,
		'label' => 'Height',
		'placeholder' => 'e.g. 45 meters',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 8,
		'type' => 'text',
		'html_name' => 'decks',
		'html_id' => 'decks',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Decks',
		'placeholder' => 'e.g. 10',
		'order' => 3),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_officers',
		'html_id' => 'compliment_officers',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Officers',
		'placeholder' => 'e.g. 60',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_enlisted',
		'html_id' => 'compliment_enlisted',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Enlisted Crew',
		'placeholder' => 'e.g. 500',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_marines',
		'html_id' => 'compliment_marines',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Marines',
		'placeholder' => 'e.g. 48',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_civilians',
		'html_id' => 'compliment_civilians',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Civilians',
		'placeholder' => 'e.g. 200',
		'order' => 3),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_emergency',
		'html_id' => 'compliment_emergency',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Emergency Capacity',
		'placeholder' => 'e.g. 2000',
		'order' => 4),
	array(
		'form_key' => 'specs',
		'section_id' => 10,
		'type' => 'text',
		'html_name' => 'speed_normal',
		'html_id' => 'speed_normal',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Cruise Speed',
		'placeholder' => 'e.g. Warp 6',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 10,
		'type' => 'text',
		'html_name' => 'speed_max',
		'html_id' => 'speed_max',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Maximum Speed',
		'placeholder' => 'e.g. Warp 9',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 10,
		'type' => 'text',
		'html_name' => 'speed_emergency',
		'html_id' => 'speed_emergency',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Emergency Speed',
		'placeholder' => 'e.g. Warp 9.9975',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 11,
		'type' => 'textarea',
		'html_name' => 'defensive',
		'html_id' => 'defensive',
		'html_rows' => 5,
		'label' => 'Shields',
		'placeholder' => 'e.g. Enter your vessel\'s defensive systems here',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 11,
		'type' => 'textarea',
		'html_name' => 'weapons',
		'html_id' => 'weapons',
		'html_rows' => 5,
		'label' => 'Weapon Systems',
		'placeholder' => 'e.g. Enter your vessel\'s weapon systems here',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 11,
		'type' => 'textarea',
		'html_name' => 'armament',
		'html_id' => 'armament',
		'html_rows' => 5,
		'label' => 'Armament',
		'placeholder' => 'e.g. Enter your vessel\'s armament here',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 12,
		'type' => 'text',
		'html_name' => 'shuttlebays',
		'html_id' => 'shuttlebays',
		'html_rows' => 0,
		'html_class' => 'small',
		'label' => 'Shuttlebays',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 12,
		'type' => 'textarea',
		'html_name' => 'shuttles',
		'html_id' => 'shuttles',
		'html_rows' => 5,
		'label' => 'Shuttles',
		'placeholder' => 'Enter your vessel\'s shuttles here',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 12,
		'type' => 'textarea',
		'html_name' => 'fighters',
		'html_id' => 'fighters',
		'html_rows' => 5,
		'label' => 'Fighters',
		'placeholder' => 'Enter your vessel\'s fighters here',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 12,
		'type' => 'textarea',
		'html_name' => 'runabouts',
		'html_id' => 'runabouts',
		'html_rows' => 5,
		'label' => 'Runabouts',
		'placeholder' => 'Enter your vessel\'s runabouts here',
		'order' => 3),
	array(
		'form_key' => 'tour',
		'type' => 'text',
		'html_name' => 'location',
		'html_id' => 'location',
		'html_rows' => 0,
		'label' => 'Location',
		'placeholder' => 'Enter the tour item\'s location here',
		'order' => 0),
	array(
		'form_key' => 'tour',
		'type' => 'textarea',
		'html_name' => 'long_desc',
		'html_id' => 'long_desc',
		'html_rows' => 5,
		'label' => 'Description',
		'placeholder' => 'Enter the tour item\'s description here',
		'order' => 1),
	array(
		'form_key' => 'user',
		'type' => 'text',
		'html_name' => 'location',
		'html_id' => 'location',
		'html_rows' => 0,
		'label' => 'Location',
		'placeholder' => 'Enter your location here',
		'order' => 0),
	array(
		'form_key' => 'user',
		'type' => 'textarea',
		'html_name' => 'interests',
		'html_id' => 'interests',
		'html_rows' => 5,
		'label' => 'Interests',
		'placeholder' => 'Enter your interests here',
		'order' => 1),
	array(
		'form_key' => 'user',
		'type' => 'textarea',
		'html_name' => 'bio',
		'html_id' => 'bio',
		'html_rows' => 5,
		'label' => 'Bio',
		'placeholder' => 'Enter your bio information here',
		'order' => 2),
);

$form_sections = array(
	array(
		'form_key' => 'bio',
		'tab_id' => 1,
		'name' => 'Character Information',
		'order' => 0),
	array(
		'form_key' => 'bio',
		'tab_id' => 1,
		'name' => 'Physical Appearance',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'tab_id' => 1,
		'name' => 'Family',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'tab_id' => 2,
		'name' => 'Personality &amp; Traits',
		'order' => 0),
	array(
		'form_key' => 'bio',
		'tab_id' => 3,
		'name' => '',
		'order' => 0),
	array(
		'form_key' => 'docking',
		'name' => 'Details',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'name' => 'General',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'name' => 'Dimensions',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'name' => 'Personnel',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'name' => 'Speed',
		'order' => 3),
	array(
		'form_key' => 'specs',
		'name' => 'Weapons &amp; Defensive Systems',
		'order' => 4),
	array(
		'form_key' => 'specs',
		'name' => 'Auxiliary Craft',
		'order' => 5),
);

$form_tabs = array(
	array(
		'form_key' => 'bio',
		'name' => 'Basic Info',
		'link_id' => 'one',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'name' => 'Personality',
		'link_id' => 'two',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'name' => 'History',
		'link_id' => 'three',
		'order' => 3),
);

$form_values = array(
	array(
		'field_id' => 1,
		'html_name' => 'gender',
		'html_value' => 'Male',
		'html_id' => 'male',
		'content' => 'Male',
		'order' => 1),
	array(
		'field_id' => 1,
		'html_name' => 'gender',
		'html_value' => 'Female',
		'html_id' => 'female',
		'content' => 'Female',
		'order' => 2),
	array(
		'field_id' => 1,
		'html_name' => 'gender',
		'html_value' => 'Hermaphrodite',
		'html_id' => 'hermaphrodite',
		'content' => 'Hermaphrodite',
		'order' => 3),
	array(
		'field_id' => 1,
		'html_name' => 'gender',
		'html_value' => 'Neuter',
		'html_id' => 'neuter',
		'content' => 'Neuter',
		'order' => 4),
);

$menu_categories = array(
	array(
		'name' => 'Main',
		'order' => 0,
		'category' => 'main',
		'type' => 'sub'),
	array(
		'name' => 'Personnel',
		'order' => 1,
		'category' => 'personnel',
		'type' => 'sub'),
	array(
		'name' => 'The Sim',
		'order' => 2,
		'category' => 'sim',
		'type' => 'sub'),
	array(
		'name' => 'Main',
		'order' => 3,
		'category' => 'admin',
		'type' => 'adminsub',
		'landing_page' => 'admin/index'),
	array(
		'name' => 'Write',
		'order' => 4,
		'category' => 'write',
		'type' => 'adminsub',
		'landing_page' => 'admin/write/index'),
	array(
		'name' => 'Messages',
		'order' => 5,
		'category' => 'messages',
		'type' => 'adminsub',
		'landing_page' => 'admin/messages/index'),
	array(
		'name' => 'Site',
		'order' => 6,
		'category' => 'site',
		'type' => 'adminsub',
		'landing_page' => 'admin/site/index'),
	array(
		'name' => 'Manage',
		'order' => 7,
		'category' => 'manage',
		'type' => 'adminsub',
		'landing_page' => 'admin/manage/index'),
	array(
		'name' => 'Characters',
		'order' => 8,
		'category' => 'characters',
		'type' => 'adminsub',
		'landing_page' => 'admin/characters/index'),
	array(
		'name' => 'Users',
		'order' => 9,
		'category' => 'users',
		'type' => 'adminsub',
		'landing_page' => 'admin/users/index'),
	array(
		'name' => 'Reports',
		'order' => 10,
		'category' => 'reports',
		'type' => 'adminsub',
		'landing_page' => 'admin/reports/index'),
	array(
		'name' => 'Wiki',
		'order' => 11,
		'category' => 'wiki',
		'type' => 'sub'),
);

$menu_items = array(
	array(
		'name' => 'Main',
		'group' => 0,
		'order' => 0,
		'url' => 'main/index',
		'sim_type' => 1,
		'category' => 'main'),
	/*array(
		'name' => 'Personnel',
		'group' => 0,
		'order' => 1,
		'url' => 'personnel/index',
		'sim_type' => 1,
		'category' => 'main'),
	array(
		'name' => 'Sim',
		'group' => 0,
		'order' => 2,
		'url' => 'sim/index',
		'sim_type' => 1,
		'category' => 'main'),
	array(
		'name' => 'Wiki',
		'group' => 0,
		'order' => 3,
		'url' => 'wiki/index',
		'sim_type' => 1,
		'category' => 'main',
		'display' => 1),
	array(
		'name' => 'Search',
		'group' => 0,
		'order' => 4,
		'url' => 'search/index',
		'sim_type' => 1,
			'category' => 'main'),*/
	array(
		'name' => 'Control Panel',
		'group' => 0,
		'order' => 5,
		'url' => 'admin/index',
		'sim_type' => 1,
		'category' => 'main',
		'needs_login' => 'y'),
	array(
		'name' => 'Log In',
		'group' => 0,
		'order' => 6,
		'url' => 'login/index',
		'sim_type' => 1,
		'category' => 'main',
		'needs_login' => 'n'),
	array(
		'name' => 'Log Out',
		'group' => 0,
		'order' => 7,
		'url' => 'login/logout',
		'sim_type' => 1,
		'category' => 'main',
		'needs_login' => 'y'),
		
	array(
		'name' => 'Main',
		'group' => 0,
		'order' => 0,
		'url' => 'main/index',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'main'),
	/*array(
		'name' => 'News',
		'group' => 0,
		'order' => 1,
		'url' => 'main/news',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'main'),
	array(
		'name' => 'Contact',
		'group' => 0,
		'order' => 2,
		'url' => 'main/contact',
		'sim_type' => 1,
		'type' => 'sub',
			'category' => 'main'),*/
	array(
		'name' => 'Credits',
		'group' => 0,
		'order' => 3,
		'url' => 'main/credits',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'main'),
	/*array(
		'name' => 'Join',
		'group' => 0,
		'order' => 4,
		'url' => 'main/join',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'main'),
	array(
		'name' => 'Search',
		'group' => 0,
		'order' => 5,
		'url' => 'search/index',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'main'),
		
	array(
		'name' => 'Manifest',
		'group' => 0,
		'order' => 0,
		'url' => 'personnel/index',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'),
	array(
		'name' => 'Chain of Command',
		'group' => 0,
		'order' => 1,
		'url' => 'personnel/coc',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'),
	array(
		'name' => 'Awards',
		'group' => 0,
		'order' => 2,
		'url' => 'sim/awards',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'),
	array(
		'name' => 'Join',
		'group' => 0,
		'order' => 3,
		'url' => 'main/join',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'),
	
	array(
		'name' => 'The Sim',
		'group' => 0,
		'order' => 0,
		'url' => 'sim/index',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Missions',
		'group' => 0,
		'order' => 1,
		'url' => 'sim/missions',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Mission Groups',
		'group' => 0,
		'order' => 2,
		'url' => 'sim/missions/group',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Personal Logs',
		'group' => 0,
		'order' => 3,
		'url' => 'sim/listlogs',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Stats',
		'group' => 0,
		'order' => 4,
		'url' => 'sim/stats',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Crew Awards',
		'group' => 0,
		'order' => 5,
		'url' => 'sim/awards',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Tour',
		'group' => 1,
		'order' => 0,
		'url' => 'sim/tour',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Specifications',
		'group' => 1,
		'order' => 1,
		'url' => 'sim/specs',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Deck Listing',
		'group' => 1,
		'order' => 2,
		'url' => 'sim/decks',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Departments',
		'group' => 1,
		'order' => 3,
		'url' => 'sim/departments',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Docked Items',
		'group' => 2,
		'order' => 0,
		'url' => 'sim/docked',
		'sim_type' => 3,
		'display' => 0,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Docking Request',
		'group' => 2,
		'order' => 1,
		'url' => 'sim/dockingrequest',
		'sim_type' => 3,
		'display' => 0,
		'type' => 'sub',
		'category' => 'sim'),
		
	array(
		'name' => 'Main Page',
		'group' => 0,
		'order' => 0,
		'url' => 'wiki/index',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'category' => 'wiki'),
	array(
		'name' => 'Recent Changes',
		'group' => 0,
		'order' => 1,
		'url' => 'wiki/recent',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'category' => 'wiki'),
	array(
		'name' => 'Categories',
		'group' => 0,
		'order' => 2,
		'url' => 'wiki/categories',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'category' => 'wiki'),
	array(
		'name' => 'Manage Pages',
		'group' => 1,
		'order' => 0,
		'url' => 'wiki/managepages',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'use_access' => 1,
		'access' => 'wiki/page',
		'needs_login' => 'y',
		'category' => 'wiki'),
	array(
		'name' => 'Manage Categories',
		'group' => 1,
		'order' => 1,
		'url' => 'wiki/managecategories',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'use_access' => 1,
		'access' => 'wiki/categories',
		'needs_login' => 'y',
		'category' => 'wiki'),
	array(
		'name' => 'Create New Page',
		'group' => 2,
		'order' => 0,
		'url' => 'wiki/page',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'use_access' => 1,
		'access' => 'wiki/page',
		'needs_login' => 'y',
		'category' => 'wiki'),*/
		
	array(
		'name' => 'Control Panel',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'admin',
		'use_access' => 1,
		'access' => 'admin/index'),
	/*array(
		'name' => "What's New",
		'group' => 0,
		'order' => 1,
		'url' => 'admin/whatsnew',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'admin',
		'use_access' => 1,
		'access' => 'admin/index'),
		
	array(
		'name' => 'Writing Control Panel',
		'group' => 0,
		'order' => 0,
		'url' => 'write/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'write',
		'use_access' => 1,
		'access' => 'write/index'),
	array(
		'name' => 'Write Mission Post',
		'group' => 0,
		'order' => 1,
		'url' => 'write/missionpost',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'write',
		'use_access' => 1,
		'access' => 'write/missionpost'),
	array(
		'name' => 'Write Personal Log',
		'group' => 0,
		'order' => 2,
		'url' => 'write/personallog',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'write',
		'use_access' => 1,
		'access' => 'write/personallog'),
	array(
		'name' => 'Write News Item',
		'group' => 0,
		'order' => 3,
		'url' => 'write/newsitem',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'write',
		'use_access' => 1,
		'access' => 'write/newsitem'),
		
	array(
		'name' => 'Inbox',
		'group' => 0,
		'order' => 0,
		'url' => 'messages/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'messages',
		'use_access' => 1,
		'access' => 'messages/index'),
	array(
		'name' => 'Sent Messages',
		'group' => 0,
		'order' => 1,
		'url' => 'messages/index/sent',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'messages',
		'use_access' => 1,
		'access' => 'messages/index'),
	array(
		'name' => 'Write New Message',
		'group' => 0,
		'order' => 2,
		'url' => 'messages/write',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'messages',
		'use_access' => 1,
		'access' => 'messages/index'),
		
	array(
		'name' => 'Settings',
		'group' => 0,
		'order' => 0,
		'url' => 'site/settings',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/settings'),
	array(
		'name' => 'Messages &amp; Titles',
		'group' => 0,
		'order' => 1,
		'url' => 'site/messages',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/messages'),
	array(
		'name' => 'Menu Items',
		'group' => 0,
		'order' => 2,
		'url' => 'site/menus',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/menus'),
	array(
		'name' => 'Access Roles',
		'group' => 0,
		'order' => 3,
		'url' => 'site/roles',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/roles'),
	array(
		'name' => 'Bio Form',
		'group' => 1,
		'order' => 0,
		'url' => 'site/bioform',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/bioform'),
	array(
		'name' => 'Specs Form',
		'group' => 1,
		'order' => 1,
		'url' => 'site/specsform',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/specsform'),
	array(
		'name' => 'Tour Form',
		'group' => 1,
		'order' => 2,
		'url' => 'site/tourform',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/tourform'),
	array(
		'name' => 'Docking Form',
		'group' => 1,
		'order' => 3,
		'url' => 'site/dockingform',
		'sim_type' => 3,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/dockingform'),
	array(
		'name' => 'Sim Types',
		'group' => 2,
		'order' => 0,
		'url' => 'site/simtypes',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/simtypes'),
	array(
		'name' => 'Rank Catalogue',
		'group' => 2,
		'order' => 1,
		'url' => 'site/catalogueranks',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/catalogueranks'),
	array(
		'name' => 'Skin Catalogue',
		'group' => 2,
		'order' => 2,
		'url' => 'site/catalogueskins',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/catalogueskins'),
		
	array(
		'name' => 'Awards',
		'group' => 0,
		'order' => 0,
		'url' => 'manage/awards',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/awards'),
	array(
		'name' => 'Departments',
		'group' => 0,
		'order' => 1,
		'url' => 'manage/depts',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/depts'),
	array(
		'name' => 'Positions',
		'group' => 0,
		'order' => 2,
		'url' => 'manage/positions',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/positions'),
	array(
		'name' => 'Ranks',
		'group' => 0,
		'order' => 3,
		'url' => 'manage/ranks',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/ranks'),
	array(
		'name' => 'Missions',
		'group' => 1,
		'order' => 0,
		'url' => 'manage/missions',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/missions'),
	array(
		'name' => 'Mission Groups',
		'group' => 1,
		'order' => 1,
		'url' => 'manage/missiongroups',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/missions'),
	array(
		'name' => 'Mission Posts',
		'group' => 1,
		'order' => 2,
		'url' => 'manage/posts',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/posts'),
	array(
		'name' => 'Personal Logs',
		'group' => 1,
		'order' => 3,
		'url' => 'manage/logs',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/logs'),
	array(
		'name' => 'News Items',
		'group' => 1,
		'order' => 4,
		'url' => 'manage/news',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/news'),
	array(
		'name' => 'News Categories',
		'group' => 1,
		'order' => 5,
		'url' => 'manage/newscats',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/newscats'),
	array(
		'name' => 'Comments',
		'group' => 1,
		'order' => 6,
		'url' => 'manage/comments',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/comments'),
	array(
		'name' => 'Specs',
		'group' => 2,
		'order' => 0,
		'url' => 'manage/specs',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/specs'),
	array(
		'name' => 'Tour',
		'group' => 2,
		'order' => 1,
		'url' => 'manage/tour',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/tour'),
	array(
		'name' => 'Deck Listing',
		'group' => 2,
		'order' => 2,
		'url' => 'manage/decks',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/decks'),
	array(
		'name' => 'Docked Items',
		'group' => 2,
		'order' => 3,
		'url' => 'manage/docked',
		'sim_type' => 3,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/docked'),
		
	array(
		'name' => 'Upload Images',
		'group' => 3,
		'order' => 0,
		'url' => 'upload/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 0),
	array(
		'name' => 'Manage Uploads',
		'group' => 3,
		'order' => 1,
		'url' => 'upload/manage',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'upload/manage'),
		
	array(
		'name' => 'All Characters',
		'group' => 0,
		'order' => 0,
		'url' => 'characters/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/index'),
	array(
		'name' => 'All NPCs',
		'group' => 0,
		'order' => 1,
		'url' => 'characters/npcs',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/npcs'),
	array(
		'name' => 'Create Character',
		'group' => 0,
		'order' => 2,
		'url' => 'characters/create',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/create'),
	array(
		'name' => 'Chain of Command',
		'group' => 1,
		'order' => 0,
		'url' => 'characters/coc',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/coc'),
	array(
		'name' => 'Give/Remove Awards',
		'group' => 1,
		'order' => 1,
		'url' => 'characters/awards',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/awards'),
	*/	
	array(
		'name' => 'My Account',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/users/account',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'users/account'),
	/*array(
		'name' => 'My Bio',
		'group' => 0,
		'order' => 1,
		'url' => 'characters/bio',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'characters/bio'),
	array(
		'name' => 'Site Options',
		'group' => 1,
		'order' => 0,
		'url' => 'user/options',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'user/account'),*/
	array(
		'name' => 'Request LOA',
		'group' => 0,
		'order' => 1,
		'url' => 'admin/users/status',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'users/account'),
	array(
		'name' => 'Award Nominations',
		'group' => 0,
		'order' => 2,
		'url' => 'admin/users/nominate',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'users/nominate'),
	array(
		'name' => 'All Users',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/users/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'users/account',
		'access_level' => 2),
	array(
		'name' => 'Link Characters',
		'group' => 1,
		'order' => 1,
		'url' => 'admin/users/link',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'users/account',
		'access_level' => 2),
	/*	
	array(
		'name' => 'Crew Activity',
		'group' => 0,
		'order' => 0,
		'url' => 'report/activity',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'report',
		'use_access' => 1,
		'access' => 'report/activity'),
	array(
		'name' => 'Posting Levels',
		'group' => 0,
		'order' => 1,
		'url' => 'report/posting',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'report',
		'use_access' => 1,
		'access' => 'report/posting'),
	array(
		'name' => 'Sim Statistics',
		'group' => 0,
		'order' => 2,
		'url' => 'report/stats',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'report',
		'use_access' => 1,
		'access' => 'report/stats'),
	array(
		'name' => 'Moderation',
		'group' => 1,
		'order' => 0,
		'url' => 'report/moderation',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'report',
		'use_access' => 1,
		'access' => 'report/moderation'),
	array(
		'name' => 'Milestones',
		'group' => 1,
		'order' => 1,
		'url' => 'report/milestones',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'report',
		'use_access' => 1,
		'access' => 'report/milestones'),
	array(
		'name' => 'LOA Records',
		'group' => 1,
		'order' => 2,
		'url' => 'report/loa',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'report',
		'use_access' => 1,
		'access' => 'report/loa'),
	array(
		'name' => 'Award Nominations',
		'group' => 1,
		'order' => 3,
		'url' => 'report/awardnominations',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'report',
		'use_access' => 1,
		'access' => 'report/awardnominations'),
	array(
		'name' => 'Applications',
		'group' => 1,
		'order' => 4,
		'url' => 'report/applications',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'report',
		'use_access' => 1,
		'access' => 'report/applications'),
	array(
		'name' => 'System &amp; Versions',
		'group' => 1,
		'order' => 5,
		'url' => 'report/versions',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'report',
		'use_access' => 1,
			'access' => 'report/versions'),*/
);

$news_categories = array(
	array('name' => 'General News'),
	array('name' => 'Out of Character'),
	array('name' => 'Sim Announcement'),
	array('name' => 'Website Update')
);

$security_questions = array(
	array('value' => "What is your father's middle name?"),
	array('value' => "What was the name of your first pet?"),
	array('value' => "What city were you born in?"),
	array('value' => "What is your favorite animal?"),
	array('value' => "Who was your favorite teacher?"),
	array('value' => "What is the last book you read?")
);

$settings = array(
	array(
		'key' => 'sim_name',
		'value' => '',
		'user_created' => 0),
	array(
		'key' => 'sim_year',
		'value' => '',
		'user_created' => 0),
	array(
		'key' => 'sim_type',
		'value' => 2,
		'user_created' => 0),
	array(
		'key' => 'maintenance',
		'value' => 'off',
		'user_created' => 0),
	array(
		'key' => 'skin_main',
		'value' => 'beta',
		'user_created' => 0),
	array(
		'key' => 'skin_admin',
		'value' => 'beta',
		'user_created' => 0),
	array(
		'key' => 'skin_wiki',
		'value' => 'beta',
		'user_created' => 0),
	array(
		'key' => 'skin_login',
		'value' => 'beta',
		'user_created' => 0),
	array(
		'key' => 'display_rank',
		'value' => 'default',
		'user_created' => 0),
	array(
		'key' => 'bio_num_awards',
		'value' => 10,
		'user_created' => 0),
	array(
		'key' => 'allowed_chars_playing',
		'value' => 1,
		'user_created' => 0),
	array(
		'key' => 'allowed_chars_npc',
		'value' => 3,
		'user_created' => 0),
	array(
		'key' => 'system_email',
		'value' => 'on',
		'user_created' => 0),
	array(
		'key' => 'email_subject',
		'value' => '',
		'user_created' => 0),
	array(
		'key' => 'timezone',
		'value' => 'UTC',
		'user_created' => 0),
	array(
		'key' => 'daylight_savings',
		'value' => 'false',
		'user_created' => 0),
	array(
		'key' => 'date_format',
		'value' => 'D M jS, Y @ g:ia',
		'user_created' => 0),
	array(
		'key' => 'list_logs_num',
		'value' => 25,
		'user_created' => 0),
	array(
		'key' => 'list_posts_num',
		'value' => 25,
		'user_created' => 0),
	array(
		'key' => 'manifest_defaults',
		'value' => "$('tr.active').show();,$('tr.npc').show();",
		'user_created' => 0),
	array(
		'key' => 'updates',
		'value' => '4',
		'user_created' => 0),
	array(
		'key' => 'show_news',
		'value' => 'y',
		'user_created' => 0),
	array(
		'key' => 'post_count_format',
		'value' => 'multiple',
		'user_created' => 0),
	array(
		'key' => 'use_sample_post',
		'value' => 'y',
		'user_created' => 0),
	array(
		'key' => 'default_email_name',
		'value' => '',
		'user_created' => 0),
	array(
		'key' => 'default_email_address',
		'value' => '',
		'user_created' => 0),
	array(
		'key' => 'use_mission_notes',
		'value' => 'y',
		'user_created' => 0),
	array(
		'key' => 'online_timespan',
		'value' => '5',
		'user_created' => 0),
	array(
		'key' => 'posting_requirement',
		'value' => 14,
		'user_created' => 0),
);

$sim_types = array(
	array('name' => 'all'),
	array('name' => 'ship'),
	array('name' => 'base'),
	array('name' => 'colony'),
	array('name' => 'unit'),
	array('name' => 'realm'),
	array('name' => 'planet'),
	array('name' => 'organization')
);

$site_contents = array(
	array(
		'key' => 'main_index_header',
		'label' => 'Main Page Header',
		'content' => "Welcome to Nova!",
		'type' => 'header',
		'section' => 'main',
		'page' => 'index'),
	array(
		'key' => 'main_index_message',
		'label' => 'Main Page Message',
		'content' => "Define your welcome message and welcome page header through the Site Messages page.",
		'type' => 'message',
		'section' => 'main',
		'page' => 'index'),
	array(
		'key' => 'main_credits_header',
		'label' => 'Site Credits Header',
		'content' => 'Site Credits',
		'type' => 'header',
		'section' => 'main',
		'page' => 'credits'),
	array(
		'key' => 'main_credits_message',
		'label' => 'Credits',
		'content' => "Define your site credits through the Site Messages page.",
		'type' => 'message',
		'section' => 'main',
		'page' => 'credits'),	
	array(
		'key' => 'sim_index_message',
		'label' => 'Sim Message',
		'content' => "Define your sim message through the Site Messages page.",
		'type' => 'message',
		'section' => 'sim',
		'page' => 'index'),
	array(
		'key' => 'sim_index_header',
		'label' => 'Sim Header',
		'content' => "The Sim",
		'type' => 'header',
		'section' => 'sim',
		'page' => 'index'),
		
	array(
		'key' => 'credits_perm',
		'label' => 'Permanent Credits',
		'content' => "Nova 3 has been developed on the elegant HMVC PHP5 framework <a href='http://www.http://kohanaframework.org/' target='_blank'>Kohana 3</a>.\r\n\r\nMany of the icons used throughout Nova were created by <a href='http://http://p.yusukekamiyamane.com/'>Yusuke Kamiyamane</a> as part of the Fugue icon set.",
		'protected' => 1,
		'type' => 'other'),
	array(
		'key' => 'footer',
		'label' => 'Additional Footer Information',
		'content' => "New to Nova 3 is the ability to add additional information to the footer, like banner exchanges, without having to edit any files. Just plug your code/message into the 'Additional Footer Information' site content item!",
		'type' => 'other'),
	array(
		'key' => 'join_disclaimer',
		'label' => 'Join Disclaimer',
		'content' => "Members are expected to follow the rules and regulations of both the sim and fleet at all times, both in character and out of character. By continuing, you affirm that you will sim in a proper and adequate manner. Members who choose to make ultra short posts, post very infrequently, or post posts with explicit content (above PG-13) will be removed immediately, and by continuing, you agree to this. In addition, in compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), we do not accept players under the age of 13.  Any players found to be under the age of 13 will be immediately removed without question.  By agreeing to these terms, you are also saying that you are above the age of 13.",
		'type' => 'other'),
	array(
		'key' => 'join_post',
		'label' => 'Join Sample Post',
		'content' => "Define your join sample post through the Site Message page.",
		'type' => 'other'),
	array(
		'key' => 'accept_message',
		'label' => 'User Acceptance Email',
		'content' => "Define your user acceptance message through the Site Message page.",
		'type' => 'other'),
	array(
		'key' => 'reject_message',
		'label' => 'User Rejection Message',
		'content' => "Define your user rejection message through the Site Messages page.",
		'type' => 'other'),
	array(
		'key' => 'docking_accept_message',
		'label' => 'Docking Acceptance Email',
		'content' => "Define your docking acceptance message through the Site Message page.",
		'type' => 'other'),
	array(
		'key' => 'docking_reject_message',
		'label' => 'Docking Rejection Message',
		'content' => "Define your docking rejection message through the Site Messages page.",
		'type' => 'other'),
);

$system_components = array(
	array(
		'name' => 'Kohana',
		'version' => '3.1.3',
		'url' => 'http://kohanaframework.org/',
		'desc' => 'Kohana is an elegant HMVC PHP5 framework that provides a rich set of components for building web applications. It requires very little configuration, fully supports UTF-8 and I18N, and provides many of the tools that a developer needs within a highly flexible system. The integrated class auto-loading, cascading filesystem, highly consistent API, and easy integration with vendor libraries make it viable for any project, large or small.'),
	array(
		'name' => 'Thresher',
		'version' => 'Release 1',
		'url' => '',
		'desc' => "Thresher is Anodyne Productions' integrated mini-wiki for Nova."),
	array(
		'name' => 'Jelly',
		'version' => '1.0',
		'desc' => "Jelly is a compact but powerful object relational mapper for Kohana 3. Its small, clean and well-documented codebase makes it incredibly lightweight and with complete support for column aliases and an extensible field architecture, Jelly makes database interaction a breeze.",
		'url' => 'http://jelly.jonathan-geiger.com/'),
	array(
		'name' => 'Swift Mailer',
		'version' => '4.0.6',
		'desc' => "Swift Mailer integrates into any web app written in PHP 5, offering a flexible and elegant object-oriented approach to sending emails with a multitude of features.",
		'url' => 'http://swiftmailer.org/'),
	array(
		'name' => 'HTMLPurifier',
		'version' => '4.2.0',
		'desc' => "HTML Purifier is a standards-compliant HTML filter library written in PHP that will not only remove all malicious code (better known as XSS) with a thoroughly audited, secure yet permissive whitelist, it will also make sure your documents are standards compliant.",
		'url' => 'http://htmlpurifier.org/'),
	array(
		'name' => 'jQuery',
		'version' => '1.5.2',
		'url' => 'http://www.jquery.com/',
		'desc' => 'jQuery is a lightweight JavaScript library that emphasizes interaction between JavaScript and HTML.'),
	array(
		'name' => 'jQuery UI',
		'version' => '1.8.12',
		'url' => 'http://jqueryui.com/',
		'desc' => 'jQuery UI is a lightweight, easily customizable interface library for the jQuery Javascript library.'),
	array(
		'name' => 'Facebox',
		'version' => '1.3',
		'desc' => "Facebox is a jQuery-based lightbox which can display images, divs, or entire remote pages.",
		'url' => 'http://famspam.com/facebox'),
	array(
		'name' => 'AjaxQ',
		'version' => '0.0.1',
		'desc' => "AjaxQ is a jQuery plugin that implements an AJAX request queueing mechanism.",
		'url' => 'http://plugins.jquery.com/project/ajaxq'),
	array(
		'name' => 'Lazy',
		'version' => '1.5',
		'desc' => "Lazy is an on-demand jQuery plugin loader, also known as a lazy loader. Instead of downloading all jQuery plugins you might or might not need when the page loads, Lazy downloads the plugins when you actually use them. Lazy is very lightweight, super fast, and smart. Lazy will keep track of all your plugins and dependencies and make sure that they are only downloaded once.",
		'url' => 'http://www.unwrongest.com/projects/lazy/'),
	array(
		'name' => 'Elastic',
		'version' => '1.6.4',
		'desc' => "Elastic is a jQuery plugin that makes your textareas grow and shrink to fit its content. It was inspired by the auto-growing textareas on Facebook. The major difference between Elastic and its competitors is its weight.",
		'url' => 'http://www.unwrongest.com/projects/elastic/'),
	array(
		'name' => 'Reflection.js',
		'version' => '2.0',
		'desc' => "Reflection.js allows you to add reflections to images on your webpages. It uses unobtrusive Javascript to keep your code clean.",
		'url' => 'http://cow.neondragon.net/stuff/reflection/'),
	array(
		'name' => 'jQuery QuickSearch',
		'version' => '',
		'desc' => "QuickSearch is a simple plugin for filtering tables, lists and paragraphs.",
		'url' => 'http://rikrikrik.com/jquery/quicksearch/'),
	array(
		'name' => 'jwysiwyg',
		'version' => '0.9.2',
		'desc' => "A simple rich text editor plugin using jQuery.",
		'url' => 'http://github.com/akzhan/jwysiwyg'),
	array(
		'name' => 'sfYAML',
		'version' => '1.4',
		'desc' => "sfYAML is the YAML parser component from the symfony PHP framework.",
		'url' => 'http://www.symfony-project.org/'),
	array(
		'name' => 'jQuery Countdown',
		'version' => '',
		'desc' => "A simple plugin that counts down and updates the text every second.",
		'url' => 'http://davidwalsh.name/jquery-countdown-plugin'),
	array(
		'name' => 'Uniform',
		'version' => '1.5',
		'desc' => "Uniform masks your standard form controls with custom themed controls. It works in sync with your real form elements to ensure accessibility and compatibility.",
		'url' => 'http://pixelmatrixdesign.com/uniform/'),
);

$system_info = array(
	array(
		'uid' => Text::random('alnum', 32),
		'install_date' => Date::now(),
		'version_major' => 3,
		'version_minor' => 0,
		'version_update' => 0)
);

$system_versions = array(
	array(
		'version' 	=> '1.0.0',
		'major' 	=> '1',
		'minor' 	=> '0',
		'update' 	=> '0',
		'date' 		=> 1271393940,
		'launch'	=> 'Nova 1.0 is the first release of the next generation RPG management software from Anodyne Productions.',
		'changes'	=> "* Initial release"),
	array(
		'version' 	=> '1.0.1',
		'major' 	=> '1',
		'minor' 	=> '0',
		'update' 	=> '1',
		'date' 		=> 1271424600,
		'launch'	=> 'Nova 1.0.1 is a maintenance release that fixes two important issues with Nova 1.0. The release fixes a bug where the upgrade process did not create a necessary field in the missions table as well as two issues with installations oh PHP4 servers. This update is recommended for all users who have upgraded from SMS and/or are running on a PHP4 server.',
		'changes'	=> "* fixed bug in the upgrade process where a database field wasn't added to the table
* fixed bug where models couldn't be autoloaded because Base4 doesn't extend MY_Loader
* fixed error that was thrown because the date_default_timezone_set function doesn't exist in PHP before version 5.1"),
	array(
		'version' 	=> '1.0.2',
		'major' 	=> '1',
		'minor' 	=> '0',
		'update' 	=> '2',
		'date' 		=> 1271817000,
		'launch'	=> 'Nova 1.0.2 is a maintenance release that fixes a majority of the outstanding issues with Nova 1.0, including: login issues, post display issues and bug with posting mission entries. See the changelog after updating for a complete list of changes. This update is recommended for all users.',
		'changes'	=> "* added the 1.0.2 update file
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
		'version' 	=> '1.0.3',
		'major' 	=> '1',
		'minor' 	=> '0',
		'update' 	=> '3',
		'date' 		=> 1272321000,
		'launch'	=> "Nova 1.0.3 is the third maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, several bugs with Thresher, changes to the update center to allow users to update even if they can't get the update information from the Anodyne server, NPC removal issues, updates to the user removal process and much more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'changes'	=> "* added the 1.0.3 update file
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
		'version' 	=> '1.0.4',
		'major' 	=> '1',
		'minor' 	=> '0',
		'update' 	=> '4',
		'date' 		=> 1273705200,
		'launch'	=> "Nova 1.0.4 is the fourth maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, bugs with emails not being sent out on some servers, user access errors and filtering text before going into the database. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'changes'	=> "* added the 1.0.4 update file
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
		'version' 	=> '1.0.5',
		'major' 	=> '1',
		'minor' 	=> '0',
		'update' 	=> '5',
		'date' 		=> 1275865200,
		'launch'	=> "Nova 1.0.5 is the fifth maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, a bug that wouldn't allow unlinked NPCs to use newly created bio fields, a security issue with the docking form and more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'changes'	=> "* added the 1.0.5 update file
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
		'version' 	=> '1.0.6',
		'major' 	=> '1',
		'minor' 	=> '0',
		'update' 	=> '6',
		'date' 		=> 1279148400,
		'launch'	=> "Nova 1.0.6 is the sixth and final maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, a critical CodeIgniter security bug, several bugs with character management, a bug with user management and setting email preferences, updates to the jQuery UI library and other plugins and more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users. Additionally, active testing is underway for Nova 1.1 that will add several new features to the system and will be available later this summer.",
		'changes'	=> "* added the 1.0.6 update file
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
		'version' 	=> '1.1.0',
		'major' 	=> '1',
		'minor' 	=> '1',
		'update' 	=> '0',
		'date' 		=> 1283635800,
		'launch'	=> "Nova 1.1 is the first update to Nova that adds additional features to the system. Included in this release is the ability to create multiple specification items and to associate tour items with specific specification items as well as bug fixes (a bug where editing existing tour items wouldn't update the current item, but the first item). A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'changes'	=> "* added the 1.1 update file
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
		'version' 	=> '1.1.1',
		'major' 	=> '1',
		'minor' 	=> '1',
		'update' 	=> '1',
		'date' 		=> 1285628400,
		'launch'	=> "Nova 1.1.1 is a maintenance update addressing several outstanding issues with Nova 1.1. This update to Nova bumps the jQuery UI to version 1.8.5 and fixes an issue with tour item display when there are no general tour items available. In addition, we've taken steps to address a bug where CodeIgniter wouldn't be able to load the template files and would throw an error. Finally, a presentation issue with skins with a dashboard panel trigger has been fixed as well. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'changes'	=> "* added the 1.1.1 update file
* updated the comments in the login controller
* updated jquery ui to version 1.8.5
* updated markitup plugin to version 1.1.8
* fixed bug where nova wouldn't display if the template file couldn't be found
* fixed bug where the general tour items category would be shown even if there weren't any general tour items
* fixed bug where skins with dashboard handles were showing bullets and having weird spacing issues"),
	array(
		'version' 	=> '1.1.2',
		'major' 	=> '1',
		'minor' 	=> '1',
		'update' 	=> '2',
		'date' 		=> 1287097200,
		'launch'	=> "Nova 1.1.2 is a maintenance update addressing several issues with Nova 1.1. This update fixes issues with Quick Install, an error thrown when updating a user profile and usability issues with the character picking process with writing and managing mission posts. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'changes'	=> "* added the 1.1.2 update file
* updated the form helper to extend the form\_dropdown function
* updated the write/missionpost and manage/posts pages to take saved/activated posts in to account for the author selection dropdown (thanks to Patrick for helping with this)
* fixed bug with the add author selection in manage/posts and write/missionpost (thanks to Patrick for this fix)
* fixed bug where nova would try to update a user's profile with a field that doesn't exist
* fixed bug where, under very strange circumstances, quick install wouldn't work the way it's supposed to"),
	array(
		'version' 	=> '1.2.0',
		'major' 	=> '1',
		'minor' 	=> '2',
		'update' 	=> '0',
		'date' 		=> 1292889600,
		'launch'	=> "Nova 1.2 is the second major update to Nova 1 and add new functionality to the system to help admin run their RPG even better. In addition to patching nearly two dozen bugs from Nova 1.0 and 1.1, version 1.2 adds ban controls for dealing with pesky users, deck listing improvements, contact page improvements and multiple manifests. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'changes'	=> "* added the 1.2 update file
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
		'version' 	=> '1.2.1',
		'major' 	=> '1',
		'minor' 	=> '2',
		'update' 	=> '1',
		'date' 		=> 1293121800,
		'launch'	=> "Nova 1.2.1 is the first maintenance release for Nova 1.2 and addresses several bugs discovered after the initial release of the new version. Bugs fixed in this release include a bug where positions would disappear after being updated and errors thrown throughout the system. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'changes'	=> "* added the 1.2.1 update file
* fixed bug where positions would disappear when being updated
* fixed errors thrown when trying to update character images when there aren't any images present
* fixed error thrown from the RSS feed"),
	array(
		'version' 	=> '1.2.2',
		'major' 	=> '1',
		'minor' 	=> '2',
		'update' 	=> '2',
		'date' 		=> 1293759000,
		'launch'	=> "Nova 1.2.2 is the second maintenance release for Nova 1.2 and two bugs discovered after the release of Nova 1.2.1. Bugs fixed in this release include a bug where sub departments couldn't be managed from the department management page and a bug with the display of post authors in emails. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'changes'	=> "* added the 1.2.2 update file
* fixed bug where sub departments couldn't be managed from the department management page
* fixed bug where post emails sent out didn't display the authors properly
* fixed bug in the 1.1.2 to 1.2 update file that would cause access issues"),
	array(
		'version'	=> '1.2.3',
		'major'		=> 1,
		'minor'		=> 2,
		'update'	=> 3,
		'date'		=> 1294185600,
		'launch'	=> "Nova 1.2.3 is the third maintenance release for Nova 1.2 and fixes a bug with handling deck listings with multiple specification items. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'changes'	=> "* added the 1.2.3 update file
* fixed bug with handling deck listings and multiple specification items"),
	array(
		'version'	=> '1.2.4',
		'major'		=> 1,
		'minor'		=> 2,
		'update'	=> 4,
		'date'		=> 1296000000,
		'launch'	=> "Nova 1.2.4 is the fourth maintenance release for Nova 1.2 and fixes bugs with inaccurate mission post counts (thanks to Jordan for finding this issue), the acceptance email sent out to users and a manifest issue in Internet Explorer 7. More information about these features and a full changelog can be found at AnodyneDocs. This update is recommended for all users.",
		'changes'	=> "* added the 1.2.4 update file
* updated the jquery ui to version 1.8.9
* fixed bug where nova wasn't accurately counting mission posts
* fixed bug where the user acceptance email was CCed to more people than it needed to be
* fixed bug where IE7 choked on the manifest"),
	array(
		'version'	=> '2.0.0',
		'major'		=> 2,
		'minor'		=> 0,
		'update'	=> 0,
		'date'		=> 1308949200,
		'launch'	=> "You've spoken and we've listened. The feedback we constantly get about Nova is that it's great, but it's difficult to update. Nova 2 is all about fixing that very issue. With a brand new file structure, Nova 2 has never been easier to update (simply delete one folder and replace it with one from the zip archive). In addition, Nova 2 adds new functionality to the system to help admins manage their RPG. Nova 2 is smarter than before, tracking who did and who didn't participate in a post. If someone didn't add anything to the post, they'll automatically be removed before it's posted (this feature can be turned on and off from Site Settings). In addition, Thresher has gotten a much needed boost from R1 to R2 which adds new page management and page viewing interfaces and a new category selection process that allows admins to add categories on the fly. More information about these features and everything else in Nova 2 (plus a full changelog) can be found at AnodyneDocs. This update is recommended for all users.",
		'changes'	=> "* added the message.php file to handle notification of bans, a missing \"nova\" directory and incompatible PHP version
* added new process to write the database config file for you
* added the ability to upgrade SMS Database entries to Thresher wiki pages
* added the ability for textareas to \"grow\" as more text is added like Facebook
* updated seamless substitution to be able to override email view files
* updated Thresher with a new way to create and manage categories when working on a wiki page
* updated Thresher with a completely new user experience for managing wiki pages
* updated Thresher with a brand new interface for viewing wiki pages
* updated the upload instructions to include the maximum file size and maximum image dimensions from the config file for reference
* updated to jquery version 1.6
* updated to jquery version 1.8.13
* updated to uniform version 1.7.5
* updated to prettyPhoto version 3.1.2
* updated to qTip2
* refactored the location helper into a full-blown class with static methods
* refactored the upgrade process to mirror what was created for nova 3
* removed the banned.php file
* removed the rss model since it isn't necessary any more
* fixed bug with seamless substitution of images where they wouldn't work when they were in the _base_override directory
* fixed bug with private messages where RE: and FWD: would constantly be added to message, now Nova will make sure it's only added once
* fixed bug with private messages where the person sending the message would be on the recipient list, so any message they sent would show up in their inbox as well
* fixed bug where the join form could be submitted without an email address or password"),
);

$user_prefs = array(
	array(
		'key' => 'email_new_news_comments',
		'label' => 'Email News Comments',
		'default' => 'y'),
	array(
		'key' => 'email_new_log_comments',
		'label' => 'Email Log Comments',
		'default' => 'y'),
	array(
		'key' => 'email_new_post_comments',
		'label' => 'Email Post Comments',
		'default' => 'y'),
	array(
		'key' => 'email_new_wiki_comments',
		'label' => 'Email Wiki Comments',
		'default' => 'y'),
	array(
		'key' => 'email_private_message',
		'label' => 'Email Private Messages',
		'default' => 'y'),
	array(
		'key' => 'email_personal_logs',
		'label' => 'Email Personal Logs',
		'default' => 'y'),
	array(
		'key' => 'email_news_items',
		'label' => 'Email News Items',
		'default' => 'y'),
	array(
		'key' => 'email_mission_posts',
		'label' => 'Email Mission Posts',
		'default' => 'y'),
	array(
		'key' => 'email_mission_posts_save',
		'label' => 'Email Mission Post Saved Notifications',
		'default' => 'y'),
	array(
		'key' => 'email_mission_posts_delete',
		'label' => 'Email Mission Post Delete Notifications',
		'default' => 'y'),
);
